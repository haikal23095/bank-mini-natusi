<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->bigIncrements('id_siswa');
            $table->string('no_rekening');
            $table->string('nama_siswa');
            $table->string('jenis_kelamin');
            $table->string('nama_kelas');
            $table->string('nama_ibu');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('alamat');
            $table->char('provinsi_id', 2);
            $table->char('kabupaten_id', 4);
            $table->char('kecamatan_id', 6);
            $table->char('desa_id', 10);
            $table->string('alamat_surat')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('jenis_telepon')->nullable();
            $table->string('no_telepon')->nullable();
            $table->string('jenis_tanda_pengenal')->nullable();
            $table->string('nomor_tanda_pengenal')->nullable();
            $table->string('jenis_rekening')->nullable();
            $table->string('npwp')->nullable();
            $table->string('no_npwp')->nullable();
            $table->string('penyampaian_r_k')->nullable();
            $table->string('penerbitan_r_k')->nullable();
            $table->string('referensi')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('status')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('penghasilan_per_bulan')->nullable();
            // $table->string('jenis_usaha');
            // $table->string('akte_pendirian_usaha');
            // $table->string('no_siup');
            // $table->string('nominal_setoran');
            // $table->string('mata_uang');
            // $table->string('jangka_waktu');
            // $table->string('ambil_tunai');
            // $table->string('dibukukan_pada_giro');      
            // $table->string('dibayar_pada_bank');
            // $table->string('no_rekening');
            // $table->string('perpanjang_otomatis');
            $table->integer('saldo')->nullable();
            $table->date('tanggal_registrasi');
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
        Schema::dropIfExists('siswa');
    }
}
