<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobilsTable extends Migration
{
    public function up()
    {
        Schema::create('mobils', function (Blueprint $table) {
            $table->id();
            $table->string('plat_number')->unique();
            $table->enum('category', ['MPV', 'SUV', 'HATCHBACK', 'CROSSOVER', 'SEDAN', 'COUPE', 'CABRIOLET', 'ROADSTER']);
            $table->string('merk');
            $table->string('model');
            $table->year('year');
            $table->enum('transmission', ['AT', 'MT']);
            $table->unsignedInteger('seat');
            $table->text('description')->nullable();
            $table->enum('status', ['Available', 'Disewa', 'Out Of Order'])->default('Available');
            $table->string('picture_upload')->nullable(); // menyimpan nama file atau path gambar
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mobils');
    }
}
