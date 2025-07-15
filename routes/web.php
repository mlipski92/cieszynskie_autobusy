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

Route::get('/', function () {




// Dane dostępowe do Tpay (Client ID i Client Secret)
$clientId = '01JZNXT3TS2DC0TBKJGPWJV587-01K06FQYM3GVQYN7JVWFXV9TYM';
$clientSecret = '36702dd0b89bb1141bb4b7e599d4d55f5d25b7a1d9441da6811641d567c8f7b9';

// Tworzymy połączenie cURL
$ch = curl_init();

// Ustawiamy podstawową autoryzację (Basic Auth)
$auth = base64_encode("$clientId:$clientSecret");

curl_setopt($ch, CURLOPT_URL, 'https://api.tpay.com/oauth/auth');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);

// Ustawiamy nagłówki
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Basic ' . $auth,
    'Content-Type: application/x-www-form-urlencoded',
]);

// Treść zapytania (grant_type wymagany przez Tpay OAuth2)
curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');

// Wysyłamy zapytanie i pobieramy odpowiedź
$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Błąd: ' . curl_error($ch);
    curl_close($ch);
    exit;
}

curl_close($ch);

// Przetwarzamy odpowiedź JSON
$data = json_decode($response, true);

if (isset($data['access_token'])) {
    echo "Access token: " . $data['access_token'];
} else {
    echo "Błąd przy pobieraniu access_token: ";
    print_r($data);
}





    return view('home');
})->name('home');

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
