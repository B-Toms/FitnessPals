<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';
    
    protected $primaryKey = 'Lietotāja_id';

    protected $fillable = [
        'Vārds',
        'Uzvārds',
        'Epasts',
        'password',
        'loma',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Pārbauda, vai lietotājs ir klients
     */
    public function isClient(): bool
    {
        return \Illuminate\Support\Facades\DB::table('clients')
            ->where('Lietotāja_id', $this->Lietotāja_id)
            ->exists();
    }

    /**
     * Pārbauda, vai lietotājs ir treneris
     */
    public function isCoach(): bool 
    {
        return \Illuminate\Support\Facades\DB::table('coaches') //Ļauj php piekļūt db
            ->where('Lietotāja_id', $this->Lietotāja_id)
            ->exists();
    }
    /**
 * Norāda Laravel, kura kolonna tiek izmantota kā lietotājvārds autorizācijai.
 */
public function getAuthIdentifierName()
{
    return 'Lietotāja_id'; // Šim ir jābūt ID
}

// Šī ir tā funkcija, kas nosaka, kuru lauku izmantot kā e-pastu/username!
public function getEmailForPasswordReset()
{
    return $this->Epasts;
}
}