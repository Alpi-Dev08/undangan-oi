<?php
namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class StoreKategoriWebsiteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'jenis_id'      => 'required|exists:jenis_undangan,id',
            'nama_kategori' => 'required|string|max:100|unique:kategori_undangan,nama_kategori',
            'deskripsi'     => 'nullable|string|max:500',
        ];
    }

    public function messages()
    {
        return [
            'jenis_id.required' => 'Jenis undangan wajib dipilih',
            'jenis_id.exists'   => 'Jenis undangan tidak valid',

            'nama_kategori.required' => 'Nama kategori wajib diisi',
            'nama_kategori.unique'   => 'Nama kategori sudah digunakan',
            'nama_kategori.max'      => 'Nama kategori maksimal 100 karakter',
        ];
    }
}
