<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('beneficiaires', function (Blueprint $table) {
            if (!Schema::hasColumn('beneficiaires', 'nom_association')) {
                $table->string('nom_association')->nullable()->after('ass_eps');
            }
        });
    }

    public function down(): void
    {
        Schema::table('beneficiaires', function (Blueprint $table) {
            if (Schema::hasColumn('beneficiaires', 'nom_association')) {
                $table->dropColumn('nom_association');
            }
        });
    }
};
