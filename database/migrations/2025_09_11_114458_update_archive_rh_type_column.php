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
        Schema::table('archive_rh', function (Blueprint $table) {
            // Modifier la colonne type de enum vers string pour permettre plus de flexibilité
            $table->string('type')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('archive_rh', function (Blueprint $table) {
            // Revenir à l'enum original
            $table->enum('type', [
                'Contrat',
                'Fiche de paie',
                'Registre du personnel',
                'Document de formation'
            ])->change();
        });
    }
};
