<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jenis extends Model
{
    use SoftDeletes;

    protected $table = 'jenis_undangan';

    protected $fillable = [
        'nama_jenis',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Relasi: 1 Jenis punya banyak Kategori
     */
    public function kategori()
    {
        return $this->hasMany(
            Kategori::class,
            'jenis_id', 
            'id'     
        );
    }

    public function template()
    {
        return $this->hasMany(
            Template::class,
            'jenis_id',
            'id'
        );
    }

    public function paket()
    {
        return $this->hasMany(Paket::class, 'jenis_id', 'id');
    }
}