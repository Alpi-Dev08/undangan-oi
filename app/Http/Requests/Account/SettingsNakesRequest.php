<?php

    namespace App\Http\Requests\Account;

    use Illuminate\Foundation\Http\FormRequest;

    class SettingsNakesRequest extends FormRequest
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
         * @return array
         */
        public function rules()
        {
            return [
                'health_profesional_type_id' => 'nullable|integer',
                'speciality_id'              => 'nullable|integer',
                'str_number'                 => 'nullable|string',
                'str_expire_date'            => 'nullable|string',
                'sip_number'                 => 'nullable|string',
                'sip_expire_date'            => 'nullable|string',
                'health_profesional_status'  => 'nullable|string',
            ];
        }
    }
