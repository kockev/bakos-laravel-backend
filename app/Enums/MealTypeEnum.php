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

    public static function label(string|self $mealType): string
    {
        // If we got a string, convert to enum case
        if (is_string($mealType)) {
            $mealType = self::tryFrom($mealType);
        }

        if (!$mealType instanceof self) {
            return $mealType;
        }

        return match ($mealType) {
            self::LUNCH_SOUP => 'Leves',
            self::LUNCH_MAIN => 'Főétel',
            self::LUNCH_OTHER_1 => 'Egyéb 1',
            self::LUNCH_OTHER_2 => 'Egyéb 2',
            self::BRUNCH => 'Tízórai',
            self::SNACK => 'Uzsonna',
        };
    }
}
