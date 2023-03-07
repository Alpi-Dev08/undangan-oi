<?php

namespace App\Models\Klinik;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Additionals extends Model
{
    use SpatieLogsActivity, HasFactory, SoftDeletes;

    protected $table = 'additionals';

    protected $fillable = [
        'additionals_category_id',
        'name',
        'options',
    ];

    public function category()
    {
        return $this->belongsTo(AdditionalCategory::class, 'additionals_category_id', 'id');
    }
}
