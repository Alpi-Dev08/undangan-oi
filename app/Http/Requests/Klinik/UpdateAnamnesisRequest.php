<?php

    namespace App\Http\Requests\Klinik;

    use Illuminate\Foundation\Http\FormRequest;

    class UpdateAnamnesisRequest extends FormRequest
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
                'name'                  => 'required|string|max:255|unique:anamnesis,name,' . $this->anamnesi->id,
                'anamnesis_category_id' => 'required|exists:anamnesis_categories,id',
                'options'               => 'nullable|json'
            ];
        }
    }
