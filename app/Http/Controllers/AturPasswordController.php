<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator, Hash;

class AturPasswordController extends Controller
{
    function __construct()
	{
		$this->title = 'Atur Password';
	}

    public function form()
    {
        $data['title'] = $this->title;
        return view('content.atur-password.form', $data);
    }

    public function store(Request $request) {
        // return $request->all();
        $rules = array(
            'password_baru_ulang' => 'required',
            'password_baru' => 'required',
            'password_sekarang' => 'required',
        );
        $messages = array(
            'required'  => 'Kolom Harus Diisi',
        );
        $valid = Validator::make($request->all(), $rules,$messages);
        if($valid->fails()) {
            return ['status' => 'error', 'code' => 400, 'message' => $valid->messages()];
        } else {
            $data = User::where('id', $request->id)->first();
            $data->password = Hash::make($request->password_baru);
            $data->lihat_password = $request->password_baru;
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
