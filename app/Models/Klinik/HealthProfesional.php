<?php

namespace App\Models\Klinik;

use App\Core\Traits\SpatieLogsActivity;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HealthProfesional extends Model
{
    use SpatieLogsActivity, HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'health_profesional_type_id',
        'speciality_id',
        'str_number',
        'str_expire_date',
        'str_file',
        'sip_number',
        'sip_expire_date',
        'sip_file',
        'kkj_registration_card',
        'health_profesional_status',
        'his_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(HealthProfesionalType::class);
    }

    public function speciality()
    {
        return $this->belongsTo(Speciality::class);
    }


}
