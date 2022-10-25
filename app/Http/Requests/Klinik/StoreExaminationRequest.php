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
                'user_id'               => 'nullable|integer|exists:users,id',
                'patient_id'            => 'nullable|integer|exists:patients,id',
                'medical_record_id'     => 'nullable|integer|exists:medical_records,id',
                'health_profesional_id' => 'nullable|integer|exists:health_profesionals,id',
                'service_category_id'   => 'nullable|integer|exists:service_categories,id',
                'plan_id'               => 'nullable|integer|exists:plans,id',
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
                'status'                => 'nullable',
                'resep'                 => 'nullable',
                'saran'                 => 'nullable',
            ];
        }
    }
