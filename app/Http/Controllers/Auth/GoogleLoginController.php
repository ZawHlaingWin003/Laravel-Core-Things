<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::updateOrCreate([
                'google_id' => $googleUser->id
            ], [
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => $googleUser->id,
                'avatar' => $googleUser->avatar,
                'google_id' => $googleUser->id,
            ]);

            auth()->login($user);

            return redirect(RouteServiceProvider::HOME);
        } catch (\Throwable $th) {
            throw $th;
        }

    }
}
