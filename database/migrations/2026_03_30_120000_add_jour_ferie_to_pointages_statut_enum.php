<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE pointages
            MODIFY COLUMN statut ENUM('present', 'absent', 'retard', 'conge', 'maladie', 'jour_ferie')
            NOT NULL
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE pointages
            MODIFY COLUMN statut ENUM('present', 'absent', 'retard', 'conge', 'maladie')
            NOT NULL
        ");
    }
};
