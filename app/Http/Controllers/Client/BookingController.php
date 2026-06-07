<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Veic treniņa sesijas rezervāciju
     */
    public function store($id)
    {
        $userId = Auth::user()->Lietotāja_id; // Pašreizējais ielogojies klients

        // 1. Atrodam sesiju
        $session = DB::table('sessions')->where('Sesijas_id', $id)->first();

        if (!$session) {
            return redirect()->back()->with('error', 'Sesija netika atrasta!');
        }

        // 2. Pārbaudām, vai ir brīvas vietas
        if ($session->Max_dalībnieku_skaits <= 0) {
            return redirect()->back()->with('error', 'Diemžēl šajā treniņā vairs nav brīvu vietu!');
        }

        // 3. Pārbaudām, vai šis klients JAU NAV rezervējis šo sesiju
        $alreadyBooked = DB::table('bookings')
            ->where('Klienta_id', $userId)
            ->where('Sesijas_id', $id)
            ->exists();

        if ($alreadyBooked) {
            return redirect()->back()->with('error', 'Tu jau esi pieteicies šim treniņam!');
        }

        // DB Transakcija, lai nodrošinātu, ka dati saglabājas droši
        DB::transaction(function () use ($id, $userId) {
            // 4. Izveidojam ierakstu bookings tabulā
            DB::table('bookings')->insert([
                'Klienta_id' => $userId,
                'Sesijas_id' => $id,
                'created_at' => now(),
                'Veikšanas_laiks' => now(),
                'Statuss' => 'Apstiprināts',
            ]);

            // 5. Samazinām brīvo vietu skaitu sesijai par 1
            DB::table('sessions')
                ->where('Sesijas_id', $id)
                ->decrement('Max_dalībnieku_skaits');
        });

        return redirect()->back()->with('success', 'Rezervācija veiksmīgi reģistrēta!');
    }
}