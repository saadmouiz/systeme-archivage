<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courrier_sortants', function (Blueprint $table) {
            $table->id();
            $table->string('numero_sortant')->unique();
            $table->date('date_sortant');
            $table->string('destinataire');
            $table->text('sujet');
            $table->string('fichier')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('courrier_sortants');
    }
};

