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
        //schéma de la table entreprise
        Schema::create('entreprise', function (Blueprint $table) {
            $table->uuid('id_entreprise')->primary();
            $table->string('email_entreprise');
            $table->string('password_entreprise');
            $table->string('nom_entreprise');
            $table->string('taille_entreprise');
            $table->string('secteur_entreprise');
            $table->string('type_freelance');
            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entreprise');
    }
};
