<?php

namespace App\Http\Controllers\Settings;

use App\Actions\Settings\CreateUserAction;
use App\Actions\Settings\DeleteUserAction;
use App\Actions\Settings\UpdateUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\StoreUserRequest;
use App\Http\Requests\Settings\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();
        $role = $request->string('role')->trim()->toString();

        return view('pages.settings.user.index', [
            'users' => User::query()
                ->select(['id', 'name', 'email', 'email_verified_at', 'created_at'])
                ->with('roles:id,name')
                ->when($search !== '', fn ($query) => $query->where(fn ($query) => $query->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%")))
                ->when($role !== '', fn ($query) => $query->role($role))
                ->latest()
                ->paginate(15)
                ->withQueryString(),
            'roles' => Role::query()->orderBy('name')->get(['id', 'name']),
            'search' => $search,
            'role' => $role,
        ]);
    }

    public function create(): View
    {
        return view('pages.settings.user.create', ['roles' => Role::query()->orderBy('name')->get(['id', 'name'])]);
    }

    public function store(StoreUserRequest $request, CreateUserAction $create): RedirectResponse
    {
        $data = $request->validated();
        $roles = $data['roles'] ?? [];
        unset($data['roles'], $data['password_confirmation']);

        $create->handle($data, $roles);

        return to_route('settings.users.index')->with('status', 'user-created');
    }

    public function edit(User $user): View
    {
        return view('pages.settings.user.edit', [
            'user' => $user->load('roles'),
            'roles' => Role::query()->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function update(UpdateUserRequest $request, User $user, UpdateUserAction $update): RedirectResponse
    {
        $data = $request->validated();
        $roles = $data['roles'] ?? [];
        unset($data['roles'], $data['password_confirmation']);

        if ($data['password'] === null || $data['password'] === '') {
            unset($data['password']);
        }

        $update->handle($user, $data, $roles);

        return to_route('settings.users.index')->with('status', 'user-updated');
    }

    public function destroy(User $user, DeleteUserAction $delete): RedirectResponse
    {
        $delete->handle($user);

        return to_route('settings.users.index')->with('status', 'user-deleted');
    }
}
