<?php
    $KD_PROVINSI          = '';
    $KD_KABUPATEN      	= '';
    $KD_KECAMATAN     	= '';
    $KD_KELURAHAN         = '';
    $KELURAHAN            = '';
    $KECAMATAN         	= '';
    $KABUPATEN         	= '';


    if (!empty($siswa)) {
        $KD_PROVINSI         = $siswa->provinsi_id;  	
        $KD_KABUPATEN     	 = $siswa->kabupaten_id;
        $KD_KECAMATAN     	 = $siswa->kecamatan_id;
        $KD_KELURAHAN     	 = $siswa->desa_id;
        $KELURAHAN           = !empty($siswa->mst_desa) ? $siswa->mst_desa->name : '';
        $KECAMATAN           = !empty($siswa->mst_kecamatan) ? $siswa->mst_kecamatan->name : '';
        $KABUPATEN         	 = !empty($siswa->mst_kabupaten) ? $siswa->mst_kabupaten->name : '';
    }
?>
@php
function rupiah($angka){
    $hasil_rupiah = "Rp. " . number_format((int)$angka);
    $hasil_rupiah = str_replace(',', '.', $hasil_rupiah);
    return $hasil_rupiah;
}
@endphp
<style>
    #simpan_nasabah{
        background: #829460;
        color: #fff;
    }
    #errKtp {
        margin-top:4px;
		background: #ff5757;
		color:#fff;
		padding:4px;
		display:none;
		width: 250p
    }
</style>
<div class="page-content">
    <div class="row">
        <div class="col-md-12">
            <form id="form-data" class="card">
                <div class="card-header">
                    <h5>Tambah Nasabah Baru</h5>
                </div>
                <div class="card-body">
                    <input type="hidden" name="id" id="id" value="{{ !empty($siswa) ? $siswa->id_siswa : ''}}">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="">Nomor Rekening <small>*)</small></label>
                            <input type="text" name="no_rekening" id="no_rekening" class="form-control" placeholder="Nomor Rekening" autocomplete="off" value="{{ !empty($siswa) ? $siswa->no_rekening : ''}}">
                        </div>
                        <div class="col-md-3">
                            <label for="">Jenis Kelamin <small>*)</small></label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" autocomplete="off">
                                <option value="">- Pilih Jenis Kelamin -</option>
                                <option @if(isset($siswa->jenis_kelamin) && $siswa->jenis_kelamin == 'L') selected @endif value="L">Laki-Laki</option>
                                <option @if(isset($siswa->jenis_kelamin) && $siswa->jenis_kelamin == 'P') selected @endif value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">Nama Kelas <small>*)</small></label>
                            <input type="text" name="nama_kelas" id="nama_kelas" class="form-control" placeholder="Nama Kelas" autocomplete="off" value="{{ !empty($siswa) ? $siswa->nama_kelas : ''}}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="">Nama Siswa <small>*)</small></label>
                            <input type="text" name="nama_siswa" id="nama_siswa" class="form-control" placeholder="Nama Siswa" autocomplete="off" value="{{ !empty($siswa) ? $siswa->nama_siswa : ''}}">
                        </div>
                        <div class="col-md-3">
                            <label for="">Tempat Lahir Siswa <small>*)</small></label>
                            <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" placeholder="Tempat Lahir Siswa" autocomplete="off" value="{{ !empty($siswa) ? $siswa->tempat_lahir : ''}}">
                        </div>
                        <div class="col-md-3">
                            <label for="">Tanggal Lahir Siswa <small>*)</small></label>
                            <div class="input-group date">
                                <input type="text" class="form-control datepicker" name="tgl_lahir" id="tgl_lahir" placeholder="00-00-0000" autocomplete="off" value="{{isset($siswa->tanggal_lahir) ? date("Y-m-d",strtotime($siswa->tanggal_lahir)):''}}">
                                <span class="input-group-append">
                                    <span class="input-group-text bg-white d-block">
                                        <i class="bx bx-calendar"></i>
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="">Nama Ibu Kandung <small>*)</small></label>
                            <input type="text" name="nama_ibu" id="nama_ibu" class="form-control" placeholder="Nama Ibu Kandung" autocomplete="off" value="{{ !empty($siswa) ? $siswa->nama_ibu : ''}}">
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Provinsi <small>*)</small></label>									
                                <select name="provinsi_id" class="form-control select2" id="provinsi" autocomplete="off">
                                    <option value="" readonly="">..::Pilih Provinsi ::..</option>
                                    @foreach ($data_provinsi as $row)
                                        @if ($row->id == $KD_PROVINSI)
                                            <option value="{{$row->id}}" selected="selected">{{$row->name}}</option>
                                        @else
                                            <option value="{{$row->id}}" >{{$row->name}}</option>
                                        @endif
                                    @endforeach
                                </select>	
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Kabupaten / Kota <small>*)</small></label>
                                <select name="kabupaten_id" class="form-control select2" id="kabupaten" autocomplete="off">
                                    <option value="" readonly="">..::Pilih Kab/Kota ::..</option>
                                    <option value="{{ $KD_KABUPATEN }}" selected="selected">{{ $KABUPATEN }}</option>
                                </select>									
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="">Alamat <small>*)</small></label><br>
                            <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Alamat Siswa" autocomplete="off" value="{{ !empty($siswa) ? $siswa->alamat : ''}}">
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Kecamatan <small>*)</small></label>
                                <select name="kecamatan_id" class="form-control select2" id="kecamatan" autocomplete="off">
                                    <option value="" readonly="">..:: Pilih Kecamatan ::..</option>
                                    <option value="{{ $KD_KECAMATAN }}" selected="selected">{{ $KECAMATAN }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Kelurahan / Desa <small>*)</small></label>
                                <select name="desa_id" class="form-control select2" id="desa" autocomplete="off">									
                                    <option value="" readonly="">..:: Pilih Kelurahan/Desa ::..</option>
                                    <option value="{{ $KD_KELURAHAN }}" selected="selected">{{ $KELURAHAN }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="">Alamat Surat Menyurat</label>
                            <input type="text" name="alamat_surat_menyurat" class="form-control" placeholder="Alamat Surat Menyurat" autocomplete="off" value="{{ !empty($siswa) ? $siswa->alamat_surat : ''}}">
                        </div>
                        <div class="col-md-6">
                            <label for="">Kode pos</label>
                            <input type="text" name="kode_pos" class="form-control" placeholder="Kode Pos" autocomplete="off" value="{{ !empty($siswa) ? $siswa->kode_pos : ''}}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <span><b>Nomor Telepon</b></span>
                        <div class="col-md-6">
                            <label for="">Jenis Nomor Telepon</label>
                            <select name="jenis_telepon" id="jenis_telepon" class="form-control" autocomplete="off">
                                <option value="">- Pilih Jenis Telepon -</option>
                                <option @if(isset($siswa->jenis_telepon) && $siswa->jenis_telepon == 'Rumah') selected @endif value="Rumah">Rumah</option>
                                <option @if(isset($siswa->jenis_telepon) && $siswa->jenis_telepon == 'Kantor') selected @endif value="Kantor">Kantor</option>
                                <option @if(isset($siswa->jenis_telepon) && $siswa->jenis_telepon == 'handphone') selected @endif value="handphone">Handphone</option>
                                <option @if(isset($siswa->jenis_telepon) && $siswa->jenis_telepon == 'Fax') selected @endif value="Fax">Fax</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="">Nomor Telepon</label>
                            <input type="text" name="telepon" class="form-control" placeholder="000000000000" autocomplete="off" value="{{ !empty($siswa) ? $siswa->no_telepon : ''}}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <span><b>Tanda Pengenal</b></span>
                        <div class="col-md-6">
                            <label for="">Jenis Tanda Pengenal </label>
                            <select name="jenis_tanda_pengenal" id="jenis_tanda_pengenal" class="form-control" autocomplete="off">
                                <option value="">- Pilih Tanda Pengenal -</option>
                                <option @if(isset($siswa->jenis_tanda_pengenal) && $siswa->jenis_tanda_pengenal == 'KTP') selected @endif value="KTP">KTP</option>
                                <option @if(isset($siswa->jenis_tanda_pengenal) && $siswa->jenis_tanda_pengenal == 'SIM') selected @endif value="SIM">SIM</option>
                                <option @if(isset($siswa->jenis_tanda_pengenal) && $siswa->jenis_tanda_pengenal == 'PASPOR') selected @endif value="PASPOR">PASPOR</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="">Nomor Tanda Pengenal </label>
                            <input type="text" name="nomor_tanda_pengenal" class="form-control" maxlength="16" pattern="/^-?\d+\.?\d*$/" placeholder="000000000000" autocomplete="off" value="{{ !empty($siswa) ? $siswa->nomor_tanda_pengenal : ''}}">
                            <div id="errKtp"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <span><b>Pembukaan Rekening</b></span>
                        <div class="col-md-3">
                            <label for="">Rekening Yang Dibuka <small>*)</small></label>
                            <select name="jenis_rekening" id="jenis_rekening" class="form-control" autocomplete="off">
                                <option value="">- Pilih Rekening -</option>
                                <option @if(isset($siswa->jenis_rekening) && $siswa->jenis_rekening == 'Giro') selected @endif value="Giro">Giro Tabungan</option>
                                <option @if(isset($siswa->jenis_rekening) && $siswa->jenis_rekening == 'Deposito') selected @endif value="Deposito">Deposito</option>
                                <option @if(isset($siswa->jenis_rekening) && $siswa->jenis_rekening == 'Tabungan') selected @endif value="Tabungan">Tabungan</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">NPWP</label>
                            <select name="npwp" id="npwp" class="form-control" autocomplete="off">
                                <option @if(isset($siswa->npwp) && $siswa->npwp == 'ada') selected @endif value="ada">Ada</option>
                                <option @if(isset($siswa->npwp) && $siswa->npwp == 'tidak ada') selected @endif value="tidak ada" selected>Tidak Ada</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="">No. NPWP</label>
                            <input type="text" name="no_npwp" class="form-control" placeholder="000000000000" autocomplete="off" value="{{ !empty($siswa) ? $siswa->no_npwp : ''}}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="">Penyampaian R/K</label>
                            <select name="penyampaian_r_k" id="penyampaian_r_k" class="form-control" autocomplete="off">
                                <option value="">- Pilih Penyampaian -</option>
                                <option @if(isset($siswa->penyampaian_r_k) && $siswa->penyampaian_r_k == 'Dikirim') selected @endif value="Dikirim">Dikirim</option>
                                <option @if(isset($siswa->penyampaian_r_k) && $siswa->penyampaian_r_k == 'Diambil Sendiri') selected @endif value="Diambil Sendiri">Diambil Sendiri</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">Penerbitan R/K</label>
                            <select name="penerbitan_r_k" id="penerbitan_r_k" class="form-control" autocomplete="off">
                                <option value="">- Pilih Penerbitan -</option>
                                <option @if(isset($siswa->penerbitan_r_k) && $siswa->penerbitan_r_k == 'Bulanan') selected @endif value="Bulanan">Bulanan</option>
                                <option @if(isset($siswa->penerbitan_r_k) && $siswa->penerbitan_r_k == 'Mingguan') selected @endif value="Mingguan">Mingguan</option>
                                <option @if(isset($siswa->penerbitan_r_k) && $siswa->penerbitan_r_k == 'Harian') selected @endif value="Harian">Harian</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="">Referensi <b>(Khusus Tabungan Giro)</b></label>
                            <input type="text" name="referensi" class="form-control" placeholder="000000000000" autocomplete="off" value="{{ !empty($siswa) ? $siswa->referensi : ''}}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="card text-white" style="background: #7B8FA1">
                            <div class="col-md-12">
                                <span >KHUSUS PERORANGAN</span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="">Pekerjaan</label>
                            <select name="pekerjaan" id="pekerjaan" class="form-control">
                                <option value="">- Pilih Pekerjaan -</option>
                                <option @if(isset($siswa->pekerjaan) && $siswa->pekerjaan == 'Pelajar / Mhs') selected @endif value="Pelajar / Mhs">Pelajar / Mhs</option>
                                <option @if(isset($siswa->pekerjaan) && $siswa->pekerjaan == 'Ibu RT') selected @endif value="Ibu RT">Ibu RT</option>
                                <option @if(isset($siswa->pekerjaan) && $siswa->pekerjaan == 'Kary. Swasta') selected @endif value="Kary. Swasta">Kary. Swasta</option>
                                <option @if(isset($siswa->pekerjaan) && $siswa->pekerjaan == 'Pegawai Negeri') selected @endif value="Pegawai Negeri">Pegawai Negeri</option>
                                <option @if(isset($siswa->pekerjaan) && $siswa->pekerjaan == 'TNI / POLRI') selected @endif value="TNI / POLRI">TNI / POLRI</option>
                                <option @if(isset($siswa->pekerjaan) && $siswa->pekerjaan == 'Wirausaha') selected @endif value="Wirausaha">Wirausaha</option>
                                <option @if(isset($siswa->pekerjaan) && $siswa->pekerjaan == 'Manajer') selected @endif value="Manajer">Manajer</option>
                                <option @if(isset($siswa->pekerjaan) && $siswa->jenis_telepon == 'Profesional') selected @endif value="Profesional">Profesional</option>
                                <option @if(isset($siswa->pekerjaan) && $siswa->jenis_telepon == 'Lainnya') selected @endif value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">Status</label>
                            <select name="status" id="status" class="form-control" autocomplete="off">
                                <option value="">- Pilih Status -</option>
                                <option @if(isset($siswa->status) && $siswa->status == 'lajang') selected @endif value="lajang">Lajang</option>
                                <option @if(isset($siswa->status) && $siswa->status == 'menikah') selected @endif value="menikah">Menikah</option>
                                <option @if(isset($siswa->status) && $siswa->status == 'duda') selected @endif value="duda">Duda</option>
                                <option @if(isset($siswa->status) && $siswa->status == 'janda') selected @endif value="janda">Janda</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">Pendidikan Terakhir</label>
                            <select name="pendidikan_terakhir" id="pendidikan_terakhir" class="form-control" autocomplete="off">
                                <option value="">- Pilih Pendidikan Terakhir -</option>
                                <option @if(isset($siswa->pendidikan_terakhir) && $siswa->pendidikan_terakhir == 'SD') selected @endif value="SD">SD</option>
                                <option @if(isset($siswa->pendidikan_terakhir) && $siswa->pendidikan_terakhir == 'SLTP') selected @endif value="SLTP">SLTP</option>
                                <option @if(isset($siswa->pendidikan_terakhir) && $siswa->pendidikan_terakhir == 'SLTA') selected @endif value="SLTA">SLTA</option>
                                <option @if(isset($siswa->pendidikan_terakhir) && $siswa->pendidikan_terakhir == 'Akademi') selected @endif value="Akademi">Akademi</option>
                                <option @if(isset($siswa->pendidikan_terakhir) && $siswa->pendidikan_terakhir == 'Sarjana') selected @endif value="Sarjana">Sarjana</option>
                                <option @if(isset($siswa->pendidikan_terakhir) && $siswa->pendidikan_terakhir == 'Pascasarjana') selected @endif value="Pascasarjana">Pascasarjana</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">Penghasilan Per Bulan</label>
                            <select name="penghasilan_per_bulan" id="penghasilan_per_bulan" class="form-control" autocomplete="off">
                                <option value="">- Penghasilan Per Bulan -</option>
                                <option @if(isset($siswa->penghasilan_per_bulan) && $siswa->penghasilan_per_bulan == '< 0,5 Juta') selected @endif value="< 0,5 Juta">< Rp. 0,5 juta</option>
                                <option @if(isset($siswa->penghasilan_per_bulan) && $siswa->penghasilan_per_bulan == '0,5 s/d 1 jt') selected @endif value="0,5 s/d 1 jt">Rp. 0,5 s/d 1 jt</option>
                                <option @if(isset($siswa->penghasilan_per_bulan) && $siswa->penghasilan_per_bulan == '1 s/d 2 jt') selected @endif value="1 s/d 2 jt"> Rp. 1 s/d 2 jt</option>
                                <option @if(isset($siswa->penghasilan_per_bulan) && $siswa->penghasilan_per_bulan == '2 s/d 3 jt') selected @endif value="2 s/d 3 jt">Rp. 2 s/d 3 jt</option>
                                <option @if(isset($siswa->penghasilan_per_bulan) && $siswa->penghasilan_per_bulan == '3 s/d 4 jt') selected @endif value="3 s/d 4 jt">Rp. 3 s/d 4 jt</option>
                                <option @if(isset($siswa->penghasilan_per_bulan) && $siswa->penghasilan_per_bulan == '4 s/d 5 jt') selected @endif value="4 s/d 5 jt">Rp. 4 s/d 5 jt</option>
                                <option @if(isset($siswa->penghasilan_per_bulan) && $siswa->penghasilan_per_bulan == '5 s/d 6 jt') selected @endif value="5 s/d 6 jt">Rp. 5 s/d 6 jt</option>
                                <option @if(isset($siswa->penghasilan_per_bulan) && $siswa->penghasilan_per_bulan == '> 6 jt') selected @endif value="> 6 jt">> Rp. 6 jt</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-debet mb-2" style="width: 100%" id="simpan_nasabah">SIMPAN NASABAH</button>
                    </div>
                    <div class="col-md-12">
                        <button type="button" class="btn btnKembali text-white" style="width: 100%; background-color: #665A48;">KEMBALI</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(".select-2").select2();

        // START DAERAH
        $('#provinsi').change(function(){
            var id = $('#provinsi').val();
            $.post("{{route('get_kabupaten')}}",{id:id},function(data){
                var kabupaten = '<option value="">..:: Pilih Kabupaten ::..</option>';
                if(data.status=='success'){
                    if(data.data.length>0){
                        $.each(data.data,function(v,k){
                            kabupaten+='<option value="'+k.id+'">'+k.name+'</option>';
                        });
                    }
                }
                $('#kabupaten').html(kabupaten);
            });
        });
        
        $('#kabupaten').change(function(){
            var id = $('#kabupaten').val();
            $.post("{{route('get_kecamatan')}}",{id:id},function(data){
                var kecamatan = '<option value="">..:: Pilih Kecamatan ::..</option>';
                if(data.status=='success'){
                    if(data.data.length>0){
                        $.each(data.data,function(v,k){
                            kecamatan+='<option value="'+k.id+'">'+k.name+'</option>';
                        });
                    }
                }
                $('#kecamatan').html(kecamatan);
            });
        });

        $('#kecamatan').change(function(){
            var id = $('#kecamatan').val();
            $.post("{{route('get_desa')}}",{id:id},function(data){
                var desa = '<option value="">..:: Pilih Desa ::..</option>';
                if(data.status=='success'){
                    if(data.data.length>0){
                        $.each(data.data,function(v,k){
                            desa+='<option value="'+k.id+'">'+k.name+'</option>';
                        });
                    }
                }
                $('#desa').html(desa);
            });
        });
        // END DAERAH

        // Tambah Row Pengurus
        var no = 0;
        $(".add-pengurus").click(function(){
            var rows = $('#table_pengurus tr').length;
            var nama = $("#nama_pengurus").val();
            var jabatan = $("#jabatan").val();
            var alamat = $("#alamat_pengurus").val();
            
            no += 1;
            var markup = `
                <tr id="row_anak${no}">
                    <td>
                        <input type="hidden" class="form-control" name="id_pengurus[]" value="${rows}">
                        ${rows}
                    </td>
                    <td>
                        <input type="hidden" class="form-control" name="nama_pengurus[]" value="${nama}">
                        ${nama}
                    </td>
                    <td>
                        <input type="hidden" class="form-control" name="jabatan_pengurus[]" value="${jabatan}">
                        ${jabatan}
                    </td>
                    <td>
                        <input type="hidden" class="form-control" name="alamat_pengurus[]" value="${alamat}">
                        ${alamat}
                    </td>
                    <td class="text-center">
                        <button type="hidden" class="btn btn-danger" onclick="delete-row-pengurus(${no})"><i class='bx bx-trash'></i></button>
                    </td>
                </tr>
            `;
            // var aksi = "<button type='button' class='btn btn-danger delete-row-pengurus'><i class='bx bx-trash'></i></button>"
            // var markup = "<tr><td>" + rows + "</td><td type='hidden' name='nama_pengurus'>" + nama + "</td><td type='hidden' name='pengurus[]'>" + jabatan + "</td><td type='hidden' name='pengurus[]'>" + alamat + "</td><td class='text-center'>" + aksi + "</td></tr>";
            $("#dataPengurus").append(markup);

            // Default input
            $("#nama_pengurus").val('');
            $("#jabatan").val('');
            $("#alamat_pengurus").val('');
        });

        // Tambah Row Group Usaha
        $(".add-group-usaha").click(function(){
            var rows = $('#table_group_usaha tr').length;
            var nama = $("#nama_perusahaan").val();
            var hubungan = $("#hubungan_usaha").val();
            var jenis = $("#jenis_usaha").val();
            var alamat = $("#alamat_perusahaan").val();

            no += 1;
            var markup = `
                <tr id="row_anak${no}">
                    <td>
                        <input type="hidden" class="form-control" name="id_group_usaha[]" value="${rows}">
                        ${rows}
                    </td>
                    <td>
                        <input type="hidden" class="form-control" name="nama_perusahaan[]" value="${nama}">
                        ${nama}
                    </td>
                    <td>
                        <input type="hidden" class="form-control" name="hubungan_usaha[]" value="${hubungan}">
                        ${hubungan}
                    </td>
                    <td>
                        <input type="hidden" class="form-control" name="jenis_usaha[]" value="${jenis}">
                        ${jenis}
                    </td>
                    <td>
                        <input type="hidden" class="form-control" name="alamat_perusahaan[]" value="${alamat}">
                        ${alamat}
                    </td>
                    <td class="text-center">
                        <button type="hidden" class="btn btn-danger" onclick="delete_row_usaha(${no})"><i class='bx bx-trash'></i></button>
                    </td>
                </tr>
            `;
            // var aksi = "<button type='button' class='btn btn-danger delete-row-usaha'><i class='bx bx-trash'></i></button>"
            // var markup = "<tr><td>" + rows + "</td><td>" + nama + "</td><td>" + hubungan + "</td><td>" + jenis + "</td><td>" + alamat + "</td><td class='text-center'>" + aksi + "</td></tr>";
            $("#data_group_usaha").append(markup);

            // Default input
            $("#nama_perusahaan").val('');
            $("#hubungan_usaha").val('');
            $("#jenis_usaha").val('');
            $("#alamat_perusahaan").val('');
        });
        
        // Hapus Row Pengurus
        $(".delete-row-pengurus").click(function(){
            $("table_pengurus tbody").find('input[name="record"]').each(function(){
                if($(this).is(":checked")){
                    $(this).parents("tr").remove();
                }
            });
        });

        // Hapus Row Group Usaha
        $(".delete-row-pengurus").click(function(){
            $("table_pengurus tbody").find('input[name="record"]').each(function(){
                if($(this).is(":checked")){
                    $(this).parents("tr").remove();
                }
            });
        });
    });

    $('.datepicker').pickadate({
		selectMonths: true,
		selectYears: true
        // getFullYear: true
	})

    $('#simpan_nasabah').click(function  (e) { 
        e.preventDefault();

        var data = new FormData($("#form-data")[0]);
        var norek = $('#no_rekening').val();
        var nama_siswa = $('#nama_siswa').val();
        var nama_ibu = $('#nama_ibu').val();
        var alamat = $('#alamat').val();
        var jenis_kelamin = $('#jenis_kelamin').val();
        var nama_kelas = $('#nama_kelas').val();
        var provinsi_id = $('#provinsi').val();
        var kabupaten_id = $('#kabupaten').val();
        var kecamatan_id = $('#kecamatan').val();
        var desa_id = $('#desa').val();
        var tempat_lahir = $('#tempat_lahir').val();
        var tanggal_lahir = $('#tgl_lahir').val();

        if (!norek) {
            Swal.fire('Whooops','No Rekening Tidak Boleh Kosong!','warning');
        } else if(!nama_siswa){
            Swal.fire('Whooops','Nama Siswa Tidak Boleh Kosong!','warning');
        } else if (!nama_ibu) {
            Swal.fire('Whooops','Nama Ibu Tidak Boleh Kosong!','warning');
        } else if (!alamat) {
            Swal.fire('Whooops','Alamat Siswa Tidak Boleh Kosong!','warning');
        }  else if(!jenis_kelamin) {
            Swal.fire('Whooops','Jenis Kelamin Tidak Boleh Kosong!','warning');
        } else if(!nama_kelas) {
            Swal.fire('Whooops','Nama Kelas Tidak Boleh Kosong!','warning');
        } else if(!provinsi_id) {
            Swal.fire('Whooops','Provinsi Lahir Tidak Boleh Kosong!','warning');
        } else if(!kabupaten_id) {
            Swal.fire('Whooops','Kabupaten Tidak Boleh Kosong!','warning');
        } else if(!kecamatan_id) {
            Swal.fire('Whooops','Kecamatan / Kota Tidak Boleh Kosong!','warning');
        } else if(!desa_id) {
            Swal.fire('Whooops','Desa Tidak Boleh Kosong!','warning');
        } else if(!tempat_lahir) {
            Swal.fire('Whooops','Tempat Lahir Tidak Boleh Kosong!','warning');
        } else if(!tanggal_lahir) {
            Swal.fire('Whooops','Tanggal Lahir Tidak Boleh Kosong!','warning');
        } else{
            $.ajax({
                url : "{{route('save-siswa')}}",
                type: 'POST',
                data: data,
                async: true,
                cache: false,
                contentType: false,
                processData: false
            }).done(function(data) {
                if (data.status == 'success') {
                    Swal.fire('Berhasil', data.message, 'success');
                    $("#other-page").fadeOut(function(){
                        $("#other-page").empty();
                        $("#main-page").fadeIn();
                    });
                    location.reload();
                } else {
                    Swal.fire('Maaf!', 'Gagal Menyimpan', 'error');
                }
            }).fail(function() {
                Swal.fire("MAAF!", "Terjadi Kesalahan, Silahkan Ulangi Kembali !!", "warning");
                $('#simpan_nasabah').removeAttr('disabled');
            });
        }
    });

    $('input[name="nomor_tanda_pengenal"]').keyup(() => {
		var nik = $('input[name="nomor_tanda_pengenal"]').val();
		if (nik.length < 16) {
            $('#errKtp').html('Nomor Tanda Pengenal Tidak Boleh Kurang Dari 16').stop().show();
            return false;
		} else if (nik.length <= 16) {
			$('#errKtp').html('Nomor Tanda Pengenal Tidak Boleh Lebih Dari 16').stop().show().fadeOut();
		} else {
			$('#errKtp').hide();
		}
	})

    $('.btnKembali').click(()=>{
		$('.other-page').fadeOut(function(){
			hideForm()
		})
	})
</script>