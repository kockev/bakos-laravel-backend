<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\ActiveMenusTodayNovaMetric;
use App\Nova\Metrics\ActiveStudentNovaMetric;
use App\Nova\Metrics\DietPerStudentNovaMetric;
use App\Nova\Metrics\InactiveStudentNovaMetric;
use App\Nova\Metrics\TotalDietsNovaMetric;
use App\Support\Permissions;
use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
{
    public function name(): string
    {
        return 'Dashboard';
    }

    public function cards()
    {
        if (auth()->user()->hasPermissionTo(Permissions::VIEW_DASHBOARD)) {
            return [
                (new ActiveStudentNovaMetric())->width('1/4'),
                (new InactiveStudentNovaMetric())->width('1/4'),
                (new DietPerStudentNovaMetric())->width('1/2'),
                (new TotalDietsNovaMetric())->width('1/4'),
                (new ActiveMenusTodayNovaMetric())->width('1/4'),
            ];
        }

        return [];
    }
}
