<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kredit;

class KreditController extends Controller
{
    function __construct()
	{
		$this->title = 'Kredit';
	}

    public function form(Type $var = null)
    {
        $data['title'] = $this->title;
        return view('content.kredit.form', $data);
    }
    
    public function cari(Request $request){
		$cari = $request->cari;
        if ($request->param == 'norek') {
            $data = Siswa::where('no_rekening', 'LIKE', "%$cari%")->limit(5)->get();
        } else {
            $data = Siswa::where('nama_siswa', 'LIKE', "%$cari%")->limit(5)->get();
        }
        
		return ['data' => $data];
	}

    public function pilih(Request $request)
    {
        $norek = $request->no_rekening;
        $data = Siswa::where('no_rekening', '=', $norek)->first();
        
		return ['data' => $data];
    }
}
