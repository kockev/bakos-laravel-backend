<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait TracksUserUpdates
{
    public static function bootTracksUserUpdates()
    {
        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
            }
        });

        static::creating(function ($model) {
            if (Auth::check() && !$model->updated_by) {
                $model->updated_by = Auth::id();
            }
        });
    }
}
