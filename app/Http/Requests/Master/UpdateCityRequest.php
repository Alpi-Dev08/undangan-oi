<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCityRequest extends FormRequest
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
            'country_id' => 'required',
            'province_id' => 'required',
            'area_code' => 'nullable|unique:cities,area_code,'.$this->city->id,
            'name' => 'required|max:100|unique:cities,name,'.$this->city->id
        ];
    }
}
