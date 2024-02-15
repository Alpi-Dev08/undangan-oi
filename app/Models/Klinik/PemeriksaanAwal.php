<?php

namespace App\Models\Klinik;

use App\Core\Traits\SpatieLogsActivity;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PemeriksaanAwal extends Model
{
    use SpatieLogsActivity, HasFactory, SoftDeletes;

    protected $table = 'pemeriksaan_awal';

    protected $fillable = [
        'user_id',
        'patient_id',
        'kriteria_satu',
        'kriteria_dua',
        'interpretasi',
        'tindakan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

}
