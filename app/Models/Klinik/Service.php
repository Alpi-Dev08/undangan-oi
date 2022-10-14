<?php

namespace App\Models\Klinik;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SpatieLogsActivity, HasFactory, SoftDeletes;

    protected $fillable = [
        'service_category_id',
        'name',
        'price'
    ];

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class,'service_category_id','id');
    }

    public function transaction_detail(){
        return $this->hasMany(TransactionDetail::class);
    }
}
