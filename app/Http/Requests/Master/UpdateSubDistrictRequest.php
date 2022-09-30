<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubDistrictRequest extends FormRequest
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
            'country_id'   => 'required',
            'province_id' => 'required',
            'city_id'     => 'required',
            'district_id' => 'required',
            'area_code'   => 'nullable|unique:sub_districts,area_code,' . $this->subdistrict->id,
            'name'        => 'required|max:100|unique:sub_districts,name,' . $this->subdistrict->id,
            'postal_code' => 'numeric'
        ];
    }
}
