<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = ['name'];

    public function grades()
    {
        return $this->belongsToMany(Grade::class, 'grade_section', 'section_id', 'grade_id');
    }
}
