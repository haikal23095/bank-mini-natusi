<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Debet;
use App\Models\PengaturanTabungan;

class DebetController extends Controller
{
    function __construct()
	{
		$this->title = 'Debet';
	}

    public function form(Type $var = null)
    {
        $data['title'] = $this->title;
        $data['pengaturan'] = PengaturanTabungan::where('id_pengaturan_tabungan', 1)->first();
        return view('content.debet.form', $data);
    }

    public function cari(Request $request){
		$cari = $request->cari;
        $data = Siswa::where('no_rekening', 'LIKE', "%$cari%")->limit(5)->get();
		return ['data' => $data];
	}

    public function pilih(Request $request)
    {
        $norek = $request->no_rekening;
        $data = Siswa::where('no_rekening', '=', $norek)->first();
		return ['data' => $data];
    }
    
    public function store(Request $request)
    {
        $data = new Debet;
        $data->siswa_id = $request->id;
        $data->jumlah_debit = preg_replace("/[^0-9]/", "", $request->jumlah_debet);
        $data->tanggal_transaksi = $request->tgl_transaksi;
        $data->pengesahan_petugas = !empty($request->pengesahan_petugas) ? 'Ya' : null;
        $data->save();

        if ($data) {
            $getSiswa = Siswa::where('id_siswa', $request->id)->first();
            $hitungSaldo = (int)$getSiswa->saldo - $data->jumlah_debit;
            $getSiswa->saldo = $hitungSaldo;
            $getSiswa->save();

            $respon = ['status' => 'success', 'code' => 200, 'message' => 'Data Berhasil Disimpan'];
        } else {
            $respon = ['error' => 'success', 'code' => 401, 'message' => 'Data Gagal Disimpan'];
        }
        
        return $respon;
    }
}
