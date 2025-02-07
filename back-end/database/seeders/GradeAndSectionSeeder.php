<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradeAndSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grades = [
            ['name' => 'Primero'],
            ['name' => 'Segundo'],
            ['name' => 'Tercero'],
            ['name' => 'Cuarto'],
            ['name' => 'Quinto'],
            ['name' => 'Sexto'],
            ['name' => 'Primero básico'],
            ['name' => 'Segundo básico'],
            ['name' => 'Tercero básico'],
            ['name' => 'Cuarto bachillerato'],
            ['name' => 'Quinto bachillerato']
        ];

        foreach ($grades as $grade) {
            \App\Models\Grade::create($grade);
        }

        $sections = [
            ['name' => 'A'],
            ['name' => 'B'],
            ['name' => 'C']
        ];

        foreach ($sections as $section) {
            \App\Models\Section::create($section);
        }

        foreach (\App\Models\Grade::all() as $grade) {
            $sectionIds = \App\Models\Section::pluck('id');

            $grade->sections()->attach($sectionIds);
        }
    }
}
