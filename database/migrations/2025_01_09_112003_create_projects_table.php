<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projets', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // Type de projet
            $table->string('nom');
            $table->string('responsable')->nullable();
            $table->text('description')->nullable();
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->string('statut')->default('en cours');
            $table->string('fichier')->nullable(); // Pour stocker les documents
            $table->json('metadata')->nullable(); // Pour des informations supplémentaires
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projets');
    }
};