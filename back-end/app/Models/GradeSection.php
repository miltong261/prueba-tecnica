<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class GradeSection extends Pivot
{
    protected $fillable = [
        'grade_id',
        'section_id'
    ];
}
