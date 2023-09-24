<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class FacebookLoginController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();

            $user = User::updateOrCreate([
                'facebook_id' => $facebookUser->id
            ], [
                'name' => $facebookUser->name,
                'email' => $facebookUser->email,
                'password' => $facebookUser->id,
                'avatar' => $facebookUser->avatar,
                'facebook_id' => $facebookUser->id,
                'facebook_token' => $facebookUser->token
            ]);

            auth()->login($user);

            return redirect(RouteServiceProvider::HOME . '#');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
