<?php

namespace App\Nova\Metrics;

use App\Models\Menu;
use Carbon\Carbon;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class ActiveMenusTodayNovaMetric extends Value
{
    public function name(): string
    {
        return 'Number of Active Menus Today';
    }

    public function calculate(NovaRequest $request)
    {
        $today = Carbon::today();

        return $this->result(
            Menu::whereDate('date', $today)->count()
        );
    }

    public function formatResult($result)
    {
        // Return 0 if the result is null or 0
        return $result ?: 0;
    }
}
