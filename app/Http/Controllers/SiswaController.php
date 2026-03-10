<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provinsi;
use App\Models\Siswa;
use App\Models\Transaksi;
use App\Models\Pengurus;
use App\Models\GroupUsaha;
use DataTables, Validator, DB, Auth, Excel;

class SiswaController extends Controller
{
    function __construct()
    {
        $this->title = 'Data Nasabah (Siswa)';
    }

    public function main(Request $request)
    {
        if (request()->ajax()) {
            // $startDate = $request->startDate;
            // $endDate = $request->endDate;
            $filterBy = $request->filterBy;
            $filter = $request->filter;
            // $data = Siswa::query();
            $data = Siswa::select('id_siswa', 'no_rekening', 'nama_siswa', 'nama_kelas', 'saldo');
            if (!empty($filterBy) && !empty($filter)) {
                $data->where($filterBy, 'LIKE', "%$filter%");
            }
            $data->orderBy('id_siswa', 'ASC');


            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('actions', function ($row) {
                    $txt = "
                      <button class='btn btn-sm btn-info' title='Detail' onclick='detail(`$row->id_siswa`)'><i class='fadeIn animated bx bx-show' aria-hidden='true'></i></button>
                      <button class='btn btn-sm btn-primary' title='Edit' onclick='formAdd(`$row->id_siswa`)'><i class='fadeIn animated bx bxs-file' aria-hidden='true'></i></button>
                      <button class='btn btn-sm btn-danger' title='Delete' onclick='hapus(`$row->id_siswa`)'><i class='fadeIn animated bx bxs-trash' aria-hidden='true'></i></button>
					";
                    return $txt;
                })
                // ->addColumn('registrasi', function($row){
                //     if (!empty($row->registrasi)) {
                //         $reg = $row->tanggal_registrasi;
                //     } else {
                //         $reg = '';
                //     }

                //     return $reg;
                // })
                ->addColumn('format', function ($row) {
                    return $format = "Rp." . number_format($row->saldo, 0, ',', '.');
                })
                ->rawColumns(['actions'])
                ->toJson();
        }

        $data['title'] = $this->title;
        return view('content.siswa.main', $data);
    }

    public function form(Request $request)
    {
        $data['title'] = "Tambah " . $this->title;
        $data['data_provinsi'] = Provinsi::all();
        if (empty($request->id)) {
            $data['siswa'] = '';
            // $data['groupUsaha'] = '';
            // $data['pengurus'] = '';

            // // GENERATE NO. REKENING
            // $selectNoRek = Siswa::select('no_rekening')->orderBy('no_rekening','desc')->first();
            // $num = 0;
            // if(!empty($selectNoRek)){
            //     $num = (int)substr($selectNoRek->no_rekening, 9);
            // }
            // $autoIncNorek = sprintf("%010d",$num+1);
            // $data['noRek'] = $autoIncNorek;
        } else {
            $data['siswa'] = Siswa::where('id_siswa', $request->id)->first();
            // $data['groupUsaha'] = GroupUsaha::where('siswa_id',$request->id)->get();
            // $data['pengurus'] = Pengurus::where('siswa_id',$request->id)->get();
            // $data['noRek'] = '';
        }

        // return $data;
        $content = view('content.siswa.form', $data)->render();
        return ['status' => 'success', 'content' => $content, 'data' => $data];
    }

    public function detail(Request $request)
    {
        $data['title'] = "Detail " . $this->title;
        $data['data'] = Siswa::with(['mst_provinsi', 'mst_kabupaten', 'mst_kecamatan', 'mst_desa'])
            ->where('id_siswa', $request->id)
            ->first();
        $data['transaksi'] = Transaksi::where('siswa_id', $request->id)->get();
        $content = view('content.siswa.detail', $data)->render();
        $return = [
            'status' => 'success',
            'code' => 200,
            'message' => 'Berhasil',
            'content' => $content
        ];
        return response()->json($return);
    }

    public function store(Request $request)
    {
        // $do   = $request->diperpanjang_otomatis;
        // $dpb  = $request->dibayar_pada_bank;
        // $dpg  = $request->dibukukan_pada_giro;
        // $at   = $request->ambil_tunai;
        // $ndpg = $request->norek_dibukukan_pada_giro;
        // $ndpb = $request->norek_dibayar_pada_bank;

        if (!empty($request->id)) {
            $siswa = Siswa::where('id_siswa', $request->id)->first();
        } else {
            $siswa = new Siswa;
        }

        $siswa->no_rekening = $request->no_rekening;
        $siswa->nama_siswa = $request->nama_siswa;
        $siswa->jenis_kelamin = $request->jenis_kelamin;
        $siswa->nama_kelas = $request->nama_kelas;
        $siswa->nama_ibu = $request->nama_ibu;
        $siswa->tempat_lahir = $request->tempat_lahir;
        $siswa->tanggal_lahir = date('Y-m-d', strtotime($request->tgl_lahir));
        $siswa->alamat = $request->alamat;
        $siswa->provinsi_id = $request->provinsi_id;
        $siswa->kabupaten_id = $request->kabupaten_id;
        $siswa->kecamatan_id = $request->kecamatan_id;
        $siswa->desa_id = $request->desa_id;
        $siswa->alamat_surat = $request->alamat_surat_menyurat;
        $siswa->kode_pos = $request->kode_pos;
        $siswa->jenis_telepon = $request->jenis_telepon;
        $siswa->no_telepon = $request->telepon;
        $siswa->jenis_tanda_pengenal = $request->jenis_tanda_pengenal;
        $siswa->nomor_tanda_pengenal = $request->nomor_tanda_pengenal;
        $siswa->jenis_rekening = $request->jenis_rekening;
        $siswa->npwp = $request->npwp;
        $siswa->no_npwp = $request->no_npwp;
        $siswa->penyampaian_r_k = $request->penyampaian_r_k;
        $siswa->penerbitan_r_k = $request->penerbitan_r_k;
        $siswa->referensi = $request->referensi;
        $siswa->pekerjaan = $request->pekerjaan;
        $siswa->status = $request->status;
        $siswa->pendidikan_terakhir = $request->pendidikan_terakhir;
        $siswa->penghasilan_per_bulan = $request->penghasilan_per_bulan;
        if (!empty($request->id)) {
        } else {
            $siswa->saldo = 0; // Default 0
        }

        $siswa->tanggal_registrasi = date('Y-m-d'); // Default Today
        // $siswa->jenis_usaha = $request->jenis_usaha_aktivitas;
        // $siswa->akte_pendirian_usaha = $request->akte_pendiri_usaha;
        // $siswa->no_siup = $request->no_siup;
        // $siswa->nominal_setoran = preg_replace("/[^0-9]/", "", $request->nominal_setoran);
        // $siswa->mata_uang = $request->mata_uang;
        // $siswa->jangka_waktu = $request->jangka_waktu;
        // $siswa->ambil_tunai = !empty($at) ? 'Ya' : null;
        // $siswa->dibukukan_pada_giro = !empty($dpg) ? 'Ya' : null;
        // if (!empty($dpg)) {
        //     $siswa->norek_dibukukan_giro = !empty($ndpg) ? $ndpg : null;
        // }
        // $siswa->dibayar_pada_bank = !empty($dpb) ? 'Ya' : null;
        // if (!empty($dpb)) {
        //     $siswa->norek_dibayar_bank = !empty($ndpb) ? $ndpb : null;
        // }
        // $siswa->saldo = 0; // Default 0
        // $siswa->perpanjang_otomatis = !empty($do) ? 'Ya' : null;
        $siswa->save();

        if ($siswa) {
            // if ($request->has('id_pengurus')) {
            //     $pengurus = new Pengurus;

            //     $i = 0;
            //     foreach ($request->id_pengurus as $key => $val) {
            //         $pengurus->siswa_id         = $siswa->id_siswa;
            //         $pengurus->nama_pengurus    = $request->nama_pengurus[$i];
            //         $pengurus->jabatan_pengurus = $request->jabatan_pengurus[$i];
            //         $pengurus->alamat_pengurus  = $request->alamat_pengurus[$i];
            //         $pengurus->save();
            //         $i++;
            //     }
            // }

            // if ($request->has('id_group_usaha')) {
            //     $groupUsaha = new GroupUsaha;

            //     $x = 0;
            //     foreach ($request->id_group_usaha as $key => $val) {
            //         $groupUsaha->siswa_id           = $siswa->id_siswa;
            //         $groupUsaha->nama_perusahaan    = $request->nama_perusahaan[$x];
            //         $groupUsaha->hubungan_usaha     = $request->hubungan_usaha[$x];
            //         $groupUsaha->jenis_usaha        = $request->jenis_usaha[$x];
            //         $groupUsaha->alamat_perusahaan  = $request->alamat_perusahaan[$x];
            //         $groupUsaha->save();
            //         $x++;
            //     }
            // }

            $pesan = ['code' => 200, 'type' => 'succes', 'status' => 'success', 'message' => 'Data Berhasil Di simpan'];
        } else {
            $pesan = ['code' => 201, 'type' => 'error', 'status' => 'error', 'message' => 'Data Gagal Di simpan'];
        }

        return $pesan;
    }

    public function delete(Request $request)
    {
        $delSiswa = Siswa::where('id_siswa', $request->id)->first();
        $delSiswa->delete();

        if ($delSiswa) {
            $delTransaksi = Transaksi::where('siswa_id', $request->id)->first();
            if (!empty($delTransaksi)) {
                $delTransaksi->delete();
            }
            $data = ['type' => 'success', 'status' => 'success', 'code' => '200'];
        } else {
            $data = ['type' => 'success', 'status' => 'success', 'code' => '201'];
        }

        return $data;
    }
}
