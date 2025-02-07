<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = ['name'];

    public function sections()
    {
        return $this->belongsToMany(Section::class, 'grade_section', 'grade_id', 'section_id');
    }

    public static function gradeAndSectionsWithoutPivotScope()
    {
        $grades = self::select('id', 'name')
            ->with(['sections' => function($query) {
                $query->select('sections.id', 'sections.name');
            }])->get();

        $gradesWithSections = $grades->filter(function ($grade) {
            $grade->sections->makeHidden('pivot');
            return $grade->sections->isNotEmpty();
        });

        return $gradesWithSections;
    }
}
