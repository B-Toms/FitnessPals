<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Coach\SessionController; // Pievienojam mūsu jauno sesiju kontrolieri
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

// Klientu panelis (un kopējais starta punkts)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Tikai Treneru sadaļa (Aizsargāta ar auth un mūsu coach middleware)
Route::middleware(['auth', 'coach'])->group(function () {
    
    // Trenera galvenais panelis
    Route::get('/coach/dashboard', function () {
        return view('coach.dashboard');
    })->name('coach.dashboard');

    // Jaunie maršruti treniņu sesiju izveidei un saglabāšanai
    Route::get('/coach/sessions/create', [SessionController::class, 'create'])->name('coach.sessions.create');
    Route::post('/coach/sessions', [SessionController::class, 'store'])->name('coach.sessions.store');
});

// Profila labošanas maršruti (Breeze noklusējuma)

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
