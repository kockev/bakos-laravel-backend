<?php

namespace App\Nova\Metrics;

use App\Models\Diet;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class TotalDietsNovaMetric extends Value
{
    public function name(): string
    {
        return 'Total Number of Diets';
    }

    public function calculate(NovaRequest $request)
    {
        return $this->result(
            Diet::count()
        );
    }

    public function formatResult($result)
    {
        // Return 0 if the result is null or 0
        return $result ?: 0;
    }
}
