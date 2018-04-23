<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessLink extends Model
{
    protected $table = 'access_demo_links';

    const NOT_USED_STATUS = 0;
    const USED_STATUS = 1;

    public function preset() {
        return $this->hasOne('App\Models\NotifyAccessPreset', 'id', 'access_preset_id');
    }

    public function user() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
