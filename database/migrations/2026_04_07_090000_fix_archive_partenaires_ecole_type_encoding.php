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
        DB::table('archive_partenaires')
            ->whereIn('type', ['??cole', '?cole', 'ecole', 'Ecole', 'École'])
            ->update(['type' => 'école']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Pas de rollback fiable pour restaurer les anciennes variantes corrompues.
    }
};
