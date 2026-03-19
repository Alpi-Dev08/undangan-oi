<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class StoreTemplateVideoRequest extends FormRequest
{
    /**
     * Authorization
     */
    public function authorize(): bool
    {
        return true;
        // optional:
        // return auth()->user()->can('masters.create');
    }

    /**
     * Prepare input
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'nama_template' => trim($this->nama_template),
        ]);
    }

    /**
     * Rules
     */
    public function rules(): array
    {
        return [
            // hidden field
            'jenis_id' => 'required|integer',

            // utama
            'nama_template' => 'required|string|max:150|unique:template_video,nama_template,NULL,id,deleted_at,NULL',

            'kategori_id' => 'nullable|integer',

            // file
            'preview_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'preview_video' => 'nullable|file|mimes:mp4,mov,avi|max:102400',
            
            // data
            'harga' => 'nullable|numeric|min:0',

            'deskripsi' => 'nullable|string',

            'status' => 'required|in:aktif,nonaktif',
        ];
    }

    /**
     * Messages
     */
    public function messages(): array
    {
        return [
            'jenis_id.required' => 'Jenis wajib diisi',

            'nama_template.required' => 'Nama template wajib diisi',
            'nama_template.unique'   => 'Nama template sudah digunakan',
            'nama_template.max'      => 'Nama template maksimal 150 karakter',

            'preview_image.image' => 'File harus berupa gambar',
            'preview_image.mimes' => 'Format harus jpg, jpeg, png, webp',
            'preview_image.max'   => 'Ukuran maksimal 2MB',

            'preview_video.mimes' => 'Format video harus mp4, mov, avi',
            'preview_video.max'   => 'Ukuran video maksimal 20MB',

            'harga.numeric' => 'Harga harus angka',
            'harga.min'     => 'Harga tidak boleh minus',

            'status.required' => 'Status wajib dipilih',
            'status.in'       => 'Status tidak valid',
        ];
    }

    /**
     * Attribute name biar rapi
     */
    public function attributes(): array
    {
        return [
            'nama_template' => 'Nama Template',
            'kategori_id' => 'Kategori',
            'preview_image' => 'Preview Image',
            'preview_video' => 'Preview Video',
            'harga' => 'Harga',
            'deskripsi' => 'Deskripsi',
            'status' => 'Status',
        ];
    }
}