<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Transaksi;
use App\Models\PengaturanTabungan;
use Auth, DB;

class TransaksiController extends Controller
{
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            if (isset($request->akses)) {#Via akses cepat
                if ($request->has('norek_kredit')) {
                    $norek = $request->norek_kredit;
                    $sandi = "01";
                } else {
                    $norek = $request->norek_debet;
                    $sandi = "02";
                }
                // GET DATA SISWA
                $getData = Siswa::where('no_rekening', $norek)->first();
                $ssi = !empty($getData->saldo) ? preg_replace("/[^0-9]/", "", $getData->saldo) : 0;
                $jb = preg_replace("/[^0-9]/", "", $request->jumlah_debet);
                $jk = preg_replace("/[^0-9]/", "", $request->jumlah_kredit);

                $data = new Transaksi;
                $data->siswa_id = $getData->id_siswa;
                $data->jumlah_kredit = $request->has('jumlah_kredit') ? $jk : NULL;
                $data->jumlah_debet = $request->has('jumlah_debet') ? $jb : NULL;
                $data->tanggal_transaksi = date('Y-m-d');
                $data->pengesahan_petugas = "Ya";
                if ($request->has('jumlah_kredit')) {
                    $sum_saldo =  $ssi + $jk;
                } else {
                    $sum_saldo = $ssi - $jb;
                }
                $data->sisa_saldo = $sum_saldo;
                $data->sandi = $sandi;
            } else {
                $ssi = preg_replace("/[^0-9]/", "", $request->saldo_saat_ini);
                $jb = preg_replace("/[^0-9]/", "", $request->jumlah_debet);
                $jk = preg_replace("/[^0-9]/", "", $request->jumlah_kredit);

                if ($request->has('id_transaksi')) {
                    $data = Transaksi::where('id_transaksi', $request->id_transaksi)->first();
                } else {
                    $data = new Transaksi;
                }
                // GET DATA SISWA
                if ($request->has('id_transaksi') && $request->has('norek')) {
                    $dtSiswa = Siswa::where('no_rekening', $request->norek)->first();
                    $data->siswa_id = $dtSiswa->id_siswa;
                } else {
                    $data->siswa_id = $request->id;
                }

                if ($request->has('jumlah_kredit')) {
                    $sum_saldo =  $ssi + $jk;
                } else {
                    $sum_saldo = $ssi - $jb;
                }
                $data->sisa_saldo = $sum_saldo;
                $data->jumlah_kredit = $request->has('jumlah_kredit') ? $jk : NULL;
                $data->jumlah_debet = $request->has('jumlah_debet') ? $jb : NULL;
                $data->tanggal_transaksi = date('Y-m-d',strtotime($request->tgl_transaksi));
                $data->pengesahan_petugas = !empty($request->pengesahan_petugas) ? 'Ya' : null;
                $data->sandi = $request->sandi;
            }

            $data->nama_petugas = Auth::User()->name;
            $data->save();

            if ($data) {
                // START UPDATE SALDO SISWA
                if ($request->has('akses')) {
                    $data2 = Siswa::where('no_rekening', $norek)->first();
                } else {
                    $data2 = Siswa::where('id_siswa', $request->id)->first();
                }
                if ($request->has('jumlah_kredit')) {
                    $hitungSaldo = (int)$data2->saldo + $jk;
                } else {
                    $hitungSaldo = (int)$data2->saldo - $jb;
                }
                $data2->saldo = $hitungSaldo;
                $data2->save();
                DB::commit();
                if($data2){
                    return ['status' => 'success', 'code' => 200, 'message' => 'Data Berhasil Disimpan'];
                } else {
                    return ['status' => 'error', 'code' => 201, 'message' => 'Data Gagal Disimpan'];
                    DB::rollback();
                }
                // END UPDATE SALDO SISWA
            } else {
                return ['error' => 'success', 'code' => 401, 'message' => 'Data Gagal Disimpan'];
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
