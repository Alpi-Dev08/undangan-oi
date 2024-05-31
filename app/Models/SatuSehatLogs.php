<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatuSehatLogs extends Model
{
    use HasFactory;

    protected $table = 'satu_sehat_logs';
    protected $fillable = [
        'service',
        'url',
        'type',
        'messages',
        'response',
        'status',
        'description'
    ];
}
