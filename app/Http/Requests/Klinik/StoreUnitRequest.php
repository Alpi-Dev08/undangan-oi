<?php

namespace App\Http\Requests\Klinik;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Request validation untuk menyimpan unit baru
 */
class StoreUnitRequest extends FormRequest
{
    /**
     * Menentukan apakah user memiliki izin untuk request ini
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->can('klinik.create');
    }

    /**
     * Aturan validasi untuk request
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100|unique:units,name'
        ];
    }

    /**
     * Pesan error kustom
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama unit harus diisi.',
            'name.string' => 'Nama unit harus berupa teks.',
            'name.max' => 'Nama unit maksimal 100 karakter.',
            'name.unique' => 'Nama unit sudah digunakan.',
        ];
    }

    /**
     * Atribut kustom untuk pesan error
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'nama unit',
        ];
    }
}
