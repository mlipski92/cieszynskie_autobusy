<?php

use App\Livewire\Line\CreateLine;
use App\Livewire\Line\EditLine;
use App\Livewire\Line\LineList;
use App\Livewire\Stop\CreateStop;
use App\Livewire\Stop\EditStop;
use App\Livewire\Stop\StopList;
use App\Livewire\Trans\CreateTrans;
use App\Livewire\Trans\EditTrans;
use App\Livewire\Trans\TransList;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// use Illuminate\Support\Facades\Route;
Route::get('/test', function () {
    return "test";
});

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/test-trans', function () {
    // Dane OAuth
    $clientId = '01JZNXT3TS2DC0TBKJGPWJV587-01K06FQYM3GVQYN7JVWFXV9TYM';
    $clientSecret = '36702dd0b89bb1141bb4b7e599d4d55f5d25b7a1d9441da6811641d567c8f7b9';

    // Autoryzacja (Basic Auth do tokenu)
    $auth = base64_encode("$clientId:$clientSecret");

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => 'https://api.tpay.com/oauth/auth',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            'Authorization: Basic ' . $auth,
            'Content-Type: application/x-www-form-urlencoded',
        ],
        CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
    ]);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);
    if (!isset($data['access_token'])) {
        return 'Błąd przy pobieraniu access_token: ' . print_r($data, true);
    }

    $accessToken = $data['access_token'];

    // Przygotowanie danych transakcji
    $transactionData = [
        'amount' => 0.1,
        'description' => 'Test transaction',
        'groupId' => 150, // ← Przelewy online
        'payer' => [
            'email' => 'jan.nowak@example.com',
            'name' => 'Jan Nowak'
        ],
        'callbacks' => [
            'notification' => [
                'url' => 'https://zenitx.pl',
            ],
            'payerUrls' => [
                'success' => 'https://zenitx.pl',
                'error' => 'https://zenitx.pl',
            ],
        ],
    ];

    // Tworzenie transakcji
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => 'https://api.tpay.com/transactions',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json',
        ],
        CURLOPT_POSTFIELDS => json_encode($transactionData),
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $result = json_decode($response, true);
// dd($httpCode);
    if ($httpCode !== 200 || !isset($result['transactionPaymentUrl'])) {
        return "Błąd podczas tworzenia transakcji:<br><pre>" . print_r($result, true) . '</pre>';
    }

    // Przekierowanie użytkownika do strony płatności
   return redirect()->away($result['transactionPaymentUrl']);
});


    Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

    Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

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
