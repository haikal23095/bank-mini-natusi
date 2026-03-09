<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Transaksi;
use DataTables, Validator, DB, Auth;

class CetakController extends Controller
{
	public function cetakRekKoran(Request $request)
	{
		$return = $this->cetak_rek_koran($request);
		return $return;
	}

	public function cetak_rek_koran(Request $request)
	{
		$id_transaksi = $request->id;
		$cetak = Transaksi::where('id_transaksi', $id_transaksi)->first();

		if (!$cetak) {
			return abort(404, "Data transaksi tidak ditemukan");
		}

		$cetak->sudah_di_print = 'Ya';
		$cetak->save();

		// Gunakan select untuk efisiensi
		$allData = Transaksi::leftJoin('siswa as s', 's.id_siswa', 'transaksi.siswa_id')
			->select('transaksi.*', 's.nama_siswa', 's.no_rekening')
			->where('transaksi.siswa_id', $cetak->siswa_id)
			->where('transaksi.id_transaksi', '<=', $id_transaksi)
			->orderBy('transaksi.id_transaksi', 'ASC')
			->get();

		$dataCount = $allData->count();
		$barisPerHalaman = 38;

		// Tentukan index awal pada halaman terakhir
		// Misal data ke-40, barisPerHalaman 38. Modulus = 2. 
		// Maka kita hanya menampilkan data dari index 38-39 (baris 1 & 2 di halaman baru)
		$halamanKe = ceil($dataCount / $barisPerHalaman);
		$startIndex = ($halamanKe - 1) * $barisPerHalaman;

		$finalData = [];
		foreach ($allData as $key => $val) {
			// Kita hanya memproses data yang ada di halaman aktif saat ini
			if ($key >= $startIndex) {
				$val->tampil = ($val->id_transaksi == $id_transaksi) ? 'ya' : 'tidak';
				$finalData[] = $val;
			}
		}

		$data['data'] = $finalData;
		return view('content.cetak.rek-koran', $data);
	}

	public function cetakDataSiswa(Request $request)
	{
		$return = $this->cetak_data_siswa($request);
		return $return;
	}

	public function cetak_data_siswa(Request $request)
	{
		$data['data'] = Siswa::where('id_siswa', $request->id)->first();
		return view('content.cetak.data-siswa', $data);
	}
}
