<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class DevController extends Controller
{
    public function register(Request $request) {
        $user1 = new User;
        $user1->name = 'Arseniys1';
        $user1->email = 'thevalakas1@mail.ru';
        $user1->password = bcrypt('Arseniys1');
        $user1->api_token = str_random(32);
        $user1->save();

        $user2 = new User;
        $user2->name = 'Arseniys2';
        $user2->email = 'thevalakas2@mail.ru';
        $user2->password = bcrypt('Arseniys2');
        $user2->api_token = str_random(32);
        $user2->save();
    }
}
