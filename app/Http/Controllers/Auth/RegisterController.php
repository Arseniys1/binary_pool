<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Models\UserSetting;
use App\Models\UserFastStat;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/sources_list';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'terms-1' => 'required|accepted',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    protected function registered(Request $request, $user)
    {
        $user->api_token = str_random(32);
        $user->save();

        UserSetting::create([
            'user_id' => $user->id,
            'name' => 'account_mode',
            'value' => User::LISTENER_MODE,
        ]);

        UserSetting::create([
            'user_id' => $user->id,
            'name' => 'notify_id',
        ]);

        UserSetting::create([
            'user_id' => $user->id,
            'name' => 'demo',
            'value' => User::DEMO_DISABLE,
        ]);

        UserSetting::create([
            'user_id' => $user->id,
            'name' => 'price',
        ]);

        UserSetting::create([
            'user_id' => $user->id,
            'name' => 'days',
            'value' => '1',
        ]);

        UserSetting::create([
            'user_id' => $user->id,
            'name' => 'forever',
            'value' => false,
        ]);

        UserSetting::create([
            'user_id' => $user->id,
            'name' => 'balance',
            'value' => 0,
        ]);

        UserFastStat::create([
            'user_id' => $user->id,
            'account_mode' => User::LISTENER_MODE,
        ]);

        UserFastStat::create([
            'user_id' => $user->id,
            'account_mode' => User::SOURCE_MODE,
        ]);

        UserFastStat::create([
            'user_id' => $user->id,
            'account_mode' => User::DEMO_LISTENER,
        ]);

        UserFastStat::create([
            'user_id' => $user->id,
            'account_mode' => User::DEMO_SOURCE,
        ]);
    }


}
