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
        Schema::table('archive_rh', function (Blueprint $table) {
            $table->dropColumn('type');
        });
        
        Schema::table('archive_rh', function (Blueprint $table) {
            $table->string('type', 100)->after('titre');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restaurer la colonne type comme enum
        Schema::table('archive_rh', function (Blueprint $table) {
            $table->dropColumn('type');
        });
        
        Schema::table('archive_rh', function (Blueprint $table) {
            $table->enum('type', [
                'Contrat',
                'Fiche de paie',
                'Registre du personnel',
                'Document de formation'
            ])->after('titre');
        });
    }
};
