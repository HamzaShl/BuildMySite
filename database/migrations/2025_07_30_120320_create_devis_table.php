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
        Schema::create('devis', function (Blueprint $table) {
        $table->uuid('id_devis')->primary();
        $table->string('titre_devis');
        $table->text('description_devis');                    // ✅ AJOUTER
        $table->decimal('prix', 10, 2);
        $table->string('delai');                              // ✅ AJOUTER ("3 semaines")
        $table->enum('etat_devis', ['en_attente', 'accepte', 'refuse'])->default('en_attente'); // ✅ AJOUTER
        
        // Clés étrangères
        $table->uuid('id_mission');
        $table->uuid('id_dev');
        $table->uuid('id_entreprise');
        
        // Définition des clés étrangères
        $table->foreign('id_mission')->references('id_mission')->on('mission')->onDelete('cascade');
        $table->foreign('id_dev')->references('id_dev')->on('dev')->onDelete('cascade');
        $table->foreign('id_entreprise')->references('id_entreprise')->on('entreprise')->onDelete('cascade');
        
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devis');
    }
};