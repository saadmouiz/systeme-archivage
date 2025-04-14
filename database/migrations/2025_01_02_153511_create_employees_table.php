<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('employees', function (Blueprint $table) {
        $table->id();
        $table->string('nom');
        $table->string('prenom');
        $table->string('photo')->nullable();
        $table->string('fonction');
        $table->enum('type_contrat', ['CDI', 'CDD', 'Stage', 'Autre'])->default('CDI');
        $table->boolean('actif')->default(true);
        $table->date('date_embauche')->nullable();
        $table->date('date_fin_contrat')->nullable();
        $table->text('notes')->nullable();
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};