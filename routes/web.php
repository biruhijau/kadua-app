<?php

use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\ProfileSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Settings\RoleManagementController;
use App\Http\Controllers\Settings\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/app');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/app', [DashboardController::class, 'index'])->middleware('permission:dashboard.view')->name('dashboard');

    /**
     * User Management
     */
    Route::get('/app/settings/users', [UserManagementController::class, 'index'])->middleware('permission:users.view')->name('settings.users.index');
    Route::get('/app/settings/users/create', [UserManagementController::class, 'create'])->middleware('permission:users.create')->name('settings.users.create');
    Route::post('/app/settings/users', [UserManagementController::class, 'store'])->middleware('permission:users.create')->name('settings.users.store');

    /**
     * User Management — Bulk Action
     *
     * Declared before the `{user}` routes so `bulk` is never captured by the
     * route model binding.
     */
    Route::delete('/app/settings/users/bulk', [UserManagementController::class, 'bulkDestroy'])->middleware('permission:users.delete')->name('settings.users.bulk-destroy');
    Route::post('/app/settings/users/bulk/block', [UserManagementController::class, 'bulkBlock'])->middleware('permission:users.update')->name('settings.users.bulk-block');
    Route::post('/app/settings/users/bulk/unblock', [UserManagementController::class, 'bulkUnblock'])->middleware('permission:users.update')->name('settings.users.bulk-unblock');

    Route::get('/app/settings/users/{user}/edit', [UserManagementController::class, 'edit'])->middleware('permission:users.update')->name('settings.users.edit');
    Route::patch('/app/settings/users/{user}', [UserManagementController::class, 'update'])->middleware('permission:users.update')->name('settings.users.update');
    Route::delete('/app/settings/users/{user}', [UserManagementController::class, 'destroy'])->middleware('permission:users.delete')->name('settings.users.destroy');
    Route::post('/app/settings/users/{user}/block', [UserManagementController::class, 'block'])->middleware('permission:users.update')->name('settings.users.block');
    Route::post('/app/settings/users/{user}/unblock', [UserManagementController::class, 'unblock'])->middleware('permission:users.update')->name('settings.users.unblock');

    /**
     * Role Management
     */
    Route::get('/app/settings/role', [RoleManagementController::class, 'index'])->middleware('permission:roles.view')->name('settings.role.index');
    Route::get('/app/settings/role/create', [RoleManagementController::class, 'create'])->middleware('permission:roles.create')->name('settings.role.create');
    Route::post('/app/settings/role', [RoleManagementController::class, 'store'])->middleware('permission:roles.create')->name('settings.role.store');
    Route::get('/app/settings/role/{role}/edit', [RoleManagementController::class, 'edit'])->middleware('permission:roles.update')->name('settings.role.edit');
    Route::patch('/app/settings/role/{role}', [RoleManagementController::class, 'update'])->middleware('permission:roles.update')->name('settings.role.update');
    Route::delete('/app/settings/role/{role}', [RoleManagementController::class, 'destroy'])->middleware('permission:roles.delete')->name('settings.role.destroy');

    /**
     * Profile Routes
     */
    Route::get('/profile', [ProfileSessionController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile/sessions/others', [ProfileSessionController::class, 'destroyOthers'])->name('profile.sessions.destroy-others');
    Route::delete('/profile/sessions/{session}', [ProfileSessionController::class, 'destroy'])->name('profile.sessions.destroy');
});

require __DIR__.'/auth.php';
