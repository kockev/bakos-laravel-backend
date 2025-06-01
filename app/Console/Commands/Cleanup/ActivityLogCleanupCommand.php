<?php

namespace App\Console\Commands\Cleanup;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Spatie\Activitylog\Models\Activity;

class ActivityLogCleanupCommand extends Command
{
    protected $signature   = 'cleanup:activity-logs';
    protected $description = 'Deletes activity logs older than 2 months';

    public function handle()
    {
        $this->info('Starting to deleting outdated activity logs...');

        Activity::query()
                ->where('created_at', '<', Carbon::now()->subMonth(2))
                ->chunkById(1000, function ($logs) {
                    foreach ($logs as $log) {
                        $log->delete();
                    }
                });

        $this->info('Activity logs deletion finished.');
    }
}
