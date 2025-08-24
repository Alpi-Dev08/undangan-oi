<?php

namespace App\Models\Klinik;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyDiseaseHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'code_system',
        'value_set',
    ];
}
