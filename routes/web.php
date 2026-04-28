<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\ForgotPasswordController;

Route::get('/login', function () {
    return view('Login');
})->name('login');

Route::get('/register', function () {
    return view('Register');
})->name('register');


Route::get('/forgot-password', function () {
    return view('ForgotPassword');
})->name('forgot-password');

Route::get('/dashboard', function () {
    return view('Dashboard');
})->name('dashboard');


Route::get('/login-google', function () {
    return Socialite::driver('google')->redirect();
})->name('login-google');
 
Route::get('/google-callback', function () {
    $user = Socialite::driver('google')->user();
    $userExists = User::where('external_id', $user->id)->where('external_auth', 'google')->first();
    if($userExists){
        Auth::login($userExists);
    } else {
        $nuevoUser = User::create([
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'external_id' => $user->id,
            'external_auth' => 'google',

        ]);
        
        Auth::login($nuevoUser);
    }

    return redirect('/dashboard');
    // $user->token
});

Route::post('/forgot-password', [ForgotPasswordController::class, 'enviarResteoLink'])->name('password.email');