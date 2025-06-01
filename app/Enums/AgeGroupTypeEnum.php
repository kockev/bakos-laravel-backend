<?php

namespace App\Enums;

enum AgeGroupTypeEnum: string
{
    case  KINDERGARTEN = 'Kindergarten';
    case  PRIMARY_SCHOOL = 'Primary School';
    case  HIGH_SCHOOL = 'High School/Adult';

    static function values(): array
    {
        return collect(self::cases())->map(function (self $enum) {
            return $enum->value;
        })->toArray();
    }
}
