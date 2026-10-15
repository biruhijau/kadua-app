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

    public function feature(): string
    {
        return match ($this) {
            self::DashboardView => 'Beranda',
            self::UsersView, self::UsersCreate, self::UsersUpdate, self::UsersDelete => 'Pengguna',
            self::RolesView, self::RolesCreate, self::RolesUpdate, self::RolesDelete => 'Peran',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::DashboardView, self::UsersView, self::RolesView => 'Lihat',
            self::UsersCreate, self::RolesCreate => 'Buat',
            self::UsersUpdate, self::RolesUpdate => 'Edit',
            self::UsersDelete, self::RolesDelete => 'Hapus',
        };
    }
}
