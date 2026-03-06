<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->bigIncrements('id_transaksi');
            $table->integer('siswa_id');
            $table->integer('jumlah_debet')->nullable();
            $table->integer('jumlah_kredit')->nullable();
            $table->date('tanggal_transaksi');
            $table->string('sandi');
            $table->string('pengesahan_petugas')->nullable();
            $table->string('nama_petugas')->nullable();
            $table->integer('sisa_saldo');
            $table->string('sudah_di_print')->nullable();
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
        Schema::dropIfExists('transaksi');
    }
}
