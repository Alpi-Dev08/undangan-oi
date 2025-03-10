<?php

namespace App\Http\Requests\Klinik;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateJenisPasienRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('jenis_pasien')->ignore($this->jenis_pasien),
            ],
            'keterangan' => 'nullable|string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'Nama jenis pasien harus diisi.',
            'nama.unique' => 'Nama jenis pasien sudah ada.',
            'nama.max' => 'Nama jenis pasien tidak boleh lebih dari 255 karakter.',
        ];
    }
}
