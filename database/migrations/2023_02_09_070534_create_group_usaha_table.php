<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupUsahaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_usaha', function (Blueprint $table) {
            $table->bigIncrements('id_group_usaha');
            $table->integer('siswa_id');
            $table->string('nama_perusahaan');
            $table->string('hubungan_usaha');
            $table->string('jenis_usaha');
            $table->string('alamat_perusahaan');
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
        Schema::dropIfExists('group_usaha');
    }
}
