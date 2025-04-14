<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['admin1', 'admin2', 'superadmin'])->default('admin1');
            $table->timestamps();
        });
        
        
    }

    public function down()
    {
        Schema::dropIfExists('admins');
    }
};