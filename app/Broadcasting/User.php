<?php

namespace App\Broadcasting;

use App\User as UserModel;

class User
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\User  $user
     * @return array|bool
     */
    public function join(UserModel $user, $user_id)
    {
        if ($user->id == $user_id) {
            return true;
        }

        return false;
    }
}
