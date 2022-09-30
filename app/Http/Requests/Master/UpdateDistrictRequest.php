<?php

    namespace App\Http\Requests\Master;

    use Illuminate\Foundation\Http\FormRequest;

    class UpdateDistrictRequest extends FormRequest
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
                'area_code'   => 'nullable|unique:districts,area_code,' . $this->district->id,
                'name'        => 'required|max:100|unique:districts,name,' . $this->district->id
            ];
        }
    }
