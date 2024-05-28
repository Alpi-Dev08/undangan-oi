<?php

    namespace App\Models\Klinik;

    use     App\Core\Traits\SpatieLogsActivity;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;

    class VitalityExamination extends Model
    {
        use SpatieLogsActivity, HasFactory, SoftDeletes;

        protected $fillable = [
            'user_id',
            'examination_id',
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
            'breath',
            'apex_beat',
            'waist_circumferennce',
            'neck_circumference',
            'arm_circumference',
            'chest_size',
            'adbdominal_circumference',
            'others',
            'skrining'
        ];

        public function examination()
        {
            return $this->belongsTo(Examination::class);
        }
    }
