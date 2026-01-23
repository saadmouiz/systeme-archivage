<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modifier l'enum pour ajouter 'jour_ferie'
        DB::statement("ALTER TABLE pointages MODIFY COLUMN statut ENUM('present', 'absent', 'retard', 'conge', 'maladie', 'jour_ferie') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Retirer 'jour_ferie' de l'enum
        DB::statement("ALTER TABLE pointages MODIFY COLUMN statut ENUM('present', 'absent', 'retard', 'conge', 'maladie') NOT NULL");
    }
};
