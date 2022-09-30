<?php

namespace App\Models\Klinik;

use App\Core\Traits\SpatieLogsActivity;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Examination extends Model
{
    use SpatieLogsActivity, HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'patient_id',
        'plan_id',
        'medical_record_id',
        'health_profesional_id',
        'service_type_id',
        'package_id',
        'examination_code',
        'examination_date',
        'symtomp_area',
        'symtomp',
        'symtomp_date',
        'subjective',
        'objective',
        'assessment',
        'plan',
        'total',
        'status',
        'resep',
        'is_lab'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

}
