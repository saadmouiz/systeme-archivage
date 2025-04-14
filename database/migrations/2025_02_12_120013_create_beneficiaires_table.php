<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('beneficiaires', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('cin')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->text('description')->nullable();
            $table->string('fichier')->nullable();
            $table->unsignedBigInteger('ecole_id')->nullable();
            $table->string('type')->nullable();
            $table->string('status')->default('en attente');
            $table->timestamps();
            $table->softDeletes();

            // Clé étrangère vers la table association_partenaires (écoles)
            $table->foreign('ecole_id')
      ->references('id')
      ->on('archive_partenaires') // Nouvelle table
      ->onDelete('set null');

        });
    }

    public function down()
    {
        Schema::dropIfExists('beneficiaires');
    }
};