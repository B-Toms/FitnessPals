<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Coach\SessionController; // Pievienojam mūsu jauno sesiju kontrolieri
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\CoachController;

/*
|--------------------------------------------------------------------------
| Web Routes
--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Sākumlapa (Welcome)
Route::get('/', function () {
    return view('welcome');
});

// Klientu panelis (un kopējais starta punkts pēc ielogošanās parastam lietotājam)
Route::get('/dashboard', 'App\\Http\\Controllers\\Client\\CoachController@index')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/trainer/{id}', ['App\\Http\Controllers\\Client\\CoachController', 'show'])->name('trainer.show');

Route::post('/book-session/{id}', [\App\Http\Controllers\Client\BookingController::class, 'store'])->name('bookings.store');

// TIKAI TRENERU SADAĻA (Aizsargāta ar auth un mūsu pašu coach middleware)
Route::middleware(['auth', 'coach'])->group(function () {
    
    // Trenera galvenais panelis (datus sagatavo un padod SessionController)
    Route::get('/coach/dashboard', [SessionController::class, 'index'])->name('coach.dashboard');

    // Maršruti treniņu sesiju izveidei un saglabāšanai datubāzē
    Route::get('/coach/sessions/create', [SessionController::class, 'create'])->name('coach.sessions.create');
    Route::post('/coach/sessions', [SessionController::class, 'store'])->name('coach.sessions.store');
});

// PROFILA LABOŠANAS MARŠRUTI (Breeze noklusējuma, pieejami visiem ielogotiem)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
