<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dev', function (Blueprint $table) {
            $table->uuid('id_dev')->primary();
            $table->string('email_dev');
            $table->string('password_dev');
            $table->string('nom_dev');
            $table->string('prenom_dev');
            $table->string('niveau_experience');
            $table->string('specialite_dev');
            $table->text('description')->nullable();
            $table->string('photo')->nullable();
            $table->string('cv')->nullable();
            $table->string('portfolio')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dev');
    }
};
