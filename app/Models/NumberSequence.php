<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['key', 'prefix', 'next_number'])]
class NumberSequence extends Model
{
    use HasUuids;

    protected function casts(): array
    {
        return ['next_number' => 'integer'];
    }
}
