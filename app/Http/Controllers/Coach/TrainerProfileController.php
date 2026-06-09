<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TrainerProfileController extends Controller
{
    /**
     * Parāda profila labošanas formu
     */
    public function edit()
    {
        $userId = Auth::user()->Lietotāja_id;

        // Atrodam trenera specifiskos datus pēc Lietotāja_id
        $coachData = DB::table('coaches') // Pārliecinies, vai DB tabula saucas 'treners' vai 'coaches'
            ->where('Lietotāja_id', $userId)
            ->first();

        return view('coach.profile_edit', compact('coachData'));
    }

    /**
     * Saglabā izmaiņas datubāzē
     */
    public function update(Request $request)
    {
        $userId = Auth::user()->Lietotāja_id;

        // Validējam datus
        $request->validate([
            'Kvalifikācija' => 'required|string',
            'Sertifikācijas_dati' => 'required|string',
        ]);

        // Atjauninām ierakstu trenera tabulā
        DB::table('coaches')
            ->where('Lietotāja_id', $userId)
            ->update([
                'Kvalifikācija' => $request->input('Kvalifikācija'),
                'Sertifikācijas_dati' => $request->input('Sertifikācijas_dati'),
                'updated_at' => now(),
            ]);

        return redirect()->back()->with('success', 'Profila informācija veiksmīgi saglabāta!');
    }
}