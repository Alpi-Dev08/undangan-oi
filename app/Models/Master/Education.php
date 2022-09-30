<?php

namespace App\Models\Master;

use App\Core\Traits\SpatieLogsActivity;
use App\Models\UserInfo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Education extends Model
{
    use SpatieLogsActivity, HasFactory, SoftDeletes;

    protected $table = "educations";

    protected $fillable = [
        'name'
    ];

    /**
     * Education relation to info model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function info()
    {
        return $this->HasMany(UserInfo::class);
    }
}
