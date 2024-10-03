<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sbar extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dari default
    protected $table = 'sbars';

    // Tentukan field mana yang dapat diisi secara massal (mass assignment)
    protected $fillable = [
        'examination_id',
        'situation',
        'background',
        'assessment',
        'recommendation',
        'created_at',
        'updated_at',
        'checklist_verification'
    ];

    // Jika ada relasi, misalnya ke tabel `Examination`
    public function examination()
    {
        return $this->belongsTo(Examination::class);
    }
}
