<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
        'name' => ['required', 'string', 'max:50'], // Šeit mēs izmantojam 'name' kā vārdu pagaidām
        'email' => ['required', 'string', 'email', 'max:100', 'unique:'.User::class.',Epasts'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'role' => ['required', 'string', 'in:client,coach'],
    ]);

    // Izmantojam transakciju drošībai
    DB::transaction(function () use ($request) {
        // 1. Izveidojam pamata lietotāju
        $user = User::create([
            'Vārds' => $request->name,
            'Uzvārds' => 'Uzvārds', // Pagaidām ieliekam default, vēlāk pielāgosim formu
            'Epasts' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 2. Atkarībā no lomas, ierakstām datus saistītajā tabulā
        if ($request->role === 'client') {
            DB::table('clients')->insert([
                'Lietotāja_id' => $user->Lietotāja_id, // Izmantojam mūsu pielāgoto PK lauku
                'Telefona_numurs' => '-',
                'Sagatavotibas_līmenis' => 'Iesācējs',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } elseif ($request->role === 'coach') {
            DB::table('coaches')->insert([
                'Lietotāja_id' => $user->Lietotāja_id,
                'Kvalifikācija' => 'Sertificēts treneris',
                'Sertifikācijas_dati' => '-',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        event(new Registered($user));
        Auth::login($user);
    });

        return redirect()-> intended('/dashboard');
    }
}
