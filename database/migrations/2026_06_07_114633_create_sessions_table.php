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
        Schema::create('sessions', function (Blueprint $table) {
            $table->id('Sesijas_id');//PK
            $table->foreignId('Trenera_id')->constrained('coaches','Lietotāja_id')->onDelete('cascade');
            $table->foreignId('Sporta_veida_id')->constrained('sport_types','Sporta_veida_id')->onDelete('cascade');
            $table->string('Tips',20);//Indivduālais/grupu
            $table->date('Datums');
            $table->time('Laiks');
            $table->integer('Ilgums');
            $table->integer('Max_dalībnieku_skaits');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
