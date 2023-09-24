<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GithubLoginController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('github')->redirect();
    }

    public function callback()
    {
        try {
            $githubUser = Socialite::driver('github')->user();

            // store github user data in db
            $user = User::updateOrCreate([
                'github_id' => $githubUser->id
            ], [
                'name' => $githubUser->name,
                'email' => $githubUser->email,
                'password' => $githubUser->id,
                'avatar' => $githubUser->avatar,
                'github_id' => $githubUser->id,
                'github_token' => $githubUser->token
            ]);

            // authenticate that stored user
            auth()->login($user);

            // response something (In API, we maybe response auth token as JSON)
            return redirect(RouteServiceProvider::HOME);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}