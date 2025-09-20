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
            $table->enum('genre', ['Homme', 'Femme'])->nullable()->after('cin');
            // Modifier le champ status existant pour accepter nos nouvelles valeurs
            $table->string('status')->default('en attente')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beneficiaires', function (Blueprint $table) {
            $table->dropColumn('genre');
            // Restaurer le status à sa valeur par défaut originale
            $table->string('status')->default('en attente')->change();
        });
    }
};
