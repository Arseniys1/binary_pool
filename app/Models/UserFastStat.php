<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFastStat extends Model
{
    protected $table = 'user_fast_statistics';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'account_mode',
    ];

    public function user() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
