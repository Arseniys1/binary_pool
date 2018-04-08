<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotifyAccess extends Model
{
    const PERMANENT_ACCESS = 0;
    const LIMITED_ACCESS = 1;

    const ACTIVE_STATUS = 1;
    const EXPIRED_STATUS = 0;

    const HIDDEN_DISABLE = 0;
    const HIDDEN_ENABLE = 1;

    protected $table = 'notify_access';

    protected $hidden = [
        'is_hidden',
    ];

    public function source() {
        return $this->hasOne('App\User', 'id', 'source_id');
    }

    public function user() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
