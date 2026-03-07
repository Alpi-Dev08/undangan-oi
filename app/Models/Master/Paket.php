<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paket extends Model
{
    use SoftDeletes;

    protected $table = 'paket';

    protected $fillable = [
        'jenis_id',
        'nama_paket',
        'harga',
        'masa_aktif_hari',
        'deskripsi',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Relasi: Paket milik satu Jenis
     */
    public function jenis()
    {
        return $this->belongsTo(
            Jenis::class,
            'jenis_id',
            'id'
        );
    }
}