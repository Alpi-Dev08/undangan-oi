<?php

namespace App\Models\Klinik;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Klinik\Models\KfaProduct;

class Drug extends Model
{
    use SpatieLogsActivity, HasFactory, SoftDeletes;

    protected $casts = [
        'kfa_data' => 'array',
        'matching_metadata' => 'array',
        'price' => 'decimal:2',
        'stock' => 'integer',
        'similarity_score' => 'float',
        'last_sync_attempt' => 'datetime'
    ];

    protected $fillable = [
        'unit_id',
        'name',
        'price',
        'stock',
        'kfa_code',
        'kfa_data',
        'manufacturer',
        'similarity_score',
        'matching_metadata',
        'last_sync_attempt'
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Relasi ke model DrugUsage
     */
    public function usages()
    {
        return $this->hasMany(DrugUsage::class);
    }

    /**
     * Relasi ke KfaProduct berdasarkan kfa_code
     */
    public function kfaProduct()
    {
        return $this->belongsTo(KfaProduct::class, 'kfa_code', 'kfa_code');
    }
}
