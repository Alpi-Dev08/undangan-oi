<?php

namespace App\Http\Requests\Klinik;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonalDiseaseHistoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'code_system' => 'required|string|max:255',
            'value_set' => 'nullable|string',
        ];
    }
}
