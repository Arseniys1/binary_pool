<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessRequest extends Model
{
    protected $table = 'access_demo_requests';

    const PROCESSING_STATUS = 0;
    const ACCEPT_STATUS = 1;
    const REJECT_STATUS = 2;

    public function preset() {
        return $this->hasOne('App\Models\NotifyAccessPreset', 'id', 'access_preset_id');
    }

    public function user() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
