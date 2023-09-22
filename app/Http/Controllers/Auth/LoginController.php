<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store()
    {
        $attributes = request()->validate([
            // 'email' => 'required|email|exists:users,email',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(auth()->attempt($attributes, request()->filled('remember_me'))){
            session()->regenerate();
            return redirect('/')->with('success', 'Successfully Logged In');
        }

        throw ValidationException::withMessages([
            'email' => 'Your provided credentials are wrong!'
        ]);

        // return back()
        //     ->withInput()
        //     ->withErrors([
        //         'email' => 'Your provided credentials are wrong!'
        //     ]);
    }


    public function logout()
    {
        auth()->logout();

        return redirect('/')->with('success', 'Successfully Logged Out');
    }
}
