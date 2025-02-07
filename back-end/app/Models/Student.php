<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'father_name',
        'mother_name',
        'grade_id',
        'section_id',
        'enrollment_date',
        'status'
    ];

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public static function filterByGradeAndSectionScope($gradeId, $sectionId)
    {
        $studentsQuery = self::query();

        if ($gradeId) {
            $studentsQuery->where('grade_id', $gradeId);
        }

        if ($sectionId) {
            $studentsQuery->where('section_id', $sectionId);
        }

        return $studentsQuery->with(['grade:id,name', 'section:id,name'])->paginate(env('PAGINATION_SIZE', 5));
    }
}
