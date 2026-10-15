<?php

namespace Database\Seeders;

use App\Enums\Permission as PermissionEnum;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;

class KaduaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = collect(PermissionEnum::cases())
            ->map(fn (PermissionEnum $permission): Permission => Permission::findOrCreate($permission->value, 'web'));

        $administrator = Role::findOrCreate('Administrator', 'web');
        $administrator->syncPermissions($permissions);

        User::updateOrCreate(
            ['email' => 'root@kadua.id'],
            [
                'name' => 'Kadua',
                'password' => Hash::make('kadua123'),
                'email_verified_at' => now(),
            ],
        )->syncRoles($administrator);
    }
}
