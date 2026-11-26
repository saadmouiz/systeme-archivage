<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('beneficiaires')) {
            return;
        }

        Schema::table('beneficiaires', function (Blueprint $table) {
            if (!Schema::hasColumn('beneficiaires', 'niveau_scolarite')) {
                $table->string('niveau_scolarite')->nullable();
            }
            if (!Schema::hasColumn('beneficiaires', 'services_offerts')) {
                $table->string('services_offerts')->nullable();
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('beneficiaires')) {
            return;
        }

        Schema::table('beneficiaires', function (Blueprint $table) {
            if (Schema::hasColumn('beneficiaires', 'services_offerts')) {
                $table->dropColumn('services_offerts');
            }
            if (Schema::hasColumn('beneficiaires', 'niveau_scolarite')) {
                $table->dropColumn('niveau_scolarite');
            }
        });
    }
};
