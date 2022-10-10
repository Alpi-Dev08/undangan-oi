<?php

namespace App\Models\Klinik;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Anamnesis extends Model
{
    use SpatieLogsActivity, HasFactory, SoftDeletes;

    protected $table = 'anamnesis';
    protected $fillable = [
        'anamnesis_category_id',
        'name',
        'options',
    ];

    public function category()
    {
        return $this->belongsTo(AnamnesisCategory::class, 'anamnesis_category_id', 'id');
    }
}
