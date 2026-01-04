<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\TracksUserUpdates;
use CubeAgency\NovaGoogle2fa\Traits\HasGoogle2fa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable,
        HasFactory,
        HasUuid,
        TracksUserUpdates,
        LogsActivity,
        HasRoles,
        HasGoogle2fa;

    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'updated_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                         ->logAll()
                         ->dontSubmitEmptyLogs();
    }

    public function institutions(): BelongsToMany
    {
        return $this->belongsToMany(Institution::class, 'user_institutions', 'user_id', 'institution_id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
