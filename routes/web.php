<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Coach\SessionController;
use App\Http\Controllers\Client\CoachController;
use App\Http\Controllers\Client\BookingController;
use Illuminate\Support\Facades\Route;

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

// SĀKUMLAPA (Welcome)
Route::get('/', function () {
    return view('welcome');
});


// ==========================================
// KLIENTU / PARASTO LIETOTĀJU SADAĻA
// ==========================================
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Klientu panelis un treneru saraksts
    Route::get('/dashboard', [CoachController::class, 'index'])->name('dashboard');
    
    // Trenera profila apskate un kalendārs
    Route::get('/trainer/{id}', [CoachController::class, 'show'])->name('trainer.show');
    
    // Treniņa rezervācijas veikšana
    Route::post('/book-session/{id}', [BookingController::class, 'store'])->name('bookings.store');
});


// ==========================================
// TIKAI TRENERU SADAĻA (Aizsargāta)
// ==========================================
Route::middleware(['auth', 'coach'])->group(function () {
    
    // Trenera galvenais panelis
    Route::get('/coach/dashboard', [SessionController::class, 'index'])->name('coach.dashboard');

    // Sesiju izveide (Forma un saglabāšana)
    Route::get('/coach/sessions/create', [SessionController::class, 'create'])->name('coach.sessions.create');
    Route::post('/coach/sessions', [SessionController::class, 'store'])->name('coach.sessions.store');

    // Sesiju rediģēšana (Update)
    Route::get('/coach/sessions/{id}/edit', [SessionController::class, 'edit'])->name('sessions.edit');
    Route::put('/coach/sessions/{id}', [SessionController::class, 'update'])->name('sessions.update');

    // Sesiju dzēšana (Delete)
    Route::delete('/coach/sessions/{id}', [SessionController::class, 'destroy'])->name('sessions.destroy');
});


// ==========================================
// PAMATA PROFILA MARŠRUTI (Breeze noklusējuma)
// ==========================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';