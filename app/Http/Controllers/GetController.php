<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Kabupaten;
use App\Models\Provinsi;
use Auth, Redirect, DB;

class GetController extends Controller
{
    function getKabupaten(Request $request){
        $KD_PROVINSI = $request->id;
        $kabupaten = Kabupaten::where('provinsi_id', $KD_PROVINSI)->get();
    
        if(count($kabupaten)!=0){
            $return = [
                'status'=>'success',
                'message'=>'Data ditemukan',
                'data'=>$kabupaten,
            ];
        }else{
            $return = [
                'status'=>'error',
                'message'=>'Data tidak ditemukan',
                'data'=>[],
            ];
        }
        return $return;
    }

    function getKecamatan(Request $request){
        $KD_KABUPATEN = $request->id;
        $kecamatan = Kecamatan::where('kabupaten_id',$KD_KABUPATEN)->get();

        if(count($kecamatan)!=0){
            $return = [
                'status'=>'success',
                'message'=>'Data ditemukan',
                'data'=>$kecamatan,
            ];
        }else{
            $return = [
                'status'=>'error',
                'message'=>'Data tidak ditemukan',
                'data'=>[],
            ];
        }
        return $return;
    }

    function getDesa(Request $request){
        $KD_KECAMATAN = $request->id;
        $desa = Desa::where('kecamatan_id', $KD_KECAMATAN)->get();

        if(count($desa)!=0){
            $return = [
                'status'=>'success',
                'message'=>'Data ditemukan',
                'data'=>$desa,
            ];
        }else{
            $return = [
                'status'=>'error',
                'message'=>'Data tidak ditemukan',
                'data'=>[],
            ];
        }
        return $return;
    }
}
