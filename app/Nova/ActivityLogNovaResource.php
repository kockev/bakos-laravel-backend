<?php

namespace App\Nova;

use Bolechen\NovaActivitylog\Resources\Activitylog as ActivityLog;
use Illuminate\Http\Request;

class ActivityLogNovaResource extends ActivityLog
{
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
