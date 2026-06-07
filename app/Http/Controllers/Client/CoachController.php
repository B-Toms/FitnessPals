<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoachController extends Controller
{
    /**
     * Parāda treneru sarakstu un sporta veidu filtru klientam
     */
    public function index(Request $request)
    {
        // 1. Paņemam visus sporta veidus dropdown izvēlnei
        $sportTypes = DB::table('sport_types')->get();

        // 2. Atlasām tikai tos lietotājus no 'users' tabulas, kuri ir ierakstīti 'sessions' tabulā kā treneri
        $query = DB::table('users')
            ->join('sessions', 'users.Lietotāja_id', '=', 'sessions.Trenera_id')
            ->select('users.Lietotāja_id', 'users.Vārds', 'users.Uzvārds', 'users.Bio')
            ->distinct();

        // 3. Ja klients ir izvēlējies konkrētu sporta veidu, filtrējam sesijas pēc tā
        if ($request->has('sport_type') && $request->input('sport_type') != '') {
            $query->where('sessions.Sporta_veida_id', $request->input('sport_type'));
        }

        // Izpildām vaicājumu
        $trainers = $query->get();

        return view('dashboard', compact('trainers', 'sportTypes'));
    }
}