<?php  
  
use Illuminate\Database\Migrations\Migration;  
use Illuminate\Database\Schema\Blueprint;  
use Illuminate\Support\Facades\Schema;  
  
return new class extends Migration  
{  
    public function up()  
    {  
        // SQLite ne supporte pas la suppression de cl‚s ‚trangŠres  
        // On ajoute simplement la nouvelle contrainte  
        Schema::table('beneficiaires', function (Blueprint $table) {  
            $table- 
                  - 
                  - 
                  - null');  
        });  
    }  
  
    public function down()  
    {  
        // SQLite ne supporte pas la suppression de cl‚s ‚trangŠres  
    }  
}; 
