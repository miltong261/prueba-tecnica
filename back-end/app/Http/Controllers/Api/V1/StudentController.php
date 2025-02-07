<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\Api\V1\StoreStudentRequest;
use App\Http\Requests\Api\V1\UpdateStudentRequest;
use App\Http\Resources\Api\V1\StudentResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Obtener el listado de estudiantes filtrado por grado y sección.
     *
     * Este método permite recuperar el listado de estudiantes, filtrado por el grado y la sección
     * especificados en los parámetros. Si no se proporcionan los parámetros, se devuelve el listado completo.
     * El resultado se formatea para incluir la información de la página actual, la cantidad de elementos por página
     * y el total de estudiantes disponibles.
     *
     * @param  string|null  $gradeId
     * @param  string|null  $sectionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(string $gradeId = null, string $sectionId = null) {
        try {
            $students = Student::filterByGradeAndSectionScope($gradeId, $sectionId);

            $formattedData = [
                'students' => StudentResource::collection($students),
                'current_page' => $students->currentPage(),
                'per_page' => $students->perPage(),
                'total' => $students->total(),
            ];

            return response()->success('Listado de estudiantes', $formattedData);

        } catch (\Throwable $th) {
            return response()->error('Se produjo un error al recuperar el listado de estudiantes', $th->getMessage());
        }
    }

    /**
     * Ingresar información de un estudiante.
     *
     * Este método recibe una solicitud para ingresar los datos de un estudiante
     *
     * @param  \App\Http\Requests\Api\V1\StoreStudentRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreStudentRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();

            $student = Student::create($data);

            DB::commit();

            return response()->success('Información del estudiante ingresada exitosamente', ['student' => new StudentResource($student)], 201);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->error('Se produjo un error al crear información del estudiante', $th->getMessage());
        }

    }

    /**
     * Actualizar la información de un estudiante.
     *
     * Este método recibe una solicitud para actualizar los datos de un estudiante específico
     * identificado por su `$id`. Si el estudiante existe, se valida y actualiza la información.
     *
     * @param  \App\Http\Requests\Api\V1\UpdateStudentRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateStudentRequest $request, string $id)
    {
        DB::beginTransaction();

        try {
            $student = Student::findOrFail($id);

            $data = $request->validated();

            $student->update($data);

            DB::commit();

            return response()->success('Información del estudiante actualizada exitosamente', ['student' => new StudentResource($student)]);
        } catch(ModelNotFoundException $e) {
            return response()->error('Estudiante no encontrado', $e->getMessage(), 404);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->error('Se produjo un error al actualizar información del estudiante', $th->getMessage());
        }
    }
}
