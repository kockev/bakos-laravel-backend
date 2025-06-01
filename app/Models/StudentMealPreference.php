<?php

namespace App\Models;

use App\Enums\MealTypeEnum;
use App\Traits\TracksUserUpdates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class StudentMealPreference extends Model
{
    use HasFactory,
        TracksUserUpdates,
        LogsActivity;

    protected $fillable = [
        'student_id',
        'meal_type',
        'updated_by',
    ];

    protected $casts = [
        'meal_type' => MealTypeEnum::class,
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                         ->logAll()
                         ->dontSubmitEmptyLogs();
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
