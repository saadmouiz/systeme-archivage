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
        Schema::create('administratifs', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // Statuts, Rapports, etc.
            $table->string('titre'); // Titre du document
            $table->text('description')->nullable(); // Description du document
            $table->string('fichier'); // Chemin du fichier
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administratifs');
    }
};
