<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\TracksUserUpdates;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Diet extends Model
{
    use HasFactory,
        HasUuid,
        TracksUserUpdates,
        LogsActivity;

    protected $fillable = [
        'uuid',
        'name',
        'description',
        'updated_by',
    ];

    public function hasMenuToday(): bool
    {
        return $this->menus()
                    ->where('date', Carbon::today())
                    ->exists();
    }

    public function hasMenuForDate(Carbon $date): bool
    {
        return $this->menus()
                    ->where('date', $date->format('Y-m-d'))
                    ->exists();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                         ->logAll()
                         ->dontSubmitEmptyLogs();
    }

    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(Menu::class, 'diet_menus')
                    ->withTimestamps();
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
