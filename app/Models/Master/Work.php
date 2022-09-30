<?php

namespace App\Models\Master;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Work extends Model
{
    use SpatieLogsActivity, HasFactory, SoftDeletes;

    protected $fillable = [
        'name'
    ];

    /**
     * Work relation to info model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function info()
    {
        return $this->HasMany(UserInfo::class);
    }
}
