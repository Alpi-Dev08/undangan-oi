<?php

namespace App\Http\Requests\Klinik;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonalDiseaseHistoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'code' => 'required|string|max:255|unique:personal_disease_histories,code,'.$this->personal_disease_history->id,
            'name' => 'required|string|max:255',
            'code_system' => 'required|string|max:255',
            'value_set' => 'nullable|string',
        ];
    }
}
