<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Helpers\UserSettings;

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

    public function settingsObj() {
        return new UserSettings($this->settingsList());
    }

    public function toArray()
    {
        $result = parent::toArray();

        if (array_key_exists('settings', $result)) {
            $result['settings'] = $this->settingsList();
        }

        return $result;
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

    public function notifyAccessPresets() {
        return $this->hasMany('App\Models\NotifyAccessPreset', 'source_id', 'id');
    }
}
