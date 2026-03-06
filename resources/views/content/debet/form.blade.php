@extends('layout.main')

@push('style')
<link href="{{asset('assets/plugins/datetimepicker/css/classic.css')}}" rel="stylesheet">
<link href="{{asset('assets/plugins/datetimepicker/css/classic.date.css')}}" rel="stylesheet">
<style>
    #simpan-debet {
        background-color: #829460;
        color: #fff;
        /* border-color: #5bc2c2 */
    }
</style>
@endpush
@php
	function rupiah($angka){
		$hasil_rupiah = "Rp. " . number_format((int)$angka);
		$hasil_rupiah = str_replace(',', '.', $hasil_rupiah);
		return $hasil_rupiah;
	}
@endphp

@section('content')
	<div class="page-content">
		@include('include.breadcrumb')

		<div class="row">
			<div class="col-md-12">
                <form id="form-data" class="card">
                    <div class="card-header">DEBET</div>
                    <div class="card-body">
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="nominal_tabungan_pertama" id="nominal_tabungan_pertama" value="{{ !empty($pengaturan) ? $pengaturan->nominal_tabungan_pertama : ''}}">
                        <input type="hidden" name="minimum_pengambilan" id="minimum_pengambilan" value="{{ !empty($pengaturan) ? $pengaturan->minimum_pengambilan : ''}}">
                        <input type="hidden" name="minimum_saldo" id="minimum_saldo" value="{{ !empty($pengaturan) ? $pengaturan->minimum_saldo : ''}}">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="">Nomor Rekening Tabungan</label>
                                <input type="text" name="norek" id="norek" class="form-control" placeholder="000 000 000" onkeyup="cari_siswa('norek')" autocomplete="off">
                                <div id="tempat_data"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="">Saldo Saat Ini</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Rp</span>
                                    </div>
                                    <input type="text" name="saldo_saat_ini" id="saldo_saat_ini" class="form-control" placeholder="000 000 000" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="">Nama Siswa</label>
                                <input type="text" name="nama_siswa" id="nama_siswa" class="form-control" placeholder="Nama Siswa" onkeyup="cari_siswa('nama')" autocomplete="off">
                            </div>
                            <div class="col-md-6">
                                <label for="">Jumlah debet <small>*)</small></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Rp</span>
                                    </div>
                                    <input type="text" name="jumlah_debet" id="jumlah_debet" class="form-control" placeholder="000 000 000" autocomplete="off" onkeyup="ubahFormat(this)">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="">Kelas</label>
                                <input type="text" name="nama_kelas" id="nama_kelas" class="form-control" placeholder="Nama Kelas" autocomplete="off">
                            </div>
                            <div class="col-md-4">
                                <label for="">Sandi <small>*)</small></label>
                                <select name="sandi" id="sandi" class="form-control">
                                    <option value="">- Pilih Sandi -</option>
                                    <option value="02"> Penarikan Tunai </option>
                                    <option value="03"> Setoran Pemindahbukuan </option>
                                    <option value="04"> Penarikan Pemindahan </option>
                                    <option value="05"> Administrasi Tabungan </option>
                                    <option value="06"> Penutupan Rekening </option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="">Tanggal Transaksi <small>*)</small></label>
                                <div class="input-group" data-date-format="yyyy-mm-dd">
                                    <span class="input-group-append">
                                        <span class="input-group-text bg-white d-block">
                                            <i class="bx bx-calendar"></i>
                                        </span>
                                    </span>
                                    <input type="text" name="tgl_transaksi" id="tgl_transaksi" class="form-control datepicker" placeholder="0000-00-00" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-check form-switch">
                                    <label class="form-check-label" for="flexSwitchCheckChecked">Pengesahan Petugas</label>
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="pengesahan_petugas" checked>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="col-md-12">
                            <button type="button" class="btn simpan-debet" id="simpan-debet" style="width: 100%"> SIMPAN DEBET </button>
                        </div>
                    </div>
                </form>
            </div>
		</div>
	</div>
@endsection

@push('script')
<script src="{{url('assets/plugins/jquery-knob/jquery.knob.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('assets/plugins/datetimepicker/js/picker.js')}}"></script>
<script src="{{asset('assets/plugins/datetimepicker/js/picker.date.js')}}"></script>
<script>
	$(document).ready(function() {
        cari_siswa();
		$(".knob").knob()
        $('#nama_kelas').prop('readonly', true);
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

            $('#id').val(id);
            $('#norek').val(rek);
            $('#saldo_saat_ini').val(formatRupiah(saldo,''))
            $('#nama_siswa').val(nama);
            $('#nama_kelas').val(kelas);
            $('#nama_kelas').prop('readonly', false);
            $('#saldo_saat_ini').prop('readonly', true);
		});
	}

    $('.simpan-debet').click(function (e) { 
        e.preventDefault();
        var data = new FormData($("#form-data")[0]);
        var minimum_pengambilan = parseInt($('#minimum_pengambilan').val());
        var minimum_saldo = parseInt($('#minimum_saldo').val());
        var debet = $('#jumlah_debet').val();
        var saldo = $('#saldo_saat_ini').val();
        var sandi = $('#sandi').val();
        var tanggal = $("#tgl_transaksi").val();
        var intDebet = parseInt(debet.replace(/\D/g,''));
        var intSaldo = parseInt(saldo.replace(/\D/g,''));
        var sum = intSaldo - intDebet;

        console.log(intDebet)
        console.log(minimum_pengambilan)
        if (saldo == 0) {
            Swal.fire("MAAF!", "Tidak Dapat Melakukan Debet Karena Belum Memiliki Saldo !!", "warning");
        } else if (sum < minimum_saldo) {
            Swal.fire("MAAF!", "Penarikan Debet Tidak Boleh Melebihi Minimum Saldo !!", "warning");
        } else if(intDebet < minimum_pengambilan) {
            Swal.fire("MAAF!", "Penarikan Debet Tidak Boleh Lebih Kecil Dari Minimum Pengambilan !!", "warning");
        } else if(!debet) {
            Swal.fire("MAAF!", "Jumlah Debet Wajib Diisi !!", "warning");
        } else if(!sandi) {
            Swal.fire("MAAF!", "Sandi Wajib Diisi !!", "warning");
        } else if(!tanggal) {
            Swal.fire("MAAF!", "Tanggal Transaksi Wajib Diisi !!", "warning");
        } else {
            $(".simpan-debet").prop("disabled", true);
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
                    $(".simpan-debet").prop("disabled", false);
                }
            }).fail(function() {
                Swal.fire("MAAF!", "Terjadi Kesalahan, Silahkan Ulangi Kembali !!", "warning");
                $(".simpan-debet").prop("disabled", false);
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
</script>
@endpush