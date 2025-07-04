<?php

namespace App\Http\Requests\Klinik;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Request validation untuk update transaksi
 */
class UpdateTransactionRequest extends FormRequest
{
    /**
     * Menentukan apakah user memiliki izin untuk request ini
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->can('klinik.update');
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
            'service_id' => 'required|array|min:1',
            'service_id.*' => 'nullable|exists:services,id',
            'id' => 'nullable|array',
            'id.*' => 'nullable|exists:transaction_details,id',
            'description' => 'nullable|array',
            'description.*' => 'nullable|string|max:500',
            'price' => 'required|array',
            'price.*' => 'required_with:service_id.*|numeric|min:0',
            'quantity' => 'required|array',
            'quantity.*' => 'required_with:service_id.*|integer|min:1',
            'notes' => 'nullable|string|max:1000',
            'metode_pembayaran' => 'nullable|string|max:100',
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
            'service_id.required' => 'Service harus dipilih.',
            'service_id.array' => 'Format service tidak valid.',
            'service_id.min' => 'Minimal harus ada satu service.',
            'service_id.*.exists' => 'Service tidak ditemukan.',
            'price.*.numeric' => 'Harga harus berupa angka.',
            'price.*.min' => 'Harga tidak boleh negatif.',
            'quantity.*.integer' => 'Jumlah harus berupa angka bulat.',
            'quantity.*.min' => 'Jumlah minimal 1.',
        ];
    }
}
