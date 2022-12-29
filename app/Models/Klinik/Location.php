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

class Location extends Model
{
    use SpatieLogsActivity, HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'uuid',
        'code',
        'description',
        'organization_id',
        'email',
        'phone',
        'fax',
        'logo',
        'country_id',
        'province_id',
        'city_id',
        'district_id',
        'sub_district_id',
        'address',
        'postal_code',
        'json_satu_sehat',
        'status'
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

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function sub_district()
    {
        return $this->belongsTo(SubDistrict::class);
    }

    public function organization(){
        return $this->belongsTo(Organization::class);
    }
}
