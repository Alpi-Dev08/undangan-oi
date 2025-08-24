<?php

namespace App\Models;

use App\Models\Klinik\Examination;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisPasien extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'jenis_pasien';
    protected $fillable = ['nama', 'keterangan'];

    public function examinations()
    {
        return $this->hasMany(Examination::class);
    }


}
