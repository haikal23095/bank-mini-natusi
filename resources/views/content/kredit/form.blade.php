@extends('layout.main')

@push('style')
<link href="{{asset('assets/plugins/datetimepicker/css/classic.css')}}" rel="stylesheet">
<link href="{{asset('assets/plugins/datetimepicker/css/classic.date.css')}}" rel="stylesheet">
<style>
    #simpan-kredit {
        color: #fff;
        background-color: #829460;
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
                    <div class="card-header">KREDIT</div>
                    <div class="card-body">
                        <input type="hidden" name="id" id="id">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="">Nomor Rekening Tabungan</label>
                                <input type="text" name="norek" id="norek" class="form-control" placeholder="000 000 000" autocomplete="off" onkeyup="cari_siswa('norek')">
                                <div id="tempat_data"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="">Saldo Saat Ini</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Rp</span>
                                    </div>
                                    <input type="text" name="saldo_saat_ini" id="saldo_saat_ini" class="form-control" autocomplete="off" placeholder="000 000 000">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="">Nama Siswa</label>
                                <input type="text" name="nama_siswa" id="nama_siswa" class="form-control" placeholder="Nama Siswa" autocomplete="off" onkeyup="cari_siswa('nama')">
                            </div>
                            <div class="col-md-6">
                                <label for="">Jumlah Kredit <small>*)</small></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Rp</span>
                                    </div>
                                    <input type="text" name="jumlah_kredit" id="jumlah_kredit" class="form-control" placeholder="000 000 000" autocomplete="off" onkeyup="ubahFormat(this)">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="">Kelas</label>
                                <input type="text" name="nama_kelas" id="nama_kelas" class="form-control" placeholder="Nama Kelas">
                            </div>
                            <div class="col-md-4">
                                <label for="">Sandi <small>*)</small></label>
                                <select name="sandi" id="sandi" class="form-control" autocomplete="off">
                                    <option value="">- Pilih Sandi -</option>
                                    <option value="01" selected> Setoran Tunai </option>
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
                            <button type="button" class="btn simpan-kredit" id="simpan-kredit" style="width: 100%"> PROSES KREDIT </button>
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
		$.post("{{route('kredit-cari')}}",{cari:cari, param:param},function(data){
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
		$.post("{{route('kredit-pilih')}}",{no_rekening:param},function(data){
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

    $('.simpan-kredit').click(function (e) { 
        e.preventDefault();
        var data = new FormData($("#form-data")[0]);
        var jumlah = $('#jumlah_kredit').val();
        var sandi = $('#sandi').val();
        var tanggal = $('#tgl_transaksi').val();
        console.log(tanggal)

        if (!jumlah) {
            Swal.fire('Maaf!', 'Jumlah Kredit Wajib Diisi', 'warning');
        } else if(!sandi) {
            Swal.fire('Maaf!', 'Sandi Wajib Diisi', 'warning');
        } else if(!tanggal) {
            Swal.fire('Maaf!', 'Tanggal Transaksi Wajib Diisi', 'warning');
        } else {
            $(".simpan-kredit").prop("disabled", true);
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
                    $(".simpan-kredit").prop("disabled", false);
                }
            }).fail(function() {
                Swal.fire("MAAF!", "Terjadi Kesalahan, Silahkan Ulangi Kembali !!", "warning");
                $(".simpan-kredit").prop("disabled", false);
            });
        }
    });

    function ubahFormat(val){
		$('#jumlah_kredit').val(formatRupiah(val.value,''))
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