<?php

namespace App\Enums;

enum ProductType: string
{
    case Drink = 'drink';
    case Food = 'food';
    case Snack = 'snack';
    case Dessert = 'dessert';
    case Retail = 'retail';
    case Addon = 'addon';

    public function label(): string
    {
        return match ($this) {
            self::Drink => 'Drink',
            self::Food => 'Food',
            self::Snack => 'Snack',
            self::Dessert => 'Dessert',
            self::Retail => 'Retail',
            self::Addon => 'Add-on',
        };
    }
}
