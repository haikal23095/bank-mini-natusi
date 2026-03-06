<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Transaksi;

class DashboardController extends Controller
{
	function __construct()
	{
		$this->title = 'Dashboard';
	}

	public function main()
	{
		$data['title'] = $this->title;
		$data['siswa'] = Siswa::count();
		$data['kredit'] = Transaksi::where('jumlah_kredit', '!=', null)->sum('jumlah_kredit');
		$data['debet'] = Transaksi::where('jumlah_debet', '!=', null)->sum('jumlah_debet');
		$data['saldo'] = Siswa::sum('saldo');
		return view('content.dashboard.main', $data);
	}

	public function cariDebet(Request $request){
		$cari = $request->cari;
        $data = Siswa::where('no_rekening', 'LIKE', "%$cari%")->limit(5)->get();
		return ['data' => $data];
	}

    public function pilihDebet(Request $request)
    {
        $norek = $request->no_rekening;
        $data = Siswa::where('no_rekening', '=', $norek)->first();
		return ['data' => $data];
    }

	public function cariKredit(Request $request){
		$cari = $request->cari;
        $data = Siswa::where('no_rekening', 'LIKE', "%$cari%")->limit(5)->get();
		return ['data' => $data];
	}

    public function pilihKredit(Request $request)
    {
        $norek = $request->no_rekening;
        $data = Siswa::where('no_rekening', '=', $norek)->first();
		return ['data' => $data];
    }
}
