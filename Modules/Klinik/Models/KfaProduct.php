<?php

namespace Modules\Klinik\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KfaProduct extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kfa_products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kfa_code',
        'name',
        'manufacturer',
        'product_type',
        'dosage_form',
        'strength',
        'unit',
        'packaging',
        'fix_price',
        'het_price',
        'registration_number',
        'registration_date',
        'expiry_date',
        'description',
        'raw_data',
        'last_sync',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fix_price' => 'decimal:2',
        'het_price' => 'decimal:2',
        'registration_date' => 'date',
        'expiry_date' => 'date',
        'raw_data' => 'array',
        'last_sync' => 'datetime',
    ];

    /**
     * Check if data needs to be updated (older than 1 week)
     *
     * @return bool
     */
    public function needsUpdate(): bool
    {
        return $this->last_sync->lt(now()->subWeek());
    }

    /**
     * Scope untuk mendapatkan produk yang perlu diupdate
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNeedsUpdate($query)
    {
        return $query->where('last_sync', '<', now()->subWeek());
    }

    /**
     * Scope untuk pencarian berdasarkan keyword
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $keyword
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, ?string $keyword)
    {
        if (!$keyword) {
            return $query;
        }

        return $query->where(function ($q) use ($keyword) {
            $q->where('name', 'ilike', "%{$keyword}%")
              ->orWhere('kfa_code', 'ilike', "%{$keyword}%")
              ->orWhere('manufacturer', 'ilike', "%{$keyword}%");
        });
    }

    /**
     * Scope untuk filter berdasarkan tipe produk
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $productType
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByProductType($query, ?string $productType)
    {
        if (!$productType || $productType === 'all') {
            return $query;
        }

        return $query->where('product_type', $productType);
    }
}