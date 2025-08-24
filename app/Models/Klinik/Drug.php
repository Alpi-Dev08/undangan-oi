<?php

namespace App\Models\Klinik;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Drug extends Model
{
    use SpatieLogsActivity, HasFactory, SoftDeletes;

    protected $casts = [
        'kfa_data' => 'array',
        'price' => 'decimal:2',
        'stock' => 'integer'
    ];

    protected $fillable = [
        'unit_id',
        'name',
        'price',
        'stock',
        'kfa_code',
        'kfa_data'
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Relasi ke model DrugUsage
     */
    public function drugUsages()
    {
        return $this->hasMany(DrugUsage::class);
    }
}
