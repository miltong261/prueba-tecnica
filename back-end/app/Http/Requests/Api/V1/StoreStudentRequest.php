<?php

namespace App\Http\Requests\Api\V1;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function attributes()
    {
        return [
            'first_name' => 'nombre',
            'last_name' => 'apellido',
            'date_of_birth' => 'fecha de nacimiento',
            'father_name' => 'nombre del padre',
            'mother_name' => 'nombre de la madre',
            'grade_id' => 'grado',
            'section_id' => 'sección',
            'enrollment_date' => 'fecha de inscripción',
            'status' => 'estado'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'grade_id' => 'required|exists:grades,id',
            'section_id' => 'required|exists:sections,id',
            'enrollment_date' => 'required|date',
            'status' => 'required|in:activo,inactivo,suspendido'
        ];
    }
}
