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
        //schéma de la table développeur
        Schema::create('dev', function (Blueprint $table) {
            $table->uuid('id_dev')->primary();
            $table->string('email_dev');
            $table->string('password_dev');
            $table->string('nom_dev');
            $table->string('prenom_dev');
            $table->string('experience_dev');
            $table->string('competence_dev');
            $table->string('description_dev');
            $table->string('image_dev')->nullable();
            $table->string('photo_profil_dev')->nullable();
            $table->string('cv_dev')->nullable(); 
            $table->string('portfolio_dev')->nullable(); 

            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devs');
    }
};
