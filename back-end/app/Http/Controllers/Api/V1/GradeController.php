<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Obtener la lista de grados y secciones.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGradesAndSections()
    {
        try {
            $gradesWithSections = Grade::gradeAndSectionsWithoutPivotScope();

            return response()->success('Lista de grados y secciones', ['grades' => $gradesWithSections]);
        } catch (\Throwable $th) {
            return response()->error('Se produjo un error al recuperar la lista de grados y secciones', $th->getMessage());
        }
    }
}
