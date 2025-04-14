<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('archive_partenaires', function (Blueprint $table) {
            $table->date('date_de_convention')->nullable()->after('description');
        });
    }

    public function down()
    {
        Schema::table('archive_partenaires', function (Blueprint $table) {
            $table->dropColumn('date_de_convention');
        });
    }
};