<?php

use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\ProfileSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Master\ProductCategoryController;
use App\Http\Controllers\Settings\RoleManagementController;
use App\Http\Controllers\Settings\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/app');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/app', [DashboardController::class, 'index'])->middleware('permission:dashboard.view')->name('dashboard');

    /**
     * Product Category Management
     */
    Route::get('/app/master/product-categories', [ProductCategoryController::class, 'index'])->middleware('permission:product-categories.view')->name('master.product-categories.index');
    Route::get('/app/master/product-categories/create', [ProductCategoryController::class, 'create'])->middleware('permission:product-categories.create')->name('master.product-categories.create');
    Route::post('/app/master/product-categories', [ProductCategoryController::class, 'store'])->middleware('permission:product-categories.create')->name('master.product-categories.store');
    Route::delete('/app/master/product-categories/bulk', [ProductCategoryController::class, 'bulkDestroy'])->middleware('permission:product-categories.delete')->name('master.product-categories.bulk-destroy');
    Route::get('/app/master/product-categories/{productCategory}/edit', [ProductCategoryController::class, 'edit'])->middleware('permission:product-categories.update')->name('master.product-categories.edit')->where('productCategory', '[0-9a-fA-F-]{36}');
    Route::patch('/app/master/product-categories/{productCategory}', [ProductCategoryController::class, 'update'])->middleware('permission:product-categories.update')->name('master.product-categories.update')->where('productCategory', '[0-9a-fA-F-]{36}');
    Route::delete('/app/master/product-categories/{productCategory}', [ProductCategoryController::class, 'destroy'])->middleware('permission:product-categories.delete')->name('master.product-categories.destroy')->where('productCategory', '[0-9a-fA-F-]{36}');

    /**
     * User Management
     */
    Route::get('/app/settings/users', [UserManagementController::class, 'index'])->middleware('permission:users.view')->name('settings.users.index');
    Route::get('/app/settings/users/create', [UserManagementController::class, 'create'])->middleware('permission:users.create')->name('settings.users.create');
    Route::post('/app/settings/users', [UserManagementController::class, 'store'])->middleware('permission:users.create')->name('settings.users.store');
    Route::get('/app/settings/users/{user}/edit', [UserManagementController::class, 'edit'])->middleware('permission:users.update')->name('settings.users.edit')->where('user', '[0-9a-fA-F-]{36}');
    Route::patch('/app/settings/users/{user}', [UserManagementController::class, 'update'])->middleware('permission:users.update')->name('settings.users.update')->where('user', '[0-9a-fA-F-]{36}');
    Route::delete('/app/settings/users/{user}', [UserManagementController::class, 'destroy'])->middleware('permission:users.delete')->name('settings.users.destroy')->where('user', '[0-9a-fA-F-]{36}');
    Route::post('/app/settings/users/{user}/block', [UserManagementController::class, 'block'])->middleware('permission:users.update')->name('settings.users.block')->where('user', '[0-9a-fA-F-]{36}');
    Route::post('/app/settings/users/{user}/unblock', [UserManagementController::class, 'unblock'])->middleware('permission:users.update')->name('settings.users.unblock')->where('user', '[0-9a-fA-F-]{36}');
    Route::delete('/app/settings/users/bulk', [UserManagementController::class, 'bulkDestroy'])->middleware('permission:users.delete')->name('settings.users.bulk-destroy');
    Route::post('/app/settings/users/bulk/block', [UserManagementController::class, 'bulkBlock'])->middleware('permission:users.update')->name('settings.users.bulk-block');
    Route::post('/app/settings/users/bulk/unblock', [UserManagementController::class, 'bulkUnblock'])->middleware('permission:users.update')->name('settings.users.bulk-unblock');

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
