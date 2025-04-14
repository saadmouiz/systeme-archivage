<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('evenement_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evenement_id')
                  ->constrained('evenements')
                  ->onDelete('cascade');
            $table->string('type_media');
            $table->string('chemin_fichier');
            $table->string('titre')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('evenement_media');
    }
};