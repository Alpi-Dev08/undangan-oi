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
            'location_id',
            'health_profesional_id',
            'service_category_id',
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
            'saran',
            'is_appointment',
            'appointment_date',
            'appointment_status',
            'is_consent',
            'consent_data',
            'bukti_penyampaian_informasi',
            'bukti_persetujuan_tindakan_medis'
        ];

        public function user()
        {
            return $this->belongsTo(User::class);
        }

        public function patient()
        {
            return $this->belongsTo(Patient::class);
        }

        public function plan()
        {
            return $this->belongsTo(Plan::class);
        }

        public function medical_record()
        {
            return $this->belongsTo(MedicalRecord::class);
        }

        public function health_profesional()
        {
            return $this->belongsTo(HealthProfesional::class);
        }

        public function service_category()
        {
            return $this->belongsTo(ServiceCategory::class);
        }

        public function anamnesis()
        {
            return $this->hasOne(AnamnesisExamination::class);
        }

        public function physical()
        {
            return $this->hasOne(PhysicalExamination::class);
        }

        public function other()
        {
            return $this->hasOne(OtherExamination::class);
        }

        public function vitality()
        {
            return $this->hasOne(VitalityExamination::class);
        }

        public function location()
        {
            return $this->belongsTo(Location::class);
        }

        public function pemeriksaan_awal()
        {
            return $this->hasOne(PemeriksaanAwal::class);
        }

    }
