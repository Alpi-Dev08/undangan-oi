<?php

namespace App\Models\Klinik;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HealthcareType extends Model
{
    use SpatieLogsActivity, HasFactory, SoftDeletes;

    protected $fillable = [
        'name'
    ];

    /**
     * Country relation to info model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function healthcare()
    {
        return $this->HasMany(Healthcare::class);
    }
}
