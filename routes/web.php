<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function () {
    Volt::route('/', 'pages.auth.login')
        ->name('login');
});


Route::middleware('auth')->group(function () {
    Route::post('logout', function () {
        Auth::logout();
        return redirect(route('login'));
    })->name('logout');
    Volt::route('dashboard', 'pages.dashboard.index')->name('dashboard');
    Volt::route('master', 'pages.master.index')->name('master');
    Volt::route('laporan', 'pages.reports.index')->name('laporan');
    Volt::route('settings', 'pages.settings.index')->name('settings');
    Volt::route('pengguna', 'pages.pengguna.index')->name('pengguna');
    Route::name('document')->prefix('document')->group(function () {
        Volt::route('/', 'pages.documents.index');
        Route::name('.nikah.')->prefix('nikah')->group(function () {
            Volt::route('add', 'pages.documents.nikah.create')->name('add');
            Volt::route('edit/{id}', 'pages.documents.nikah.edit')->name('edit');
            Volt::route('show/{id}', 'pages.documents.nikah.show')->name('show');
        });
        Route::name('.n6.')->prefix('n6')->group(function () {
            Volt::route('add', 'pages.documents.n6.create')->name('add');
            Volt::route('edit/{id}', 'pages.documents.n6.edit')->name('edit');
            Volt::route('show/{id}', 'pages.documents.n6.show')->name('show');
        });
    });
});
