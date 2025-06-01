<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\ActiveStudentNovaMetric;
use App\Nova\Metrics\DietPerStudentNovaMetric;
use App\Nova\Metrics\InactiveStudentNovaMetric;
use App\Support\Permissions;
use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
{
    /**
     * Get the displayable name of the dashboard.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Dashboard';
    }

    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        if (auth()->user()->hasPermissionTo(Permissions::VIEW_DASHBOARD)) {
            return [
                (new ActiveStudentNovaMetric())->width('1/4'),
                (new InactiveStudentNovaMetric())->width('1/4'),
                (new DietPerStudentNovaMetric())->width('1/2'),
            ];
        }

        return [];
    }
}
