<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\ProfileSessionController;
use App\Http\Controllers\Settings\PermissionsManagementController;
use App\Http\Controllers\Settings\RoleManagementController;
use App\Http\Controllers\Settings\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/app');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/app', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/app/settings/users', [UserManagementController::class, 'index'])->name('settings.users.index');
    Route::get('/app/settings/role', [RoleManagementController::class, 'index'])->name('settings.role.index');
    Route::get('/app/settings/permissions', [PermissionsManagementController::class, 'index'])->name('settings.permissions.index');
    Route::get('/profile', [ProfileSessionController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile/sessions/others', [ProfileSessionController::class, 'destroyOthers'])->name('profile.sessions.destroy-others');
    Route::delete('/profile/sessions/{session}', [ProfileSessionController::class, 'destroy'])->name('profile.sessions.destroy');
});

require __DIR__.'/auth.php';
