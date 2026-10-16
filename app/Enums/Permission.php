<?php

namespace App\Enums;

enum Permission: string
{
    case DashboardView = 'dashboard.view';
    case UsersView = 'users.view';
    case UsersCreate = 'users.create';
    case UsersUpdate = 'users.update';
    case UsersDelete = 'users.delete';
    case RolesView = 'roles.view';
    case RolesCreate = 'roles.create';
    case RolesUpdate = 'roles.update';
    case RolesDelete = 'roles.delete';
    case ProductCategoriesView = 'product-categories.view';
    case ProductCategoriesCreate = 'product-categories.create';
    case ProductCategoriesUpdate = 'product-categories.update';
    case ProductCategoriesDelete = 'product-categories.delete';

    public function feature(): string
    {
        return match ($this) {
            self::DashboardView => 'Beranda',
            self::UsersView, self::UsersCreate, self::UsersUpdate, self::UsersDelete => 'Pengguna',
            self::RolesView, self::RolesCreate, self::RolesUpdate, self::RolesDelete => 'Peran',
            self::ProductCategoriesView, self::ProductCategoriesCreate, self::ProductCategoriesUpdate, self::ProductCategoriesDelete => 'Kategori Produk',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::DashboardView, self::UsersView, self::RolesView => 'Lihat',
            self::UsersCreate, self::RolesCreate => 'Buat',
            self::UsersUpdate, self::RolesUpdate => 'Edit',
            self::UsersDelete, self::RolesDelete => 'Hapus',
            self::ProductCategoriesView => 'Lihat',
            self::ProductCategoriesCreate => 'Buat',
            self::ProductCategoriesUpdate => 'Edit',
            self::ProductCategoriesDelete => 'Hapus',
        };
    }
}
