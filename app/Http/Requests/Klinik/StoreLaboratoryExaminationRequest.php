<?php

    namespace App\Http\Requests\Klinik;

    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Http\Exceptions\HttpResponseException;
    use Illuminate\Validation\ValidationException;
    use Illuminate\Validation\Validator;
    use Symfony\Component\HttpFoundation\JsonResponse;

    class StoreLaboratoryExaminationRequest extends FormRequest
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

        protected function failedValidation(Validator|\Illuminate\Contracts\Validation\Validator $validator)
        : JsonResponse
        {
            $errors = (new ValidationException($validator))->errors();

            throw new HttpResponseException(response()->json([
                'success'  => false,
                'errors'   => $errors,
                'messages' => 'Examination created failed.'
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        }
    }
