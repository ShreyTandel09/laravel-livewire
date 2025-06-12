<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Dashboard;
use App\Livewire\User\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', Register::class)->name('landing-page');
    Route::get('/register', Register::class)->name('register');
    Route::get('/login', Login::class)->name('login');
});

Route::middleware('auth')->group(function () {
    //logout
    Route::post('/logout', function () {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    })->name('logout');

    //dashboard
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::get('/user-profile', Profile::class)->name('profile');
});
