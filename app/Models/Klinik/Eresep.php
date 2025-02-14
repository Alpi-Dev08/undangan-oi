<?php

namespace App\Models\Klinik;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Eresep extends Model
{
    protected $fillable = ['examination_id', 'eresep_number'];

    public function examination()
    {
        return $this->belongsTo(Examination::class);
    }
}
