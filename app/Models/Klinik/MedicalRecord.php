<?php

namespace App\Models\Klinik;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalRecord extends Model
{
    use SpatieLogsActivity, HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'medical_record_code',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
