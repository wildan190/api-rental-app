<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPlatNumberNullableInMobils extends Migration
{
    public function up()
    {
        Schema::table('mobils', function (Blueprint $table) {
            $table->string('plat_number')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('mobils', function (Blueprint $table) {
            $table->string('plat_number')->nullable(false)->change();
        });
    }
}
