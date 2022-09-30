<?php

namespace App\Models\Klinik;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionDetail extends Model
{
    use SpatieLogsActivity, HasFactory, SoftDeletes;

    protected $fillable = [
        'transaction_id',
        'name',
        'quantity',
        'price',
        'total',
        'description'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
