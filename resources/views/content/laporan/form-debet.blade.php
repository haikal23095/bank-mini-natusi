<style>
    #simpan {
        color: #fff;
        background-color: #829460;
        /* border-color: #5bc2c2 */
    }
</style>
@php
	function rupiah($angka){
		$hasil_rupiah = "" . number_format((int)$angka);
		$hasil_rupiah = str_replace(',', '.', $hasil_rupiah);
		return $hasil_rupiah;
	}
@endphp
<div class="page-content">

    <div class="row">
        <div class="col-md-12">
            <form id="form-data" class="card">
                <div class="card-header">EDIT DATA</div>
                <div class="card-body">
                    <input type="hidden" name="id_transaksi" id="id_transaksi" value="{{ !empty($data->id_transaksi) ? $data->id_transaksi : ''}}">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="">Nomor Rekening Tabungan</label>
                            <input type="text" name="norek" id="norek" class="form-control" placeholder="000 000 000" autocomplete="off" onkeyup="cari_siswa('norek')" value="{{ !empty($data->no_rekening) ? $data->no_rekening : ''}}">
                            <div id="tempat_data"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="">Saldo Saat Ini</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Rp</span>
                                </div>
                                <input type="text" name="saldo_saat_ini" id="saldo_saat_ini" class="form-control" autocomplete="off" placeholder="000 000 000" value="{{ !empty($data->saldo) ? rupiah($data->saldo) : ''}}">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="">Nama Siswa</label>
                            <input type="text" name="nama_siswa" id="nama_siswa" class="form-control" placeholder="Nama Siswa" autocomplete="off" onkeyup="cari_siswa('nama')" value="{{ !empty($data->nama_siswa) ? $data->nama_siswa : ''}}">
                        </div>
                        <div class="col-md-6">
                            <label for="">Jumlah Debet <small>*)</small></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Rp</span>
                                </div>
                                <input type="text" name="jumlah_debet" id="jumlah_debet" class="form-control" placeholder="000 000 000" autocomplete="off" onkeyup="ubahFormat(this)" value="{{ !empty($data->jumlah_debet) ? rupiah($data->jumlah_debet) : ''}}">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="">Kelas</label>
                            <input type="text" name="nama_kelas" id="nama_kelas" class="form-control" placeholder="Nama Kelas" value="{{ !empty($data->nama_kelas) ? $data->nama_kelas : ''}}">
                        </div>
                        <div class="col-md-4">
                            <label for="">Sandi <small>*)</small></label>
                            <select name="sandi" id="sandi" class="form-control" autocomplete="off">
                                <option value="">- Pilih Sandi -</option>
                                <option @if (!empty($data->sandi) && $data->sandi == '02') selected @endif value="02"> Penarikan Tunai </option>
                                <option @if (!empty($data->sandi) && $data->sandi == '03') selected @endif value="03"> Setoran Pemindahbukuan </option>
                                <option @if (!empty($data->sandi) && $data->sandi == '04') selected @endif value="04"> Penarikan Pemindahan </option>
                                <option @if (!empty($data->sandi) && $data->sandi == '05') selected @endif value="05"> Administrasi Tabungan </option>
                                <option @if (!empty($data->sandi) && $data->sandi == '06') selected @endif value="06"> Penutupan Rekening </option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Tanggal Transaksi <small>*)</small></label>
                            <div class="input-group date" data-date-format="yyyy-mm-dd">
                                <span class="input-group-append">
                                    <span class="input-group-text bg-white d-block">
                                        <i class="bx bx-calendar"></i>
                                    </span>
                                </span>
                                <input type="text" name="tgl_transaksi" id="tgl_transaksi" class="form-control datepicker" placeholder="0000-00-00" autocomplete="off" value="{{isset($data->tanggal_transaksi) ? date("Y-m-d",strtotime($data->tanggal_transaksi)):''}}">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-check form-switch">
                                <label class="form-check-label" for="flexSwitchCheckChecked">Pengesahan Petugas</label>
                                <input class="form-check-input" type="checkbox" name="pengesahan_petugas" checked>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-md-12">
                        <button type="button" class="btn simpan mb-2" id="simpan" style="width: 100%"> SIMPAN </button>
                        <button type="button" class="btn" style="width: 100%; background-color: #665A48; color: #fff;" onclick="kembali()">KEMBALI</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
	$(document).ready(function() {
		$(".knob").knob()
        $('#nama_kelas').prop('readonly', true);
        $('#sandi').prop('readonly', true);
	});

    $('.datepicker').pickadate({
		selectMonths: true,
		selectYears: true
	})

    function cari_siswa(param){
        if (param == 'norek') {
            var cari = $('input[name=norek]').val();
        } else {
            var cari = $('input[name=nama_siswa]').val();
        }
		if(cari==''){
			$('#tempat_data').html('');
			return;
		}
		$.post("{{route('debet-cari')}}",{cari:cari, param:param},function(data){
            var html = '';
            if(data.data.length!=0){
                $.each(data.data,function(k,v){
                    html+='<a href="javascript:void(0)" onclick="pilih_siswa(\''+v.no_rekening+'\')">'+v.no_rekening+' (Nama = '+v.nama_siswa+')</a><br>';
                });
            }
            $('#tempat_data').html(html);
		});
		
	}

    function pilih_siswa(param){
        $('#tempat_data').html('');
		$.post("{{route('debet-pilih')}}",{no_rekening:param},function(data){
            var rek = data.data.no_rekening;
            var saldo = (data.data.saldo !== null) ? data.data.saldo : 0;
            var nama = data.data.nama_siswa;
            var kelas = data.data.nama_kelas;
            var id = data.data.id_siswa;
            // console.log(saldo)
            // console.log(formatRupiah(saldo,''))

            $('#id').val(id);
            $('#norek').val(rek);
            $('#saldo_saat_ini').val(formatRupiah(saldo,''))
            $('#nama_siswa').val(nama);
            $('#nama_kelas').val(kelas);
            $('#saldo_saat_ini').prop('readonly', true);
            $('#nama_kelas').prop('readonly', false);
		});
	}

    $('#simpan').click(function (e) { 
        e.preventDefault();
        var data = new FormData($("#form-data")[0]);
        var jumlah = $('#jumlah_debet').val();
        var sandi = $('#sandi').val();
        var tanggal = $('#tgl_transaksi').val();
        console.log(tanggal)

        if (!jumlah) {
            Swal.fire('Maaf!', 'Jumlah Debet Wajib Diisi', 'warning');
        } else if(!sandi) {
            Swal.fire('Maaf!', 'Sandi Wajib Diisi', 'warning');
        } else if(!tanggal) {
            Swal.fire('Maaf!', 'Tanggal Transaksi Wajib Diisi', 'warning');
        } else {
            $.ajax({
                url : "{{route('save-transaksi')}}",
                type: 'POST',
                data: data,
                async: true,
                cache: false,
                contentType: false,
                processData: false
            }).done(function(data) {
                if (data.status == 'success') {
                    Swal.fire('Berhasil', data.message, 'success');
                    location.reload();
                } else {
                    Swal.fire('Maaf!', 'Gagal Menyimpan', 'error');
                }
            }).fail(function() {
                Swal.fire("MAAF!", "Terjadi Kesalahan, Silahkan Ulangi Kembali !!", "warning");
                $('simpan').removeAttr('disabled');
            });
        }
    });

    function ubahFormat(val){
		$('#jumlah_debet').val(formatRupiah(val.value,''))
	}

    function formatRupiah(angka, prefix) {
		var number_string = angka.toString().replace(/[^,\d]/g, '')
		// var number_string = angka.replace(/[^,\d]/g, "").toString()
		split = number_string.split(',')
		sisa = split[0].length % 3
		rupiah = split[0].substr(0, sisa)
		ribuan = split[0].substr(sisa).match(/\d{3}/gi)

		// tambahkan titik jika yang di input sudah menjadi angka ribuan
		if (ribuan) {
			separator = sisa ? '.' : ''
			rupiah += separator + ribuan.join('.')
		}
		rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah
		return prefix == undefined ? rupiah : rupiah ? rupiah : ''
	}
    
    function kembali() {
        $('.other-page').fadeOut(function(){
			hideForm()
		})
    }
</script>