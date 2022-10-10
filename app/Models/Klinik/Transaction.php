<?php

namespace App\Models\Klinik;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SpatieLogsActivity, HasFactory, SoftDeletes;

    protected $fillable = [
        'examination_id',
        'invoice_number',
        'amount',
        'notes',
        'status',
        'metode_pembayaran'
    ];

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function examination()
    {
        return $this->belongsTo(Examination::class);
    }
}
