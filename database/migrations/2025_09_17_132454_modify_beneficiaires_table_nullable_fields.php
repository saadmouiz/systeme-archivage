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
            // Rendre nullable les champs conditionnels
            $table->string('genre')->nullable()->change();
            $table->string('status')->nullable()->change();
            $table->string('ass_eps')->nullable()->change();
            $table->unsignedBigInteger('ecole_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beneficiaires', function (Blueprint $table) {
            // Remettre les contraintes NOT NULL (si nécessaire)
            $table->string('genre')->nullable(false)->change();
            $table->string('status')->nullable(false)->change();
            $table->string('ass_eps')->nullable(false)->change();
            $table->unsignedBigInteger('ecole_id')->nullable(false)->change();
        });
    }
};
