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
        Schema::create('mission', function (Blueprint $table) {
            $table->uuid('id_mission')->primary();
            $table->string('titre_mission');
            $table->enum('etat_mission', ['en_cours', 'terminee', 'annulee'])->default('en_cours');
            $table->text('description_mission');
            
            // ✅ CLÉS ÉTRANGÈRES OBLIGATOIRES
            $table->uuid('id_entreprise'); // Qui a créé la mission
            $table->uuid('id_dev')->nullable(); // Qui va la réaliser (peut être null au début)
            
            // Définition des clés étrangères
            $table->foreign('id_entreprise')->references('id_entreprise')->on('entreprise')->onDelete('cascade');
            $table->foreign('id_dev')->references('id_dev')->on('dev')->onDelete('set null');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mission');
    }
};