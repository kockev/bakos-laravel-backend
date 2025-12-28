<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\TracksUserUpdates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class OrderFood extends Model
{
    use HasFactory,
        HasUuid,
        TracksUserUpdates,
        LogsActivity;

    protected $table = 'order_foods';

    protected $fillable = [
        'uuid',
        'order_id',
        'meal_type',
        'food_code',
        'food_name',
        'allergens',
        'quantity',
        'food_expiration_date',
        'updated_by',
    ];

    protected $casts = [
        'food_expiration_date' => 'date',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                         ->logAll()
                         ->dontSubmitEmptyLogs();
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
