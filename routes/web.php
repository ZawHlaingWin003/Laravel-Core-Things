<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Image\FolderController;
use App\Http\Controllers\Image\ImageController;
use App\Http\Controllers\PostController;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/auth/github/redirect', function () {
    return Socialite::driver('github')->redirect();
});

Route::get('/auth/github/callback', function () {
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
});


Route::get('/auth/google/redirect', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/auth/google/callback', function () {
    try {
        $googleUser = Socialite::driver('google')->user();

        // store github user data in db
        $user = User::updateOrCreate([
            'google_id' => $googleUser->id
        ], [
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'password' => $googleUser->id,
            'avatar' => $googleUser->avatar,
            'google_id' => $googleUser->id,
        ]);

        // authenticate that stored user
        auth()->login($user);

        // response something (In API, we maybe response auth token as JSON)
        return redirect(RouteServiceProvider::HOME);

    } catch (\Throwable $th) {
        throw $th;
    }
});


Route::middleware('auth')->group(function () {
    Route::get('/', HomeController::class)->name('home');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::controller(FolderController::class)->group(function () {
        Route::get('/folders', 'index')->name('folder.index');

        Route::get('/ajax/folders', 'getFolders')->name('folder.ajax.index');
        Route::delete('/folders/{id}', 'destroy')->name('folder.destroy');
        Route::put('/folders/{id}', 'update')->name('folder.update');

        Route::get('/folders/create', 'create')->name('folder.create');
        Route::post('/folders/store', 'store')->name('folder.store');

        Route::get('/folders/{id}', 'show')->name('folder.show');
    });

    Route::controller(ImageController::class)->group(function () {
        Route::get('/ajax/images/{folder_id}', 'index')->name('image.ajax.index');
        Route::post('/images/store', 'store')->name('image.store');
        Route::delete('/images/{id}', 'destroy')->name('image.destroy');
    });

    Route::resource('/posts', PostController::class);

});


Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});