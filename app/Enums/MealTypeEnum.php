<?php

namespace App\Enums;

enum MealTypeEnum: string
{
    case  BRUNCH = 'Brunch';
    case  LUNCH_SOUP = 'Lunch Soup';
    case  LUNCH_MAIN = 'Lunch Main';
    case  LUNCH_OTHER_1 = 'Lunch Other 1';
    case  LUNCH_OTHER_2 = 'Lunch Other 2';
    case  SNACK = 'Snack';

    static function values(): array
    {
        return collect(self::cases())->map(function (self $enum) {
            return $enum->value;
        })->toArray();
    }
}
