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
		$cetak = Transaksi::where('id_transaksi', $request->id)->first();
		$cetak->sudah_di_print = 'Ya';
		$cetak->save();
		
		// $data['data'] = Transaksi::join('siswa as s', 's.id_siswa', 'transaksi.siswa_id')->where('id_transaksi', $request->id)->first();
		$data['data'] = Transaksi::leftjoin('siswa as s', 's.id_siswa', 'transaksi.siswa_id')
			->where('siswa_id', $cetak->siswa_id)
			->where('id_transaksi','<=',$request->id)->get();

		$arr = [];
		$dataCount = count($data['data']);
		$unsetKey = 38;
		$modulus = $dataCount % 38;
		$getHasilPengurangan = $dataCount - $modulus;
		$totalBagi = $getHasilPengurangan!= 0 ? ($getHasilPengurangan / $unsetKey) : 0;
		// return $totalBagi > 1 ? 'benar' : 'salah';
		$totalIndex = $modulus==0 ? $getHasilPengurangan : $modulus;
		if($modulus!=0){
			if($getHasilPengurangan>1){
				// $totalIndex = ($getHasilPengurangan * $totalBagi);
				$totalIndex = ($unsetKey * $totalBagi);
			}
		}
// return $data['data'];
// return [$dataCount,$modulus,$totalIndex,$getHasilPengurangan,$totalBagi];
// [79,3,152,76,2]
		if($dataCount > 0){
			foreach ($data['data'] as $key => $val) {
				$val->tampil = 'ya';
				if($val->id_transaksi != $request->id){
					$val->tampil = 'tidak';
				}
				// if($dataCount > 38 && $key <38){
				if($dataCount > 38 && $key < $totalIndex){
				// if($dataCount > 38 && $key < 76){
				// if($dataCount > 38 && $modulus < 38 && $totalBagi >= 1){
					// array_push($arr,[$modulus,$totalBagi]);
					unset($data['data'][$key]);
				}else{
					$arr[] = $val;
				}
			}
		}
        $data['data'] = $arr;
		// return $arr;
		// return $dt = array_values($data['data']);
		// return $data['data'];
		return view('content.cetak.rek-koran',$data);
	}

	public function cetakDataSiswa(Request $request)
	{
		$return = $this->cetak_data_siswa($request);
		return $return;
	}

	public function cetak_data_siswa(Request $request)
	{
		$data['data'] = Siswa::where('id_siswa', $request->id)->first();
		return view('content.cetak.data-siswa',$data);
	}
}
