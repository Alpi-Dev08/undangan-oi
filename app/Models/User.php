<?php

    namespace App\Models;

    use App\Core\Traits\SpatieLogsActivity;
    use App\Models\Klinik\HealthProfesional;
    use App\Models\Klinik\MedicalRecord;
    use App\Models\Klinik\Patient;
    use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use Illuminate\Support\Facades\DB;
    use Spatie\Permission\Traits\HasRoles;

    class User extends Authenticatable implements MustVerifyEmail
    {
        use HasFactory, Notifiable, SoftDeletes;
        use SpatieLogsActivity;
        use HasRoles;

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'first_name',
            'last_name',
            'email',
            'phone',
            'api_token',
            'password',
        ];

        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            'password',
            'remember_token',
        ];

        /**
         * The attributes that should be cast to native types.
         *
         * @var array
         */
        protected $casts = [
            'email_verified_at' => 'datetime',
        ];

        public static function getpermissionGroups()
        {
            $permission_groups = DB::table('permissions')
                ->select('group_name as name')
                ->groupBy('group_name')
                ->get();
            return $permission_groups;
        }

        public static function getpermissionsByGroupName($group_name)
        {
            $permissions = DB::table('permissions')
                ->select('name', 'id')
                ->where('group_name', $group_name)
                ->get();
            return $permissions;
        }

        public static function roleHasPermissions($role, $permissions)
        {
            $hasPermission = true;
            foreach ($permissions as $permission) {
                if (!$role->hasPermissionTo($permission->name)) {
                    $hasPermission = false;
                    return $hasPermission;
                }
            }
            return $hasPermission;
        }

        public function getRememberToken()
        {
            return $this->remember_token;
        }

        public function setRememberToken($value)
        {
            $this->remember_token = $value;
        }

        /**
         * Get a fullname combination of first_name and last_name
         *
         * @return string
         */
        public function getNameAttribute()
        {
            return "{$this->first_name} {$this->last_name}";
        }

        /**
         * Prepare proper error handling for url attribute
         *
         * @return string
         */
        public function getAvatarUrlAttribute()
        {
            if ($this->info->photo) {
                return asset('storage/'.$this->info->photo);
            }

            return asset(theme()->getMediaUrlPath().'photos/blank.png');
        }

        /**
         * User relation to info model
         *
         * @return \Illuminate\Database\Eloquent\Relations\HasOne
         */
        public function info()
        {
            return $this->hasOne(UserInfo::class);
        }

        /**
         * User relation to info model
         *
         * @return \Illuminate\Database\Eloquent\Relations\HasOne
         */
        public function patient()
        {
            return $this->hasOne(Patient::class);
        }

        /**
         * User relation to info model
         *
         * @return \Illuminate\Database\Eloquent\Relations\HasOne
         */
        public function health_profesional()
        {
            return $this->hasOne(HealthProfesional::class);
        }


        public function mr()
        {
            return $this->hasOne(MedicalRecord::class);
        }
    }
