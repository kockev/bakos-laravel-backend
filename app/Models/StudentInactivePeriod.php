<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentInactivePeriod extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'inactive_from',
        'inactive_to',
    ];

    protected $casts = [
        'inactive_from' => 'date',
        'inactive_to'   => 'date',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
