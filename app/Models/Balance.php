<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $table = 'balance';

    const SUCCESS_STATUS = 1;
    const NOT_PROCESSED_STATUS = 0;
    const ERROR_STATUS = 2;
}
