<?php

namespace App\Http\Requests\Klinik;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHealthProfesionalTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|max:100|unique:health_profesional_types,name,'.$this->healthprofesionaltype->id
        ];
    }
}
