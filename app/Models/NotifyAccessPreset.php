<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotifyAccessPreset extends Model
{
    protected $table = 'notify_access_presets';

    const ACTIVE_STATUS = 1;
    const REMOVE_STATUS = 0;

    public function source() {
        return $this->hasOne('App\User', 'id', 'source_id');
    }

    public function requests() {
        return $this->hasMany('App\Models\AccessRequest', 'access_preset_id', 'id');
    }

    public function links() {
        return $this->hasMany('App\Models\AccessLink', 'access_preset_id', 'id');
    }
}
