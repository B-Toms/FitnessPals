<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id('Rezervācijas_id');//PK
            $table->foreignId('Klienta_id')->constrained('clients','Lietotāja_id')->onDelete('cascade');
            $table->foreignId('Sesijas_id')->constrained('sessions','Sesijas_id')->onDelete('cascade');
            $table->dateTime('Veikšanas_laiks');
            $table->string('Statuss',20); // Apstiprināts,atcelts
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
