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
        // Supprimer la colonne type et la recréer comme string
        Schema::table('archive_financiers', function (Blueprint $table) {
            $table->dropColumn('type');
        });
        
        Schema::table('archive_financiers', function (Blueprint $table) {
            $table->string('type', 100)->after('titre');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restaurer la colonne type comme enum
        Schema::table('archive_financiers', function (Blueprint $table) {
            $table->dropColumn('type');
        });
        
        Schema::table('archive_financiers', function (Blueprint $table) {
            $table->enum('type', [
                'Budget prévisionnel',
                'Bilan financier annuel',
                'Rapport commissaire',
                'Relevé bancaire',
                'Facture/Justificatif',
                'Registre dons/subventions'
            ])->after('titre');
        });
    }
};
