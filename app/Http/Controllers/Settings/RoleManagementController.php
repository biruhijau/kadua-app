<?php

namespace App\Http\Controllers\Settings;

use App\Actions\Settings\CreateRoleAction;
use App\Actions\Settings\DeleteRoleAction;
use App\Actions\Settings\UpdateRoleAction;
use App\Enums\Permission as PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\StoreRoleRequest;
use App\Http\Requests\Settings\UpdateRoleRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoleManagementController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();

        return view('pages.settings.role.index', [
            'roles' => Role::query()
                ->withCount(['permissions', 'users'])
                ->when($search !== '', fn($query) => $query->where('name', 'like', "%{$search}%"))
                ->latest()
                ->paginate(15)
                ->withQueryString(),
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('pages.settings.role.create', ['permissionGroups' => $this->permissionGroups()]);
    }

    public function store(StoreRoleRequest $request, CreateRoleAction $create): RedirectResponse
    {
        $create->handle($request->validated('name'), $request->validated('permissions', []));

        return to_route('settings.role.index')->with('status', 'role-created');
    }

    public function edit(Role $role): View
    {
        return view('pages.settings.role.edit', [
            'role' => $role->load('permissions'),
            'permissionGroups' => $this->permissionGroups(),
        ]);
    }

    public function update(UpdateRoleRequest $request, Role $role, UpdateRoleAction $update): RedirectResponse
    {
        $update->handle($role, $request->validated('name'), $request->validated('permissions', []));

        return to_route('settings.role.index')->with('status', 'role-updated');
    }

    public function destroy(Role $role, DeleteRoleAction $delete): RedirectResponse
    {
        $delete->handle($role);

        return to_route('settings.role.index')->with('status', 'role-deleted');
    }

    /** @return array<string, array{label: string, permissions: array<string, array{id: string, name: string, label: string}>}> */
    private function permissionGroups(): array
    {
        $permissions = Permission::query()->pluck('id', 'name');

        return collect(PermissionEnum::cases())
            ->groupBy(fn(PermissionEnum $permission): string => $permission->feature())
            ->map(fn($featurePermissions, string $feature): array => [
                'label' => $feature,
                'permissions' => $featurePermissions
                    ->map(fn(PermissionEnum $permission): array => [
                        'id' => $permissions[$permission->value] ?? null,
                        'name' => $permission->value,
                        'label' => $permission->label(),
                    ])
                    ->filter(fn(array $permission): bool => $permission['id'] !== null)
                    ->values()
                    ->all(),
            ])
            ->all();
    }
}
