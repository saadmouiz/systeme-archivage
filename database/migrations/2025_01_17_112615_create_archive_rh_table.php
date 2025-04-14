<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('archive_rh', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->enum('type', [
                'Contrat',
                'Fiche de paie',
                'Registre du personnel',
                'Document de formation'
            ]);
            $table->string('employe_nom')->nullable(); // Pour les documents liés à un employé spécifique
            $table->string('reference')->nullable();
            $table->date('date_document');
            $table->date('date_debut')->nullable(); // Pour les contrats ou formations
            $table->date('date_fin')->nullable(); // Pour les contrats ou formations
            $table->string('statut')->nullable(); // actif, archivé, etc.
            $table->text('description')->nullable();
            $table->string('fichier');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('archive_rh');
    }
};