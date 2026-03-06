<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengaturanTabungan;
use Validator;

class PengaturanController extends Controller
{
    function __construct()
	{
		$this->title = 'Pengaturan';
	}

    public function form()
    {
        $data['title'] = $this->title;
        $pengaturan = PengaturanTabungan::get();
        if (count($pengaturan) > 0) {
            $data['data'] = PengaturanTabungan::where('id_pengaturan_tabungan', 1)->first();
        } else {
            $data['data'] = '';
        }
        
        return view('content.pengaturan.form', $data);
    }

    public function store(Request $request) {
        $id = $request->id;
        $rules = array(
            'minimum_pengambilan' => 'required',
            'nominal_tabungan_pertama' => 'required',
        );
        $messages = array(
            'required'  => 'Kolom Harus Diisi',
        );
        $valid = Validator::make($request->all(), $rules,$messages);
        if($valid->fails()) {
            return ['status' => 'error', 'code' => 400, 'message' => $valid->messages()];
        } else {
            if(!empty($id)) {
                // return 'atas';
                $data = PengaturanTabungan::where('id_pengaturan_tabungan', $id)->first();
            } else {
                // return 'bawah';
                $data = new PengaturanTabungan;
            }
            
            $ms = !empty($request->minimum_saldo) ? preg_replace("/[^0-9]/", "", $request->minimum_saldo) : null;
            $data->nominal_tabungan_pertama = preg_replace("/[^0-9]/", "", $request->nominal_tabungan_pertama);
            $data->minimum_pengambilan = preg_replace("/[^0-9]/", "", $request->minimum_pengambilan);
            $data->minimum_saldo = $ms;
            $data->save();

            if ($data) {
                $pesan = ['code' => 200, 'type' => 'succes', 'status' => 'success', 'message' => 'Data Berhasil Di simpan'];
            } else {
                $pesan = ['code' => 201, 'type' => 'error', 'status' => 'error', 'message' => 'Data Gagal Di simpan'];
            }
            
            return $pesan;
        }
    }
}
