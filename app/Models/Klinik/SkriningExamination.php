<?php

namespace App\Models\Klinik;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Master\Gender; 
use App\Models\Klinik\SkriningExaminationType;
use App\Models\Klinik\SkriningExaminationLocation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SkriningExamination extends Model
{ 
    use SpatieLogsActivity, HasFactory, SoftDeletes;

    protected $fillable = [
        'examination_id',
        'location_id',
        'examination_date',
        'first_name', 
        'last_name',
        'card_type',
        'nik_bpjs',
        'date_of_birth',
        'age',
        'address',
        'gender_id',
        'phone',
        'hasil',
        'satuan',
        'keterangan',
        'deskripsi'
    ];
    
    public function skriningexaminationtype()
    {
        return $this->belongsTo(SkriningExaminationType::class);
    }

    public function location()
    {
        return $this->belongsTo(SkriningExaminationLocation::class, 'location_id');
    }

    public function gender()
    { 
        return $this->belongsTo(Gender::class, 'gender_id');
    }

    // public function examination()
    // {
    //     return $this->belongsTo(Examination::class);
    // }
}
