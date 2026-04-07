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
        DB::table('beneficiaires')
            ->where('type', 'like', '%ducatif%')
            ->update(['type' => 'Document éducatif']);

        DB::table('beneficiaires')
            ->where('type', 'like', '%ndividuel%')
            ->update(['type' => 'Dossier individuel']);

        DB::table('beneficiaires')
            ->where('type', 'like', '%uridique%')
            ->update(['type' => 'Conflits d\'ordre juridique']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Pas de rollback fiable car on standardise des valeurs corrompues.
    }
};
