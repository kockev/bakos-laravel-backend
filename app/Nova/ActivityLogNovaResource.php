<?php

namespace App\Nova;

use Bolechen\NovaActivitylog\Resources\Activitylog as ActivityLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Http\Requests\NovaRequest;

class ActivityLogNovaResource extends ActivityLog
{
    public function fields(NovaRequest $request)
    {
        $parentFields = parent::fields($request);

        // Override Created At field
        $customizedFields = collect($parentFields)->map(function ($field) {
            if ($field->attribute === 'created_at') {
                return DateTime::make('Created At', 'created_at')
                               ->displayUsing(fn(?Carbon $date) => $date?->toDateTimeString())
                               ->readonly();
            }

            return $field;
        });

        return $customizedFields->toArray();
    }

    public function authorizedToUpdate(Request $request): bool
    {
        return false;
    }

    public function authorizedToDelete(Request $request): bool
    {
        return false;
    }

    public function authorizedToReplicate(Request $request): bool
    {
        return false;
    }
}
