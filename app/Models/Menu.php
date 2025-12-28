<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\TracksUserUpdates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Menu extends Model
{
    use HasFactory,
        HasUuid,
        TracksUserUpdates,
        LogsActivity;

    protected $fillable = [
        'uuid',
        'name',
        'description',
        'date',
        'foods_expiration_period_in_days',
        'updated_by',
    ];

    protected $casts = [
        'date'                   => 'date',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                         ->logAll()
                         ->dontSubmitEmptyLogs();
    }

    public function foods(): BelongsToMany
    {
        return $this->belongsToMany(Food::class, 'menu_foods')
                    ->withPivot('meal_type')
                    ->withTimestamps();
    }

    public function diets(): BelongsToMany
    {
        return $this->belongsToMany(Diet::class, 'diet_menus')
                    ->withTimestamps();
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
