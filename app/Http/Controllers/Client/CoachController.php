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

        // 2. Atlasām lietotājus, kuriem ir sesijas, un PIEVIENOJAM datus no 'coaches' tabulas
        $query = DB::table('users')
            ->join('sessions', 'users.Lietotāja_id', '=', 'sessions.Trenera_id')
            ->leftJoin('coaches', 'users.Lietotāja_id', '=', 'coaches.Lietotāja_id') // PIELIKTS KLĀT
            ->select(
                'users.Lietotāja_id', 
                'users.Vārds', 
                'users.Uzvārds', 
                'users.Bio', 
                'coaches.Kvalifikācija',       // PIELIKTS KLĀT
                'coaches.Sertifikācijas_dati'  // PIELIKTS KLĀT
            )
            ->distinct();

        // 3. Ja klients ir izvēlējies konkrētu sporta veidu, filtrējam sesijas pēc tā
        if ($request->has('sport_type') && $request->input('sport_type') != '') {
            $query->where('sessions.Sporta_veida_id', $request->input('sport_type'));
        }

        // Izpildām vaicājumu
        $trainers = $query->get();

        return view('dashboard', compact('trainers', 'sportTypes'));
    }

    /**
     * Parāda konkrēta trenera profilu un viņa kalendāru/sesijas
     */
    public function show($id)
    {
        // 1. Atrodam treneri un PIEVIENOJAM viņa kvalifikāciju un sertifikātus
        $trainer = DB::table('users')
            ->leftJoin('coaches', 'users.Lietotāja_id', '=', 'coaches.Lietotāja_id') // PIELIKTS KLĀT
            ->where('users.Lietotāja_id', $id)
            ->select('users.*', 'coaches.Kvalifikācija', 'coaches.Sertifikācijas_dati') // PIELIKTS KLĀT
            ->first();

        if (!$trainer) {
            abort(404, 'Treneris netika atrasts!');
        }

        // 2. Paņemam visas šī trenera plānotās sesijas un pievienojam sporta veida nosaukumu
        $sessions = DB::table('sessions')
            ->join('sport_types', 'sessions.Sporta_veida_id', '=', 'sport_types.Sporta_veida_id')
            ->where('sessions.Trenera_id', $id)
            ->select('sessions.*', 'sport_types.Nosaukums as SportaVeids')
            ->get();

        // 3. Nosūtām datus uz trenera profila skatu
        return view('client.trainer_profile', compact('trainer', 'sessions'));
    }
}