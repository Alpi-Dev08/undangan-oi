<?php

    namespace App\Http\Requests\Klinik;

    use Illuminate\Foundation\Http\FormRequest;

    class UpdateLaboratoryExaminationRequest extends FormRequest
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
                'laboratory_examination_type_id' => 'nullable',
                'examination_id'                 => 'nullable',
                'laboratory_name'                => 'nullable',
                'laboratory_examination_types'   => 'nullable',
                'hasil'                          => 'nullable'
            ];
        }
    }
