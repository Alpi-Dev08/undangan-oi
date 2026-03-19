<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TemplateVideo extends Model
{
    use SoftDeletes;

    protected $table = 'template_video';

    protected $fillable = [
        'nama_template',
        'slug',
        'jenis_id',
        'kategori_id',
        'preview_image',
        'preview_video',
        'harga',
        'deskripsi',
        'status',
    ];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'harga' => 'float',
    ];

    /**
     * Accessor: URL Demo Video
     */
    public function getDemoUrlAttribute()
    {
        return route('demo.template_video', $this->slug);
    }

    /**
     * Relasi: Template Video milik satu Jenis
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
     * Relasi: Template Video milik satu Kategori
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