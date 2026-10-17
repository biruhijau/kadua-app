<?php

namespace App\Services;

use App\Models\NumberSequence;
use Illuminate\Support\Facades\DB;

class NumberSequenceService
{
    public function next(string $key, string $prefix = 'KADUA-PRD-'): string
    {
        return DB::transaction(function () use ($key, $prefix) {
            $s = NumberSequence::query()->lockForUpdate()->firstOrCreate(['key' => $key], ['prefix' => $prefix, 'next_number' => 1]);
            $number = $s->next_number;
            $s->increment('next_number');

            return $s->prefix.str_pad((string) $number, 4, '0', STR_PAD_LEFT);
        });
    }
}
