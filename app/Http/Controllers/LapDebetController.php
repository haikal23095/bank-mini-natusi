<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Transaksi;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Facades\Excel;
use DataTables, Validator, DB, Auth;

class LapDebetController extends Controller
{
    function __construct()
	{
		$this->title = 'Laporan Debet';
	}

    public function main(Request $request)
    {
        if(request()->ajax()){
            $startDate = $request->startDate;
			$endDate = $request->endDate;
            $filter = $request->filter;
			$filterBy = $request->filterBy;

			if (!empty($filterBy) && !empty($filter) && !empty($startDate) && !empty($endDate)) {
				if ($filterBy == 'nama_siswa') {
					$data = Transaksi::join('siswa as s', 's.id_siswa', 'transaksi.siswa_id')
						->where('jumlah_debet', '!=', null)
						->where('nama_siswa', 'LIKE', "%$filter%")
						->whereBetween('tanggal_transaksi', [$startDate, $endDate])
						->orderBy('transaksi.created_at','DESC')
						->get();
				} else {
					$data = Transaksi::join('siswa as s', 's.id_siswa', 'transaksi.siswa_id')
						->where('jumlah_debet', '!=', null)
						->where('nama_kelas', 'LIKE', "%$filter%")
						->whereBetween('tanggal_transaksi', [$startDate, $endDate])
						->orderBy('transaksi.created_at','DESC')
						->get();
				}
			} else {
				$data = Transaksi::join('siswa as s', 's.id_siswa', 'transaksi.siswa_id')
					->where('jumlah_debet', '!=', null)
					->orderBy('transaksi.created_at','DESC')
					->get();
			}
			
            $tDebet = Transaksi::where('jumlah_debet', '!=', null)->sum('jumlah_debet');

			return DataTables::of($data)
				->addIndexColumn()
                ->addColumn('transaksi', function($row){
					if (!empty($row->jumlah_debet)) {
                        $transaksi = "DEBET";
                    } else {
                        $transaksi = "KREDIT";
                    }
                    return $transaksi;
				})
				->addColumn('actions', function($row){
				// 	$txt = "
    //                   <button class='btn btn-sm btn-primary' title='Edit' onclick='editData(`$row->id_transaksi`)'><i class='bx bxs-file'></i></button>
				// 	  <button class='btn btn-sm btn-danger' title='Delete' onclick='deleteData(`$row->id_transaksi`)'><i class='bx bxs-trash'></i></button>
				// 	";
				    $txt = "<button class='btn btn-sm btn-danger' title='Edit'>Tidak Dapat Mengedit / Menghapus Transaksi</i></button>";
					return $txt;
				})
                ->addColumn('format', function($row){
					return $format = "Rp.".number_format($row->jumlah_debet,0,',','.');
				})
                ->with('tDebet', $tDebet)
				->rawColumns(['actions'])
				->toJson();
		}

        $data['title'] = $this->title;
        return view('content.laporan.main-debet', $data);
    }

	public function edit(Request $request)
	{
		// return $request->all();
		$data['title'] = "Edit ".$this->title;
        $data['data'] = Transaksi::join('siswa as s', 's.id_siswa', 'transaksi.siswa_id')->where('id_transaksi', $request->id)->first();

        // return $data;
        $content = view('content.laporan.form-debet', $data)->render();
		return ['status' => 'success', 'content' => $content, 'data' => $data];
	}

	public function delete(Request $request)
	{
		// DELETE TRANSAKSI
		$delTransaksi = Transaksi::where('id_transaksi', $request->id)->first();
		$delTransaksi->delete();
		// UPDATE SALDO
		$updSaldo = Siswa::where('id_siswa', $delTransaksi->siswa_id)->first();
		$sumSaldo = $updSaldo->saldo + $delTransaksi->jumlah_debet; // Jumlah saldo saat ini (+) Jumlah Debet
		$updSaldo->saldo = $sumSaldo;
		$updSaldo->save();

		if ($delTransaksi) {
			$data = ['type' => 'success', 'status' => 'success', 'code' => '200'];
        } else {
            $data = ['type' => 'success', 'status' => 'success', 'code' => '201'];
        }
	
		return $data;
	}

	public function export(Request $request)
	{
		$date = date('Y-m-d');
		$data['date'] = $date;
		$data['judul'] = 'LAPORAN DEBET';

		$startDate = $request->startDate;
		$endDate = $request->endDate;
		$filter = $request->filter;
		$filterBy = $request->filterBy;
		$this->query($filterBy, $filter,$startDate, $endDate);
		$data['data'] = $this->data;
		if (count($this->data) > 0) {
			$content = view('content.laporan.excel-debet', $data)->render();
			return ['status' => 'success', 'content' => $content];
		} else {
			return ['status' => 'error', 'message' => 'Data tidak ditemukan pada tanggal tersebut!'];
		}
	}

	public function query($filterBy, $filter, $startDate, $endDate)
	{
		// Pencarian between two date
		if(!empty($startDate) && !empty($endDate) && $filterBy == 'nama_siswa' && !empty($filter)) {
			$data = Transaksi::join('siswa as s', 's.id_siswa', 'transaksi.siswa_id')
			->where('jumlah_debet', '!=', null)->where('nama_siswa','LIKE', "%$filter%")
			->whereBetween('tanggal_transaksi', [$startDate, $endDate])->get();

		// Pencarian berdasarkan nama kelas dan between two date
		} else if(!empty($startDate) && !empty($endDate) && $filterBy == 'nama_kelas' && !empty($filter)){
			$data = Transaksi::join('siswa as s', 's.id_siswa', 'transaksi.siswa_id')
			->where('jumlah_debet', '!=', null)->where('nama_kelas','LIKE', "%$filter%")
			->whereBetween('tanggal_transaksi', [$startDate, $endDate])->get();
		}
		$this->data = $data;
	}
}
