<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const SOURCE_MODE = 1;
    const LISTENER_MODE = 0;

    const DEMO_ENABLE = 1;
    const DEMO_DISABLE = 0;

    const DEMO_SOURCE = 2;
    const DEMO_LISTENER = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
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
        'api_token',
        'updated_at',
        'email',
    ];

    public function settings() {
        return $this->hasMany('App\Models\UserSetting', 'user_id', 'id');
    }

    public function settingsList() {
        $settingsList = [];

        foreach ($this->settings as $setting) {
            $settingsList[$setting->name] = $setting->value;
        }

        return $settingsList;
    }

    public function stat() {
        return $this->hasMany('App\Models\UserStat', 'user_id', 'id');
    }

    public function fastStat() {
        return $this->hasMany('App\Models\UserFastStat', 'user_id', 'id');
    }

    public function notifyAccess() {
        return $this->hasMany('App\Models\NotifyAccess', 'user_id', 'id');
    }

    public function showStats() {
        return $this->belongsToMany('App\Models\UserStat', 'show_statistics', 'user_id', 'stat_id')
            ->wherePivot('user_id', $this->id)
            ->withPivot('id', 'status');
    }
}
