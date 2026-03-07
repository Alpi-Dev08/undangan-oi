<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class StoreTemplateWebsiteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Jika jenis_id selalu 3 dan hidden field, ini tetap aman
            'jenis_id' => 'required|integer',

            // Soft delete safe unique
            'nama_template' => 'required|string|max:100|unique:template,nama_template,NULL,id,deleted_at,NULL',

            // Tidak pakai exists supaya tidak error tabel
            'kategori_id' => 'required|integer',

            'preview_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'is_premium' => 'nullable|boolean',

            // Harga hanya wajib jika premium dicentang
            'harga' => 'nullable|numeric|min:0|required_if:is_premium,1',
        ];
    }

    public function messages(): array
    {
        return [

            'jenis_id.required' => 'Jenis wajib dipilih',

            'nama_template.required' => 'Nama template wajib diisi',
            'nama_template.unique'   => 'Nama template sudah digunakan',
            'nama_template.max'      => 'Nama template maksimal 100 karakter',

            'kategori_id.required' => 'Kategori wajib dipilih',

            'preview_image.image' => 'File harus berupa gambar',
            'preview_image.mimes' => 'Format gambar harus jpg, jpeg, png, atau webp',
            'preview_image.max'   => 'Ukuran gambar maksimal 2MB',

            'harga.required_if' => 'Harga wajib diisi jika template premium',
            'harga.numeric'     => 'Harga harus berupa angka',
            'harga.min'         => 'Harga tidak boleh minus',
        ];
    }
}