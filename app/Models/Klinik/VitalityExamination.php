<?php

namespace App\Models\Klinik;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class VitalityExamination extends Model
{
    use SpatieLogsActivity, HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'examination_id',
        // Vital Signs
        'weight',
        'height',
        'blood_pressure',
        'heart_rate',
        'respiratory_rate',
        'temperature',
        'oxygen_saturation',
        'body_mass_index',
        'ideal_weight',
        'body_fat',
        'bmi_conclusion',
        // Physical Findings
        'head_findings',
        'eye_findings',
        'ear_findings',
        'nose_findings',
        'hair_findings',
        'lip_findings',
        'teeth_findings',
        'neck_findings',
        'throat_findings',
        'chest_findings',
        'breast_findings',
        'back_findings',
        'abdomen_findings',
        'genital_findings',
        'upper_arm_findings',
        'forearm_findings',
        'wrist_findings',
        'thigh_findings',
        'calf_findings',
        'mouth_findings',
        'buttocks_findings',
        'hand_findings',
        'nail_findings',
        'tongue_findings',
        // Additional measurements
        'breath',
        'apex_beat',
        'waist_circumference',
        'neck_circumference',
        'arm_circumference',
        'chest_size',
        'abdominal_circumference',
        'others',
        'skrining'
    ];

    protected $casts = [
        'skrining' => 'array',
    ];

    /**
     * Relasi ke examination
     */
    public function examination()
    {
        return $this->belongsTo(Examination::class);
    }

    /**
     * Relasi ke user yang melakukan pemeriksaan
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
