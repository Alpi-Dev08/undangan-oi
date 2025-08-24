<?php

namespace App\Http\Requests\Klinik;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Request validation untuk menyimpan transaksi baru
 */
class StoreTransactionRequest extends FormRequest
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
            'transaction_id' => 'required|exists:transactions,id',
            'name' => 'required|array|min:1',
            'name.*' => 'nullable|string|max:255',
            'description' => 'nullable|array',
            'description.*' => 'nullable|string|max:500',
            'price' => 'required|array',
            'price.*' => 'required_with:name.*|numeric|min:0',
            'quantity' => 'required|array',
            'quantity.*' => 'required_with:name.*|integer|min:1',
            'notes' => 'nullable|string|max:1000',
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
            'transaction_id.required' => 'ID transaksi harus diisi.',
            'transaction_id.exists' => 'Transaksi tidak ditemukan.',
            'name.required' => 'Nama item harus diisi.',
            'name.array' => 'Format nama item tidak valid.',
            'name.min' => 'Minimal harus ada satu item.',
            'price.*.numeric' => 'Harga harus berupa angka.',
            'price.*.min' => 'Harga tidak boleh negatif.',
            'quantity.*.integer' => 'Jumlah harus berupa angka bulat.',
            'quantity.*.min' => 'Jumlah minimal 1.',
        ];
    }
}
