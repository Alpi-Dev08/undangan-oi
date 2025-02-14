<?php

    namespace App\Http\Requests\Klinik;

    use Illuminate\Foundation\Http\FormRequest;

    class StoreDrugRequest extends FormRequest
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
                'unit_id' => 'required|exists:units,id',
                'name'    => 'required|max:100',
                'price'   => 'nullable|numeric',
                'stock'   => 'nullable|numeric',
            ];
        }
    }
