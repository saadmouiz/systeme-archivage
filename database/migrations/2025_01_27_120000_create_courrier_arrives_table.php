<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courrier_arrives', function (Blueprint $table) {
            $table->id();
            $table->string('numero_arrive')->unique();
            $table->date('date_arrive');
            $table->string('numero_document')->nullable();
            $table->date('date_document')->nullable();
            $table->string('expediteur');
            $table->boolean('pieces_jointes')->default(false);
            $table->boolean('renvoi')->default(false);
            $table->boolean('signature_recu')->default(false);
            $table->string('fichier')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('courrier_arrives');
    }
};

