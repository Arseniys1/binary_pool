<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class UserStat extends Model
{
    protected $table = 'user_statistics';

    const UP_DIRECTION = 1;
    const DOWN_DIRECTION = 0;

    const SUCCESS_STATUS = 1;
    const LOSS_STATUS = 0;
    const RET_STATUS = 2;
    const NO_STATUS = 3;

    const CREATE_SHOW_STATUS = 0;
    const UPDATE_SHOW_STATUS = 1;

    protected $hidden = [
        'pivot',
        'updated_at',
    ];

    public function user() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function source() {
        return $this->hasOne('App\Models\UserStat', 'id', 'source_id');
    }

    public function sourceStat() {
        return $this->hasOne('App\Models\SourceStat', 'source_id', 'id');
    }
}
