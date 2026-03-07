<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fitur extends Model
{
    use SoftDeletes;

    protected $table = 'fitur';

    protected $fillable = [
        'nama_fitur',
        'kode_fitur',
    ];

    protected $dates = ['deleted_at'];
}