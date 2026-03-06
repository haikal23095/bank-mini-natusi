@extends('layout.main')

@push('style')
<style>
    #simpan {
        color: #ffffff;
        background-color: #829460;
    }
    #kembali {
        color: #ffffff;
        background-color: #665A48;
    }
</style>
@endpush
@php
	function rupiah($angka){
		$hasil_rupiah = "" . number_format((int)$angka);
		$hasil_rupiah = str_replace(',', '.', $hasil_rupiah);
		return $hasil_rupiah;
	}
@endphp

@section('content')
	<div class="page-content">
		@include('include.breadcrumb')

		<form id="form-data" class="card">
            <div class="card-header">Pengaturan</div>
            <div class="card-body">
                <input type="hidden" name="id" id="id" value="{{ !empty($data) ? rupiah($data->id_pengaturan_tabungan) : ''}}">
                <div class="row mb-3">
                    <span><b>Pengaturan Awal</b></span>
                    <div class="col-md-4">
                        <label for="">Nominal Tabungan Pertama</label>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Rp</span>
                            </div>
                            <input type="text" name="nominal_tabungan_pertama" id="nominal_tabungan_pertama" class="form-control rupiah" placeholder="000 000 000" value="{{ !empty($data) ? rupiah($data->nominal_tabungan_pertama) : ''}}">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <span><b>Debet</b></span>
                    <div class="col-md-4">
                        <label for="">Minimum Pengambilan</label>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Rp</span>
                            </div>
                            <input type="text" name="minimum_pengambilan" id="minimum_pengambilan" class="form-control rupiah" placeholder="000 000 000" value="{{ !empty($data) ? rupiah($data->minimum_pengambilan, '') : ''}}">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <span><b>Kredit</b></span>
                    <div class="col-md-4">
                        <label for="">Minimum Saldo</label>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Rp</span>
                            </div>
                            <input type="text" name="minimum_saldo" class="form-control rupiah" placeholder="0" value="{{ !empty($data) ? rupiah($data->minimum_saldo) : ''}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="col-md-12">
                    <button type="button" class="btn btn-debet mb-2" style="width: 100%" id="simpan"> SIMPAN PERUBAHAN </button>
                    <button type="button" class="btn btn-kembali" id="kembali" style="width: 100%" onclick="alert('Tombol kembali belum ada aksi')"> KEMBALI </button>
                </div>
            </div>
        </form>
	</div>
@endsection

@push('script')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{url('assets/plugins/jquery-knob/jquery.knob.js')}}"></script>
<script type="text/javascript">
    $('.rupiah').maskMoney({allowNegative: true, thousands:'.', decimal:',', precision:0, affixesStay: false});

	$(document).ready(function() {
		$(".knob").knob()
	});

    // SIMPAN
    $('#simpan').click(function (e) { 
        e.preventDefault();
        var data = new FormData($("#form-data")[0]);
        var ntpertama = $('#nominal_tabungan_pertama').val();
        var minimum = $('#minimum_pengambilan').val();

        if (!ntpertama) {
            Swal.fire('Sorry!', 'Nominal Tabungan Pertama Wajib Diisi', 'warning');
        } else if(!minimum) {
            Swal.fire('Sorry!', 'Minimum Pengambilan Wajib Diisi', 'warning');
        } else {
            $.ajax({
                url : "{{route('save-pengaturan')}}",
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
                } else if(data.status == 'error'){
                    if(data.code == 500){
                        $('#simpan').removeAttr('disabled');
                        Swal.fire('Sorry!', data.message, 'info');
                    } else {
                        var n = 0
                        for(key in data.message){
                            var  name = key
                            if(name=='nominal_tabungan_pertama'){name='Nominal Tabungan Pertama'}
                            else if(name=='minimum_pengambilan'){name='Minimum Pengambilan'}
                            n++
                        }
                        
                        $('#simpan').removeAttr('disabled');
                        Swal.fire('Sorry!', name+' Wajib Diisi', 'info');
                    }
                }
            }).fail(function() {
                Swal.fire("MAAF!", "Terjadi Kesalahan, Silahkan Ulangi Kembali !!", "warning");
                $('#simpan').removeAttr('disabled');
            });   
        }  
    });

    function ubahFormat(val){
		$('#salary').val(formatRupiah(val.value,'Rp. '))
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