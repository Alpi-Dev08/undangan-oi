<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
 
class Kategori extends Model 
{
    use SoftDeletes;

    protected $table = 'kategori_undangan';

    protected $fillable = [
        'jenis_id',
        'nama_kategori',
        'deskripsi',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Relasi: Kategori milik satu Jenis
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
