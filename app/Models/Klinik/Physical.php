<?php

namespace App\Models\Klinik;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Physical extends Model
{
    use SpatieLogsActivity, HasFactory, SoftDeletes;

    protected $fillable = [
        'physical_category_id',
        'name',
        'options',
    ];

    public function category()
    {
        return $this->belongsTo(PhysicalCategory::class, 'physical_category_id', 'id');
    }
}
