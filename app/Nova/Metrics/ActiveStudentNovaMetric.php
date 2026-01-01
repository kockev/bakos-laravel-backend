<?php

namespace App\Nova\Metrics;

use App\Models\Student;
use Carbon\Carbon;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class ActiveStudentNovaMetric extends Value
{
    /**
     * Get the displayable name of the dashboard.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Active Students Today';
    }

    /**
     * Calculate the value of the metric.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $today = Carbon::today();

        return $this->result(
            Student::whereDoesntHave('inactivePeriods', function ($query) use ($today) {
                $query->where('inactive_from', '<=', $today)
                      ->where('inactive_to', '>=', $today);
            })->count()
        );
    }

    /**
     * Format the result to avoid "No Data" text.
     */
    public function formatResult($result)
    {
        // Return 0 if the result is null or 0
        return $result ?: 0;
    }
}
