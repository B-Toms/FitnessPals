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
            'Sporta_veida_id' => ['required','exists:sport_types, Sporta_veida_id'],
            'Tips'=>['required','string','in:Individuālais,Grupu'],
            'Datums'=> ['required','date', 'after_or_equal:today'],
            'Laiks' =>['required'],
            'Ilgums'=>['required','integer','min:15'],
            'Max_dalībnieku_skaits'=>['required','integer','min:1'],
        ]);
        // 2.saglabājam ierakstu DB
        DB::table('sessions')->insert([
            'Trenera_id' => auth()->user()->Lietotāja_id, // Pašreizējais ielogojies treneris
            'Sporta_veida_id' => $request->Sporta_veida_id,
            'Tips' => $request->Tips,
            'Datums' => $request->Datums,
            'Laiks' => $request->Laiks,
            'Ilgums' => $request->Ilgums,
            'Max_dalībnieku_skaits' => $request->Max_dalībnieku_skaits,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // 3.Pāradresējam atpakal
        return redirect('/coach/dashboard')->with('success','Treniņa sesija veiksmīgi izveidota!');
    }
}
