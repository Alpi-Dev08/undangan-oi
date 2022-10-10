<?php

    namespace App\Http\Requests\Klinik;

    use Illuminate\Foundation\Http\FormRequest;

    class StoreHealthcareRequest extends FormRequest
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
                'name'                   => 'required|max:100|unique:healthcares',
                'healthcare_category_id' => 'nullable|integer|exists:healthcare_categories,id',
                'healthcare_type_id'     => 'nullable|integer|exists:healthcare_types,id',
                'country_id'             => 'nullable|integer|exists:countries,id',
                'province_id'            => 'nullable|integer|exists:provinces,id',
                'city_id'                => 'nullable|integer|exists:cities,id',
                'district_id'            => 'nullable|integer|exists:districts,id',
                'sub_district_id'        => 'nullable|integer|exists:sub_districts,id',
                'email'                  => 'nullable|string|max:255',
                'phone'                  => 'nullable|string|max:255',
                'website'                => 'nullable|string|max:255',
                'address'                => 'nullable|string',
                'postal_code'            => 'nullable|integer',
            ];
        }
    }
