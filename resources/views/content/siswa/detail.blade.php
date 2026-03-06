<div class="page-content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Detail Data Nasabah</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td>No Rekening</td>
                                    <td> <b>: </b>{{$data->no_rekening}}</td>
                                </tr>
                                <tr>
                                    <td>Nama </td>
                                    <td> <b>: </b>{{$data->nama_siswa}}</td>
                                </tr>
                                <tr>
                                    <td>Kelas</td>
                                    <td> <b>: </b>{{$data->nama_kelas}}</td>
                                </tr>
                                <tr>
                                    <td>Jenis Kelamin</td>
                                    <td> <b>: </b>{{$data->jenis_kelamin == 'P' ? 'Perempuan' : 'Laki-Laki'}}</td>
                                </tr>
                                <tr>
                                    <td>Nama Ibu</td>
                                    <td> <b>: </b>{{$data->nama_ibu}}</td>
                                </tr>
                                <tr>
                                    <td>Tempat Lahir</td>
                                    <td> <b>: </b>{{$data->tempat_lahir}}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Lahir</td>
                                    <td> <b>: </b>{{$data->tanggal_lahir}}</td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td> <b>: </b>{{$data->alamat}}</td>
                                </tr>
                                <tr>
                                    <td>Provinsi</td>
                                    <td> <b>: </b>{{$data->mst_provinsi->name}}</td>
                                </tr>
                                <tr>
                                    <td>Kabupaten</td>
                                    <td> <b>: </b>{{$data->mst_kabupaten->name}}</td>
                                </tr>
                                <tr>
                                    <td>Kecamatan</td>
                                    <td> <b>: </b>{{$data->mst_kecamatan->name}}</td>
                                </tr>
                                <tr>
                                    <td>Desa</td>
                                    <td> <b>: </b>{{$data->mst_desa->name}}</td>
                                </tr>
                                <tr>
                                    <td>Alamat Surat Menyurat</td>
                                    <td> <b>: </b>{{$data->alamat_surat}}</td>
                                </tr>
                                <tr>
                                    <td>Kode Pos</td>
                                    <td> <b>: </b>{{$data->kode_pos}}</td>
                                </tr>
                                <tr>
                                    <td>Jenis Telepon</td>
                                    <td> <b>: </b>{{$data->jenis_telepon}}</td>
                                </tr>
                                <tr>
                                    <td>No Telepon</td>
                                    <td> <b>: </b>{{$data->no_telepon}}</td>
                                </tr>
                                <tr>
                                    <td>Jenis Tanda Pengenal</td>
                                    <td> <b>: </b>{{$data->jenis_tanda_pengenal}}</td>
                                </tr>
                                <tr>
                                    <td>Nomor Tanda Pengenal</td>
                                    <td> <b>: </b>{{$data->nomor_tanda_pengenal}}</td>
                                </tr>
                                <tr>
                                    <td>Jenis Rekening</td>
                                    <td> <b>: </b>{{$data->jenis_rekening}}</td>
                                </tr>
                                <tr>
                                    <td>NPWP</td>
                                    <td> <b>: </b>{{$data->npwp}}</td>
                                </tr>
                                <tr>
                                    <td>NO NPWP</td>
                                    <td> <b>: </b>{{$data->no_npwp}}</td>
                                </tr>
                                <tr>
                                    <td>Penyampaian r/k</td>
                                    <td> <b>: </b>{{$data->penyampaian_r_k}}</td>
                                </tr>
                                <tr>
                                    <td>Penerbitan r/k</td>
                                    <td> <b>: </b>{{$data->penerbitan_r_k}}</td>
                                </tr>
                                <tr>
                                    <td>Referensi</td>
                                    <td> <b>: </b>{{$data->referensi}}</td>
                                </tr>
                                <tr>
                                    <td>Pekerjaan</td>
                                    <td> <b>: </b>{{$data->pekerjaan}}</td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td> <b>: </b>{{$data->status}}</td>
                                </tr>
                                <tr>
                                    <td>Pendidikan Terakhir</td>
                                    <td> <b>: </b>{{$data->pendidikan_terakhir}}</td>
                                </tr>
                                <tr>
                                    <td>Penghasilan Per Bulan</td>
                                    <td> <b>: </b>Rp. {{$data->penghasilan_per_bulan}}</td>
                                </tr>
                                <tr>
                                    <td>Saldo</td>
                                    <td> <b>: </b>Rp. {{number_format($data->saldo,0,',','.')}}</td>
                                </tr>
                                {{-- <tr>
                                    <td>Jenis Usaha</td>
                                    <td> <b>: </b>{{$data->jenis_usaha}}</td>
                                </tr>
                                <tr>
                                    <td>Akte Pendirian Usaha</td>
                                    <td> <b>: </b>{{$data->akte_pendirian_usaha}}</td>
                                </tr>
                                <tr>
                                    <td>NO SIUP</td>
                                    <td> <b>: </b>{{$data->no_siup}}</td>
                                </tr>
                                <tr>
                                    <td>Nominal Setoran</td>
                                    <td> <b>: </b>Rp. {{number_format($data->nominal_setoran,0,',','.')}}</td>
                                </tr>
                                <tr>
                                    <td>Mata Uang</td>
                                    <td> <b>: </b>{{$data->mata_uang}}</td>
                                </tr>
                                <tr>
                                    <td>Jangka Waktu</td>
                                    <td> <b>: </b>{{$data->jangka_waktu}}</td>
                                </tr>
                                <tr>
                                    <td>Ambil Tunai</td>
                                    <td> <b>: </b>{{$data->ambil_tunai}}</td>
                                </tr>
                                <tr>
                                    <td>Dibukukan Pada Giro</td>
                                    <td> <b>: </b>{{$data->dibukukan_pada_giro}}</td>
                                    {{-- <td>No Rekening</td>
                                    <td> <b>: </b>{{$data->norek_dibukukan_giro}}</td> 
                                </tr>
                                <tr>
                                    <td>Dibayar Pada Bank</td>
                                    <td> <b>: </b>{{$data->dibayar_pada_bank}}</td>
                                </tr>
                                <tr>
                                    <td>Diperpanjang Otomatis</td>
                                    <td> <b>: </b>{{$data->perpanjang_otomatis}}</td>
                                </tr> --}}
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-secondary btnKembali">KEMBALI</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.btnKembali').click(()=>{
		$('.other-page').fadeOut(function(){
			hideForm()
		})
	})
</script>