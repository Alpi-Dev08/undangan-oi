<?php

namespace App\Models\Klinik;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prescription extends Model
{
    use SpatieLogsActivity, HasFactory, SoftDeletes;

    protected $fillable = [
        'examination_id',
        'doctor_id',
        'resep_date',
        'catatan_umum',
        'total_items',
        'status',
    ];

    /**
     * Relasi ke pemeriksaan
     */
    public function examination()
    {
        return $this->belongsTo(Examination::class);
    }

    /**
     * Relasi ke dokter (user)
     */
    public function doctor()
    {
        return $this->belongsTo(\App\Models\User::class, 'doctor_id');
    }

    /**
     * Relasi ke item resep (detail)
     */
    public function items()
    {
        return $this->hasMany(PrescriptionItem::class);
    }
}