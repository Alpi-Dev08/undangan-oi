<?php

namespace App\Models\Klinik;
 
use App\Core\Traits\SpatieLogsActivity;
use App\Models\Klinik\SkriningExamination; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SkriningExaminationType extends Model
{
    use SpatieLogsActivity, HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'nilai_normal'
    ];

    public function skriningexamination()
    {
        return $this->hasMany(SkriningExamination::class);
    }
}
