<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Template extends Model
{
    use SoftDeletes;

    protected $table = 'template';

    protected $fillable = [
        'nama_template',
        'slug',
        'jenis_id',
        'kategori_id',
        'preview_image',
        'is_premium',
        'harga',
        'status',
    ];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'is_premium' => 'boolean',
    ];

    // AUTO GENERATE DEMO URL
    public function getDemoUrlAttribute()
    {
        return route('demo.template', $this->slug);
    }

    /**
     * Relasi: Template milik satu Jenis
     */
    public function jenis()
    {
        return $this->belongsTo(
            Jenis::class,
            'jenis_id',
            'id'
        );
    }

    /**
     * Relasi: Template milik satu Kategori
     */
    public function kategori()
    {
        return $this->belongsTo(
            Kategori::class,
            'kategori_id',
            'id'
        );
    }
}