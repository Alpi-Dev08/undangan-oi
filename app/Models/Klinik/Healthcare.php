<?php

namespace App\Models\Klinik;

use App\Core\Traits\SpatieLogsActivity;
use App\Models\Master\City;
use App\Models\Master\Country;
use App\Models\Master\District;
use App\Models\Master\Province;
use App\Models\Master\SubDistrict;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Healthcare extends Model
{
    use SpatieLogsActivity, HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'healthcare_type_id',
        'healthcare_category_id',
        'country_id',
        'province_id',
        'city_id',
        'district_id',
        'sub_district_id',
        'email',
        'phone',
        'website',
        'address',
        'postal_code',
    ];

    /**
     * User Info relation to country model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(HealthcareCategory::class);
    }

    /**
     * User Info relation to country model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(HealthcareType::class);
    }
    /**
     * User Info relation to country model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * User Info relation to province model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * User Info relation to city model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * User Info relation to district model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    /**
     * User Info relation to subdistrict model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subdistrict()
    {
        return $this->belongsTo(SubDistrict::class);
    }
}
