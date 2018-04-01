<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const SOURCE_MODE = 1;
    const LISTENER_MODE = 0;
    const DEMO_MODE = 2;

    private $fast_stat_source;
    private $fast_stat_listener;

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
    ];

    public function settings() {
        return $this->hasMany('App\Models\UserSetting', 'user_id', 'id');
    }

    public function stat() {
        return $this->hasMany('App\Models\UserStat', 'user_id', 'id');
    }

    public function getFastStatSource() {
        if ($this->fast_stat_source == null) {
            $this->fast_stat_source = $this->fastStat()->where('account_mode', '=', User::SOURCE_MODE)->first();
        }

        return $this->fast_stat_source;
    }

    public function getFastStatListener() {
        if ($this->fast_stat_listener == null) {
            $this->fast_stat_listener = $this->fastStat()->where('account_mode', '=', User::LISTENER_MODE)->first();
        }

        return $this->fast_stat_listener;
    }

    public function fastStat() {
        return $this->hasMany('App\Models\UserFastStat', 'user_id', 'id');
    }

    public function notifyAccess() {
        return $this->hasMany('App\Models\NotifyAccess', 'user_id', 'id');
    }

    public function showStats() {
        return $this->belongsToMany('App\Models\UserStat', 'show_statistics', 'user_id', 'stat_id')->withPivot('id', 'status');
    }
}
