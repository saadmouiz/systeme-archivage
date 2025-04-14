<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('communications', function (Blueprint $table) {
            $table->id();
            $table->string('type');  // Médias et Publications, Campagnes de sensibilisation, Rapports d'activités
            $table->string('titre');
            $table->text('description')->nullable();
            $table->date('date_publication');
            $table->string('fichier');  // Chemin du fichier stocké
            $table->string('format_type');  // video, image, article, pdf
            $table->json('metadata')->nullable();  // Stockage de métadonnées supplémentaires
            $table->timestamps();
            $table->softDeletes();  // Pour la suppression douce
            
            // Ajout d'index pour améliorer les performances des recherches
            $table->index('type');
            $table->index('format_type');
            $table->index('date_publication');
        });
    }

    public function down()
    {
        Schema::dropIfExists('communications');
    }
};