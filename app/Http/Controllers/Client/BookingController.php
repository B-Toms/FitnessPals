<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * 1. PARĀDA REZERVĀCIJU SARAKSTU
     */
    public function index()
    {
        $userId = Auth::user()->Lietotāja_id;

        $bookings = DB::table('bookings')
            ->join('sessions', 'bookings.Sesijas_id', '=', 'sessions.Sesijas_id')
            ->join('sport_types', 'sessions.Sporta_veida_id', '=', 'sport_types.Sporta_veida_id')
            ->where('bookings.Klienta_id', $userId)
            ->select(
                'bookings.Rezervācijas_id as id', 
                'sport_types.Nosaukums as sporta_veids',
                'sessions.Tips',
                'sessions.Datums',
                'sessions.Laiks',
                'sessions.Ilgums'
            )
            ->get();

        return view('client.bookings', compact('bookings'));
    }

    /**
     * 2. VEIC REZERVĀCIJU
     */
    public function store($id)
    {
        $userId = Auth::user()->Lietotāja_id;

        $session = DB::table('sessions')->where('Sesijas_id', $id)->first();

        if (!$session) {
            return redirect()->back()->with('error', 'Sesija netika atrasta!');
        }

        if ($session->Max_dalībnieku_skaits <= 0) {
            return redirect()->back()->with('error', 'Diemžēl šajā treniņā vairs nav brīvu vietu!');
        }

        $alreadyBooked = DB::table('bookings')
            ->where('Klienta_id', $userId)
            ->where('Sesijas_id', $id)
            ->exists();

        if ($alreadyBooked) {
            return redirect()->back()->with('error', 'Tu jau esi pieteicies šim treniņam!');
        }

        DB::transaction(function () use ($id, $userId) {
            DB::table('bookings')->insert([
                'Klienta_id' => $userId,
                'Sesijas_id' => $id,
                'created_at' => now(),
                'Veikšanas_laiks' => now(),
                'Statuss' => 'Apstiprināts',
            ]);

            DB::table('sessions')
                ->where('Sesijas_id', $id)
                ->decrement('Max_dalībnieku_skaits');
        });

        return redirect()->back()->with('success', 'Rezervācija veiksmīgi reģistrēta!');
    }

    /**
     * 3. ATCEL REZERVĀCIJU
     */
    public function destroy($id)
    {
        $userId = Auth::user()->Lietotāja_id;

        // Pārbaudām rezervāciju pēc pareizās kolonnas 'Rezervācijas_id'
        $booking = DB::table('bookings')
            ->where('Rezervācijas_id', $id) // SALABOTS: 'ā' burts ar garumzīmi!
            ->where('Klienta_id', $userId)
            ->first();

        if (!$booking) {
            return redirect()->back()->with('error', 'Rezervācija netika atrasta!');
        }

        DB::transaction(function () use ($booking) {
            // Dzēšam ierakstu, izmantojot pareizo DB kolonnu
            DB::table('bookings')->where('Rezervācijas_id', $booking->Rezervācijas_id)->delete();

            DB::table('sessions')
                ->where('Sesijas_id', $booking->Sesijas_id)
                ->increment('Max_dalībnieku_skaits');
        });

        return redirect()->route('client.bookings.index')->with('success', 'Rezervācija veiksmīgi atcelta!');
    }
}