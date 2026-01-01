<?php

namespace App\Enums;

enum AgeGroupTypeEnum: string
{
    case  DAYCARE = 'Daycare';
    case  KINDERGARTEN = 'Kindergarten';
    case  PRIMARY_SCHOOL = 'Primary School';
    case  HIGH_SCHOOL = 'High School';
    case  ADULT = 'Adult';

    static function values(): array
    {
        return collect(self::cases())->map(function (self $enum) {
            return $enum->value;
        })->toArray();
    }
}
