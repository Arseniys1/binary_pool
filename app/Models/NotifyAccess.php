<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotifyAccess extends Model
{
    const PERMANENT_ACCESS = 0;
    const LIMITED_ACCESS = 1;

    const ACTIVE_STATUS = 1;
    const EXPIRED_STATUS = 0;

    protected $table = 'notify_access';
}
