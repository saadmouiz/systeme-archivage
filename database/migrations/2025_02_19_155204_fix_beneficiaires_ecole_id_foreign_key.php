<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('beneficiaires', function (Blueprint $table) {
            // Supprimer l'ancienne contrainte de clé étrangère
            $table->dropForeign(['ecole_id']);
            
            // Ajouter la nouvelle contrainte vers la bonne table
            $table->foreign('ecole_id')
                  ->references('id')
                  ->on('archive_partenaires')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('beneficiaires', function (Blueprint $table) {
            // Supprimer la contrainte
            $table->dropForeign(['ecole_id']);
        });
    }
};