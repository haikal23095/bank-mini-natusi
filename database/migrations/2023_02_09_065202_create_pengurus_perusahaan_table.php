<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengurusPerusahaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengurus_perusahaan', function (Blueprint $table) {
            $table->bigIncrements('id_pengurus');
            $table->integer('siswa_id');
            $table->string('nama_pengurus');
            $table->string('jabatan_pengurus');
            $table->string('alamat_pengurus');
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
        Schema::dropIfExists('pengurus_perusahaan');
    }
}
