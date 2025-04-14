<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('archive_partenaires', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('type');  // Changé de enum à string
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->string('adresse')->nullable();
            $table->string('responsable')->nullable();
            $table->text('description')->nullable();
            $table->date('date_debut_partenariat')->nullable();
            $table->date('date_fin_partenariat')->nullable();
            $table->string('statut_partenariat')->default('en attente');
            $table->string('fichier')->nullable();
            $table->json('contributions')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('archive_partenaires');
    }
};