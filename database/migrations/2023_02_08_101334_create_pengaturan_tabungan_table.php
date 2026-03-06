<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengaturanTabunganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengaturan_tabungan', function (Blueprint $table) {
            $table->bigIncrements('id_pengaturan_tabungan');
            $table->integer('nominal_tabungan_pertama');
            $table->integer('minimum_pengambilan');
            $table->integer('minimum_saldo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengaturan_tabungan');
    }
}
