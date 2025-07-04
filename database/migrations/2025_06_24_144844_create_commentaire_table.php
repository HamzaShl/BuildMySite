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
        //schéma de la table commentaire
        Schema::create('commentaire', function (Blueprint $table) {
        $table->uuid('id_commentaire')->primary(); 
        $table->text('contenu_commentaire');

        //clés étrangères
        $table->uuid('id_dev'); 
        $table->uuid('id_entreprise'); 
        
        // Définition des clés étrangères
        $table->foreign('id_dev')->references('id_dev')->on('dev')->onDelete('cascade');
        $table->foreign('id_entreprise')->references('id_entreprise')->on('entreprise')->onDelete('cascade');
        // Optionnel : contrainte d'unicité pour empêcher plusieurs commentaires par entreprise/dev
        $table->unique(['id_dev', 'id_entreprise']);

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commentaire');
    }
};
