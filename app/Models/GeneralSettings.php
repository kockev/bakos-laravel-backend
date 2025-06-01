<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\LaravelSettings\Settings;
use Spatie\LaravelSettings\SettingsCasts\DateTimeInterfaceCast;

class GeneralSettings extends Settings
{
    use HasFactory;

    public Carbon $student_edit_closing_time;

    public static function group(): string
    {
        return 'general';
    }
    public static function casts(): array
    {
        return [
            'student_edit_closing_time' => DateTimeInterfaceCast::class . ':' . Carbon::class,
        ];
    }
}
