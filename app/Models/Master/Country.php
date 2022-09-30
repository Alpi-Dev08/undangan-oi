<?php

namespace App\Models\Master;

use App\Core\Traits\SpatieLogsActivity;
use App\Models\Klinik\Healthcare;
use App\Models\Klinik\Laboratory;
use App\Models\UserInfo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SpatieLogsActivity, HasFactory, SoftDeletes;

    protected $fillable = [
        'name'
    ];

    public function province()
    {
        return $this->hasMany(Province::class);
    }

    public function city()
    {
        return $this->hasMany(City::class);
    }

    public function district()
    {
        return $this->hasMany(District::class);
    }

    public function sub()
    {
        return $this->hasMany(SubDistrict::class);
    }

    /**
     * Country relation to info model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function info()
    {
        return $this->HasMany(UserInfo::class);
    }

    /**
     * Country relation to healthcare model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function healthcare()
    {
        return $this->HasMany(Healthcare::class);
    }

    /**
     * Country relation to laboratory model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function laboratory()
    {
        return $this->HasMany(Laboratory::class);
    }
}
