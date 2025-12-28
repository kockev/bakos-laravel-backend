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

class KitchenOrder extends Model implements HasMedia
{
    use HasFactory,
        HasUuid,
        TracksUserUpdates,
        LogsActivity,
        InteractsWithMedia;

    const KITCHEN_ORDER_BIG_MEAL_PDF   = 'kitchen-order-big-meal-pdf';
    const KITCHEN_ORDER_SMALL_MEAL_PDF = 'kitchen-order-small-meal-pdf';
    const STICKERS_XLS                 = 'stickers-xls';

    protected $fillable = [
        'uuid',
        'name',
        'cooking_date',
        'updated_by',
    ];

    protected $casts = [
        'cooking_date' => 'date',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                         ->logAll()
                         ->dontSubmitEmptyLogs();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::KITCHEN_ORDER_BIG_MEAL_PDF)
             ->singleFile()
             ->useDisk(Disk::PUBLIC);

        $this->addMediaCollection(self::KITCHEN_ORDER_SMALL_MEAL_PDF)
             ->singleFile()
             ->useDisk(Disk::PUBLIC);

        $this->addMediaCollection(self::STICKERS_XLS)
             ->singleFile()
             ->useDisk(Disk::PUBLIC);
    }

    public function kitchenOrderFoods(): HasMany
    {
        return $this->hasMany(KitchenOrderFood::class);
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
