<?php

    namespace App\Http\Requests\Klinik;

    use Illuminate\Foundation\Http\FormRequest;

    class StoreExaminationRequest extends FormRequest
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
                'user_id'               => 'nullable',
                'patient_id'            => 'nullable',
                'medical_record_id'     => 'nullable',
                'health_profesional_id' => 'nullable',
                'examination_code'      => 'nullable',
                'examination_date'      => 'nullable',
                'symtomp_area'          => 'nullable',
                'symtomp'               => 'nullable',
                'symtomp_date'          => 'nullable',
                'subjective'            => 'nullable',
                'objective'             => 'nullable',
                'assessment'            => 'nullable',
                'plan'                  => 'nullable',
                'total'                 => 'nullable',
                'status'                => 'nullable'
            ];
        }
    }
