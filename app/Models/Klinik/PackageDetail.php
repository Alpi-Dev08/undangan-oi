<?php

namespace App\Models\Klinik;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageDetail extends Model
{
    use HasFactory, SpatieLogsActivity;

    protected $table = 'package_details';

    protected $fillable = [
        'package_id',
        'service_id'
    ];

    function package()
    {
        return $this->belongsTo(Package::class);
    }
}
