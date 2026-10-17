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
    case CategoriesView = 'categories.view';
    case CategoriesCreate = 'categories.create';
    case CategoriesUpdate = 'categories.update';
    case CategoriesDelete = 'categories.delete';
    case ProductsView = 'products.view';
    case ProductsCreate = 'products.create';
    case ProductsUpdate = 'products.update';
    case ProductsDelete = 'products.delete';

    public function feature(): string
    {
        return match ($this) {
            self::DashboardView => 'Beranda',
            self::UsersView, self::UsersCreate, self::UsersUpdate, self::UsersDelete => 'Pengguna',
            self::RolesView, self::RolesCreate, self::RolesUpdate, self::RolesDelete => 'Peran',
            self::CategoriesView, self::CategoriesCreate, self::CategoriesUpdate, self::CategoriesDelete => 'Kategori',
            self::ProductsView, self::ProductsCreate, self::ProductsUpdate, self::ProductsDelete => 'Produk',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::DashboardView, self::UsersView, self::RolesView => 'Lihat',
            self::UsersCreate, self::RolesCreate => 'Buat',
            self::UsersUpdate, self::RolesUpdate => 'Edit',
            self::UsersDelete, self::RolesDelete => 'Hapus',
            self::CategoriesView => 'Lihat',
            self::CategoriesCreate => 'Buat',
            self::CategoriesUpdate => 'Edit',
            self::CategoriesDelete => 'Hapus',
            self::ProductsView => 'Lihat',
            self::ProductsCreate => 'Buat',
            self::ProductsUpdate => 'Edit',
            self::ProductsDelete => 'Hapus',
        };
    }
}
