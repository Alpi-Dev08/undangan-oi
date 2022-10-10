<?php

namespace App\Models\Klinik;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceCategory extends Model
{
    use SpatieLogsActivity, HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'is_global',
        'is_mcu'
    ];

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
