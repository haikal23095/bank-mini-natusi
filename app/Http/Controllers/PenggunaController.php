<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DataTables, Validator, DB, Auth, Hash;

class PenggunaController extends Controller
{
    function __construct()
	{
		$this->title = 'Data Pengguna';
	}

    public function main(Request $request)
    {
        if(request()->ajax()){

			$data = User::orderBy('id','ASC')->get();
			
			return DataTables::of($data)
				->addIndexColumn()
				->addColumn('actions', function($row){
					$txt = "
                      <button class='btn btn-sm btn-primary' title='Edit' onclick='formAdd(`$row->id`)'><i class='fadeIn animated bx bxs-file' aria-hidden='true'></i></button>
                      <button class='btn btn-sm btn-danger' title='Delete' onclick='hapus(`$row->id`)'><i class='fadeIn animated bx bxs-trash' aria-hidden='true'></i></button>
					";
					return $txt;
				})
				->rawColumns(['actions'])
				->toJson();
		}

        $data['title'] = $this->title;
        return view('content.pengguna.main', $data);
    }

    public function form(Request $request)
    {
        $data['title'] = "Tambah ".$this->title;
        if (empty($request->id)) {
            $data['user'] = '';
		}else{
			$data['user'] = User::where('id',$request->id)->first();
		}

        $content = view('content.pengguna.form', $data)->render();
		return ['status' => 'success', 'content' => $content, 'data' => $data];
    }

    public function store(Request $request)
    {
        // return $request->all();
        $nama = $request->nama;
        $level = $request->level;
        $username = $request->username;
        $email = $request->email;
        $password = $request->password;
    
        if(isset($request->id)){
            $user = User::where('id', $request->id)->first();
            if($password!=''){
                $user->password = Hash::make($password);
            }
        }else{
            $user = new User;
            $user->password = Hash::make($password);
        }
        $user->username = $username;
        $user->email = $email;
        $user->name = $nama;
        $user->lihat_password = $password;
        $user->level = $level;
        $user->save();

        if ($user) {
            $pesan = ['code' => 200, 'type' => 'succes', 'status' => 'success', 'message' => 'Data Berhasil Di simpan'];
        } else {
            $pesan = ['code' => 201, 'type' => 'error', 'status' => 'error', 'message' => 'Data Gagal Di simpan'];
        }
            
        return $pesan;
    }
    public function delete(Request $request)
    {
        $delete = User::where('id', $request->id)->first();
        $delete->delete();

        if ($delete) {
            $data = ['type' => 'success', 'status' => 'success', 'code' => '200'];
        } else {
            $data = ['type' => 'success', 'status' => 'success', 'code' => '201'];
        }
        
        return $data;
    }
}