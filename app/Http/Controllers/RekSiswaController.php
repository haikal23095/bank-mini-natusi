<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Transaksi;
use DataTables, Validator, DB, Auth;

class RekSiswaController extends Controller
{
    function __construct()
	{
		$this->title = 'Rek. Koran';
	}

    public function main(Request $request)
    {
        if(request()->ajax()){
            $startDate = $request->startDate;
			$endDate = $request->endDate;
            $filter = $request->filter;

            $data = Transaksi::join('siswa as s', 's.id_siswa', 'transaksi.siswa_id')
            ->where('nama_siswa', 'LIKE', "%$filter%")
            ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->orderBy('transaksi.id_transaksi','ASC')
            ->get();

            $nama = '';
            $rekSiswa = '';
            $id_siswa = '';
            foreach ($data as $key => $v) {
                $nama = $v->nama_siswa;
                $rekSiswa = $v->no_rekening;
                $id_siswa = $v->id_siswa;
            }
			return DataTables::of($data)
				->addIndexColumn()
                ->addColumn('actions', function($row){
					if ($row->sudah_di_print == 'Ya') {
                        $txt = "
                        <button class='btn btn-sm btn-secondary' title='Print' onclick='cetak(`$row->id_transaksi`)'><i class='bx bxs-printer'></i></button>
                        ";
                    } else {
                        $txt = "
                        <button class='btn btn-sm btn-warning' title='Print' onclick='cetak(`$row->id_transaksi`)'><i class='bx bxs-printer'></i></button>
                        ";
                    }
                    
					return $txt;
				})
                ->addColumn('debet', function($row){
                    if (!empty($row->jumlah_debet)) {
                        $d = "Rp.".number_format($row->jumlah_debet,0,',','.');
                    } else {
                        $d = '';
                    }
                    
					return $debet = $d;
				})
                ->addColumn('kredit', function($row){
					if (!empty($row->jumlah_kredit)) {
                        $k = "Rp.".number_format($row->jumlah_kredit,0,',','.');
                    } else {
                        $k = '';
                    }
                    return $kredit = $k;
				})
                ->addColumn('saldo', function($row){
					return $saldo = "Rp.".number_format($row->sisa_saldo,0,',','.');
				})
				->rawColumns(['actions'])
                ->with('nama', $nama)
                ->with('rekening', $rekSiswa)
                ->with('id_siswa', $id_siswa)
				->toJson();
		}

        $data['title'] = $this->title;
        return view('content.reksiswa.main', $data);
    }
}
