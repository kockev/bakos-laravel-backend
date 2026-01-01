<?php

namespace App\Models;

use App\Enums\AgeGroupTypeEnum;
use App\Traits\HasUuid;
use App\Traits\TracksUserUpdates;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Student extends Model
{
    use HasFactory,
        HasUuid,
        TracksUserUpdates,
        LogsActivity;

    protected $fillable = [
        'uuid',
        'institution_id',
        'name',
        'age_group',
        'diet_id',
        'diet_certificate_valid_until',
        'updated_by',
    ];

    protected $casts = [
        'age_group'                    => AgeGroupTypeEnum::class,
        'diet_certificate_valid_until' => 'date',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                         ->logAll()
                         ->dontSubmitEmptyLogs();
    }

    public function isActive(): bool
    {
        $today = Carbon::today();

        return !$this->inactivePeriods()
                     ->where('inactive_from', '<=', $today)
                     ->where('inactive_to', '>=', $today)
                     ->exists();
    }

    public function isCertificationDocumentValid(): bool
    {
        $today = Carbon::today();

        if (!is_null($this->diet_certificate_valid_until)) {
            if ($today > $this->diet_certificate_valid_until) {
                return false;
            }
        }

        return true;
    }

    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class);
    }

    public function diet(): BelongsTo
    {
        return $this->belongsTo(Diet::class);
    }

    public function mealPreferences(): HasMany
    {
        return $this->hasMany(StudentMealPreference::class, 'student_id');
    }

    public function inactivePeriods(): HasMany
    {
        return $this->hasMany(StudentInactivePeriod::class)->orderBy('inactive_from', 'desc');;
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
