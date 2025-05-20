<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceToMobilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mobils', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->nullable()->default(0.00)->comment('Harga mobil');
            // Anda bisa menyesuaikan tipe data, presisi, skala, nullable, default, dan comment sesuai kebutuhan Anda.
            // Contoh tipe data lain:
            // $table->integer('price')->nullable();
            // $table->unsignedBigInteger('price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mobils', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }
}