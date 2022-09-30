<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use App\Models\Master\BloodType;
use App\Models\Master\CardType;
use App\Models\Master\City;
use App\Models\Master\Country;
use App\Models\Master\District;
use App\Models\Master\Education;
use App\Models\Master\Gender;
use App\Models\Master\MaritalStatus;
use App\Models\Master\Province;
use App\Models\Master\Religion;
use App\Models\Master\SubDistrict;
use App\Models\Master\Work;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class UserInfo extends Model
{
    use SpatieLogsActivity, SoftDeletes;

    /**
     * Prepare proper error handling for url attribute
     *
     * @return string
     */
    public function getAvatarUrlAttribute()
    {
        // if file avatar exist in storage folder
        $avatar = public_path(Storage::url($this->photo));
        if (is_file($avatar) && file_exists($avatar)) {
            // get avatar url from storage
            return Storage::url('storage/'.$this->photo);
        }

        // check if the avatar is an external url, eg. image from google
        if (filter_var($this->photo, FILTER_VALIDATE_URL)) {
            return 'storage/'.$this->photo;
        }

        // no avatar, return blank avatar
        return asset(theme()->getMediaUrlPath().'photos/blank.png');
    }

    /**
     * User info relation to user model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Unserialize values by default
     *
     * @param $value
     *
     * @return mixed|null
     */
    public function getCommunicationAttribute($value)
    {
        // test to un-serialize value and return as array
        $data = @unserialize($value);
        if ($data !== false) {
            return $data;
        } else {
            return null;
        }
    }

    /**
     * User Info relation to religion model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function religion()
    {
        return $this->belongsTo(Religion::class);
    }

    /**
     * User Info relation to gender model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    /**
     * User Info relation to blood type model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function blood()
    {
        return $this->belongsTo(BloodType::class,'blood_type_id','id');
    }

    /**
     * User Info relation to card type model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function card()
    {
        return $this->belongsTo(CardType::class,'card_type_id','id');
    }

    /**
     * User Info relation to education model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function education()
    {
        return $this->belongsTo(Education::class);
    }

    /**
     * User Info relation to work model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function work()
    {
        return $this->belongsTo(Work::class);
    }

    /**
     * User Info relation to marital status model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function marital()
    {
        return $this->belongsTo(MaritalStatus::class,'marital_status_id','id');
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
