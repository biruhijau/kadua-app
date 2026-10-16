<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'description', 'is_active'])]
class Category extends Model
{
    use HasFactory, HasUuids;

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }
}
