<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    protected $table = 'user_settings';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'name',
        'value',
    ];

    protected $hidden = [
        'id',
        'user_id',
    ];

    public function user() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
