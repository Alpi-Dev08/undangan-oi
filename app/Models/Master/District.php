<?php

namespace App\Models\Master;

use App\Core\Traits\SpatieLogsActivity;
use App\Models\Klinik\Healthcare;
use App\Models\Klinik\Laboratory;
use App\Models\UserInfo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model
{
    use SpatieLogsActivity, HasFactory, SoftDeletes;

    protected $fillable = [
        'country_id',
        'province_id',
        'city_id',
        'name',
        'area_code',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function sub()
    {
        return $this->hasMany(SubDistrict::class);
    }

    /**
     * District relation to info model
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
