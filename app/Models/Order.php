<?php

namespace App\Models;

use App\Support\Disk;
use App\Traits\HasUuid;
use App\Traits\TracksUserUpdates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Order extends Model implements HasMedia
{
    use HasFactory,
        HasUuid,
        TracksUserUpdates,
        LogsActivity,
        InteractsWithMedia;

    const ORDER_INSTITUTION_BIG_MEAL_PDF   = 'order-institution-big-meal-pdf';
    const ORDER_INSTITUTION_SMALL_MEAL_PDF = 'order-institution-small-meal-pdf';

    protected $fillable = [
        'uuid',
        'name',
        'institution_id',
        'order_date',
        'updated_by',
    ];

    protected $casts = [
        'order_date' => 'date',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                         ->logAll()
                         ->dontSubmitEmptyLogs();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::ORDER_INSTITUTION_SMALL_MEAL_PDF)
             ->singleFile()
             ->useDisk(Disk::PUBLIC);

        $this->addMediaCollection(self::ORDER_INSTITUTION_BIG_MEAL_PDF)
             ->singleFile()
             ->useDisk(Disk::PUBLIC);
    }

    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class);
    }

    public function orderStudents(): HasMany
    {
        return $this->hasMany(OrderStudent::class);
    }

    public function orderFoods(): HasMany
    {
        return $this->hasMany(OrderFood::class);
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
