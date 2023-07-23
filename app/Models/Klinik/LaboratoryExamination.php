<?php

namespace App\Models\Klinik;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaboratoryExamination extends Model
{
    use SpatieLogsActivity, HasFactory, SoftDeletes;

    protected $fillable = [
        'laboratory_id',
        'laboratory_examination_type_id',
        'examination_id',
        'laboratory_name',
        'hasil',
    ];

    public function unit()
    {
        return $this->belongsTo(LaboratoryExaminationType::class);
    }

    public function examination()
    {
        return $this->belongsTo(Examination::class);
    }
}
