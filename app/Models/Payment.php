<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    const NOT_PAID_STATUS = 0;
    const PAID_STATUS = 1;

    public function user() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function source() {
        return $this->hasOne('App\User', 'id', 'source_id');
    }
}
