<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

    /**
     * Parāda treniņa izveides formu
     */
class SessionController extends Controller
{
    /**
     * Parāda trenera galveno paneli ar viņa sesijām
     */
    public function index(){
        $sessions = DB::table('sessions')
            ->join('sport_types', 'sessions.Sporta_veida_id', '=', 'sport_types.Sporta_veida_id')
            ->where('sessions.Trenera_id', auth()->user()->Lietotāja_id)
            ->orderBy('sessions.Datums', 'asc')
            ->orderBy('sessions.Laiks', 'asc')
            ->get();

        return view('coach.dashboard', compact('sessions'));
    }
    public function create(){
        // Paņemam visus sporta veidus no datubāzes, lai treneris varētu izvēlēties izkrītošajā izvēlnē
        $sportTypes = DB::table('sport_types')->get();
        return view('coach.create_session',compact('sportTypes'));
    }

    /**
     * Saglabā jauno treniņu datubāzē
     */
    public function store(Request $request){
        // 1. Validējam ievadītos datus atbilstoši mūsu sessions tabulai
        $request->validate([
            'Sporta_veida_id' => ['required','exists:sport_types,Sporta_veida_id'],
            'Tips'=>['required','string','in:Individuālais,Grupu'],
            'Datums'=> ['required','date', 'after_or_equal:today'],
            'Laiks' =>['required'],
            'Ilgums'=>['required','integer','min:15'],
            'Max_dalībnieku_skaits'=>['required','integer','min:1'],
        ]);
        // Ja izvēlēts individuālais treniņš, piespiedu kārtā uzliekam 1 vietu
        $maxDalibnieki = $request->input('Tips') === 'Individuālais' ? 1 : $request->input('Max_dalībnieku_skaits');
        // 2.saglabājam ierakstu DB
        DB::table('sessions')->insert([
            'Trenera_id' => auth()->user()->Lietotāja_id, // Pašreizējais ielogojies treneris
            'Sporta_veida_id' => $request->Sporta_veida_id,
            'Tips' => $request->Tips,
            'Datums' => $request->Datums,
            'Laiks' => $request->Laiks,
            'Ilgums' => $request->Ilgums,
            'Max_dalībnieku_skaits' => $maxDalibnieki, //izmantoju jauno mainīgo
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // 3.Pāradresējam atpakal
        return redirect('/coach/dashboard')->with('success','Treniņa sesija veiksmīgi izveidota!');

    }
    /**
     * Dzēš konkrētu treniņa sesiju un visas piesaistītās rezervācijas
     */
    public function destroy($id)
    {
        // Izmantojam transakciju, lai droši izdzēstu datus no abām tabulām
        \Illuminate\Support\Facades\DB::transaction(function () use ($id) {
            // 1. Vispirms izdzēšam visas rezervācijas, kas pieteiktas šai sesijai
        \Illuminate\Support\Facades\DB::table('bookings')->where('Sesijas_id', $id)->delete();

            // 2. Tagad izdzēšam pašu sesiju
        \Illuminate\Support\Facades\DB::table('sessions')->where('Sesijas_id', $id)->delete();
        });

        return redirect()->back()->with('success', 'Sesija veiksmīgi izdzēsta!');
    }

    /**
     * Parāda sesijas rediģēšanas formu ar sporta veidu sarakstu
     */
    public function edit($id)
    {
        // 1. Atlasām konkrēto sesiju
        $session = \Illuminate\Support\Facades\DB::table('sessions')->where('Sesijas_id', $id)->first();

        if (!$session) {
            return redirect()->route('coach.dashboard')->with('error', 'Sesija netika atrasta!');
        }

        // 2. Atlasām visus sporta veidus no TAVAS ĪSTĀS tabulas 'sport_types'
        $sports = \Illuminate\Support\Facades\DB::table('sport_types')->get();

        // 3. Padodam abus mainīgos uz skatu
        return view('coach.edit_session', compact('session', 'sports'));
    }
    /**
     * Saglabā veiktos labojumus sesijā
     */
    public function update(Request $request, $id)
    {
        // 1. Validācija, izmantojot precīzos formas laukus
        $request->validate([
            'Sporta_veida_id'        => 'required|integer',
            'Tips'                   => 'required|string|max:20',
            'Datums'                 => 'required|date',
            'Laiks'                  => 'required',
            'Ilgums'                 => 'required|integer',
            'Max_dalibnieku_skaits'  => 'required|integer|min:0',
        ]);

        // 2. Ierakstām datus datubāzē precīzajās kolonnās pēc DESCRIBE struktūras
        \Illuminate\Support\Facades\DB::table('sessions')
            ->where('Sesijas_id', $id)
            ->update([
                'Sporta_veida_id'       => $request->Sporta_veida_id,
                'Tips'                  => $request->Tips,
                'Datums'                => $request->Datums,
                'Laiks'                 => $request->Laiks,
                'Ilgums'                => $request->Ilgums,
                'Max_dalībnieku_skaits' => $request->Max_dalibnieku_skaits,
                'updated_at'            => now()
            ]);

        // 3. Atgriežamies uz paneli
        return redirect()->route('coach.dashboard')->with('success', 'Sesijas dati veiksmīgi atjaunināti!');
    }
}
