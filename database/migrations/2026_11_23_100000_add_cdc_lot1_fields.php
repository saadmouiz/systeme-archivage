<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('beneficiaires', function (Blueprint $table) {
            if (!Schema::hasColumn('beneficiaires', 'date_naissance')) {
                $table->date('date_naissance')->nullable()->after('age');
            }
            if (!Schema::hasColumn('beneficiaires', 'situation_sociale')) {
                $table->string('situation_sociale')->nullable()->after('genre');
            }
            if (!Schema::hasColumn('beneficiaires', 'situation_sociale_precision')) {
                $table->string('situation_sociale_precision')->nullable()->after('situation_sociale');
            }
        });

        Schema::table('visiteurs', function (Blueprint $table) {
            if (!Schema::hasColumn('visiteurs', 'genre')) {
                $table->string('genre')->nullable()->after('cin');
            }
        });

        if (Schema::hasTable('employees') && !Schema::hasColumn('employees', 'genre')) {
            Schema::table('employees', function (Blueprint $table) {
                $table->string('genre')->nullable()->after('prenom');
            });
        }
    }

    public function down(): void
    {
        Schema::table('beneficiaires', function (Blueprint $table) {
            if (Schema::hasColumn('beneficiaires', 'situation_sociale_precision')) {
                $table->dropColumn('situation_sociale_precision');
            }
            if (Schema::hasColumn('beneficiaires', 'situation_sociale')) {
                $table->dropColumn('situation_sociale');
            }
            if (Schema::hasColumn('beneficiaires', 'date_naissance')) {
                $table->dropColumn('date_naissance');
            }
        });

        Schema::table('visiteurs', function (Blueprint $table) {
            if (Schema::hasColumn('visiteurs', 'genre')) {
                $table->dropColumn('genre');
            }
        });

        if (Schema::hasTable('employees') && Schema::hasColumn('employees', 'genre')) {
            Schema::table('employees', function (Blueprint $table) {
                $table->dropColumn('genre');
            });
        }
    }
};
