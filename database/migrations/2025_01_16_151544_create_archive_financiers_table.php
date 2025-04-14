<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('archive_financiers', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->enum('type', [
                'Budget prévisionnel',
                'Bilan financier annuel',
                'Rapport commissaire',
                'Relevé bancaire',
                'Facture/Justificatif',
                'Registre dons/subventions'
            ]);
            $table->string('reference')->nullable(); // Numéro de facture, référence bancaire, etc.
            $table->decimal('montant', 15, 2)->nullable();
            $table->date('date_document');
            $table->text('description')->nullable();
            $table->string('fichier');
            $table->year('annee_financiere')->nullable();
            $table->string('statut')->nullable(); // payé, en attente, validé, etc.
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('archive_financiers');
    }
};