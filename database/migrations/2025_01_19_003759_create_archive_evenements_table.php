<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('evenements', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description');
            $table->enum('type', ['interne', 'externe']);
            $table->enum('categorie', ['collecte', 'conference', 'campagne', 'autre']);
            $table->dateTime('date_debut');
            $table->dateTime('date_fin');
            $table->string('lieu');
            $table->integer('nombre_participants')->nullable();
            $table->decimal('budget', 10, 2)->nullable();
            $table->enum('statut', ['planifie', 'en_cours', 'termine', 'annule'])->default('planifie');
            $table->timestamps();
            $table->softDeletes();
        });

        // Table pour les médias des événements
        Schema::create('evenement_medias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evenement_id')->constrained('evenements')->onDelete('cascade');
            $table->string('type_media'); // photo, video, document
            $table->string('chemin_fichier');
            $table->string('titre')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Table pour les témoignages
        Schema::create('temoignages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evenement_id')->constrained('evenements')->onDelete('cascade');
            $table->string('nom_temoin');
            $table->text('contenu');
            $table->boolean('est_approuve')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('temoignages');
        Schema::dropIfExists('evenement_medias');
        Schema::dropIfExists('evenements');
    }
};