<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\TracksUserUpdates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Institution extends Model
{
    use HasFactory,
        HasUuid,
        TracksUserUpdates,
        LogsActivity;

    protected $fillable = [
        'uuid',
        'company_id',
        'name',
        'address',
        'updated_by',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                         ->logAll()
                         ->dontSubmitEmptyLogs();
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_institutions', 'user_id', 'institution_id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
