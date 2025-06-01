<?php

namespace App\Nova\Metrics;

use App\Models\Student;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;
use Laravel\Nova\Metrics\PartitionResult;

class DietPerStudentNovaMetric extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return PartitionResult
     */
    public function calculate(NovaRequest $request): PartitionResult
    {
        $results = Student::query()
                          ->join('diets', 'students.diet_id', '=', 'diets.id')
                          ->selectRaw('diets.name as dietName, COUNT(students.id) as studentCount')
                          ->groupBy('diets.name')
                          ->get()
                          ->mapWithKeys(function ($dataItem) {
                              return [$dataItem->dietName => $dataItem->studentCount];
                          })
                          ->toArray();

        return $this->result($results);
    }

}
