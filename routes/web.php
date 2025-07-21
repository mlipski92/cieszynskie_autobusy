<?php

use App\Http\Controllers\FrontController;
use App\Http\Controllers\PaymentController;
use App\Livewire\Line\CreateLine;
use App\Livewire\Line\EditLine;
use App\Livewire\Line\LineList;
use App\Livewire\Order\ListOrder;
use App\Livewire\Stop\CreateStop;
use App\Livewire\Stop\EditStop;
use App\Livewire\Stop\StopList;
use App\Livewire\Trans\CreateTrans;
use App\Livewire\Trans\EditTrans;
use App\Livewire\Trans\TransList;
use App\Models\LineStopRelation;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

    Route::get('/kup-bilet', [FrontController::class, 'buyTicket'])->name('bilet.kup');
    Route::get('/success', [FrontController::class, 'successPage'])->name('success');

    Route::post('/checkout', [FrontController::class, 'checkout']);
    Route::get('/', function () {
        return view('home');
    })->name('home');


    Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

    Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('/order/list', ListOrder::class)->name('order.list');
    Route::post('/order/checkstatus', [PaymentController::class, 'checkstatus'])->name('order.checkstatus');

    Route::get('/trans/create', CreateTrans::class)->name('trans.create');
    Route::get('/trans/list', TransList::class)->name('trans.list');
    Route::get('/trans/{id}/edit', EditTrans::class)->name('trans.edit');

    Route::get('/stop/create', CreateStop::class)->name('stop.create');
    Route::get('/stop/list', StopList::class)->name('stop.list');
    Route::get('/stop/{id}/edit', EditStop::class)->name('stop.edit');

    Route::get('/line/create', CreateLine::class)->name('line.create');
    Route::get('/line/list', LineList::class)->name('line.list');
    Route::get('/line/{id}/edit', EditLine::class)->name('line.edit');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
