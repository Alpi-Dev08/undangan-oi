<?php

namespace App\Models\Klinik;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DrugUsage extends Model
{
    use SpatieLogsActivity, HasFactory, SoftDeletes;

    protected $fillable = [
        'drug_id',
        'date',
        'user_name',
        'quantity',
        'description'
    ];

    protected $casts = [
        'date' => 'date',
        'quantity' => 'integer'
    ];

    /**
     * Relasi ke model Drug
     */
    public function drug()
    {
        return $this->belongsTo(Drug::class);
    }
}
