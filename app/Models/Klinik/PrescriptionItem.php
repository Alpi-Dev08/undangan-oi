<?php

namespace App\Models\Klinik;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrescriptionItem extends Model
{
    use SpatieLogsActivity, HasFactory, SoftDeletes;

    protected $fillable = [
        'prescription_id',
        'drug_id',
        'drug_name',
        'kfa_code',
        'qty',
        'unit',
        'dosis',
        'aturan_pakai',
        'keterangan',
        'perintah_perawat',
    ];

    /**
     * Relasi ke header resep
     */
    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    /**
     * Relasi ke master obat
     */
    public function drug()
    {
        return $this->belongsTo(Drug::class);
    }
}