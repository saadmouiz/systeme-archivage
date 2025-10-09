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
        Schema::table('beneficiaires', function (Blueprint $table) {
            // Vérifier si la colonne n'existe pas déjà avant de l'ajouter
            if (!Schema::hasColumn('beneficiaires', 'ville')) {
                $table->string('ville')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beneficiaires', function (Blueprint $table) {
            if (Schema::hasColumn('beneficiaires', 'ville')) {
                $table->dropColumn('ville');
            }
        });
    }
};
