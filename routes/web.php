<?php

use App\Livewire\Trans\CreateTrans;
use App\Livewire\Trans\EditTrans;
use App\Livewire\Trans\TransList;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

    Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

    Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('/trans/create', CreateTrans::class)->name('trans.create');
    Route::get('/trans/list', TransList::class)->name('trans.list');
    Route::get('/trans/{id}/edit', EditTrans::class)->name('trans.edit');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
