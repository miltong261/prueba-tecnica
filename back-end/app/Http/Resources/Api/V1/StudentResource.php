<?php

namespace App\Http\Resources\Api\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'complete_name' => "{$this->first_name} {$this->last_name}",
            'date_of_birth' => $this->date_of_birth,
            'date_of_birth_formatted' => Carbon::parse($this->date_of_birth)->translatedFormat('d \d\e F \d\e Y'),
            'father_name' => $this->father_name,
            'mother_name' => $this->mother_name,
            'grade_id' => $this->grade_id,
            'grade' => [
                'id' => $this->grade->id,
                'name' => $this->grade->name,
            ],
            'section_id' => $this->section_id,
            'section' => [
                'id' => $this->section->id,
                'name' => $this->section->name,
            ],
            'enrollment_date' => $this->enrollment_date,
            'enrollment_date_formatted' => Carbon::parse($this->enrollment_date)->translatedFormat('d \d\e F \d\e Y'),
            'status' => $this->status
        ];
    }
}
