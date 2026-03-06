@extends('layout.main')

@push('style')
<style>
	.card-title {
		margin-top: 40px;
	}
	/* .card-title2 {
		margin-top: 30px;
		font-size: 19pt;
	} */
	.simpan-debet {
		background: #7876FF;
		color: #ffffff;
	}
	.simpan-kredit {
		background: #FF5964;
		color: #ffffff;
	}
</style>
@endpush

@section('content')
	<div class="page-content">
		@include('include.breadcrumb')

		<div class="row">
			<div class="col-md-12">
				<div class="card" style="background: #C9F4AA">
					<div class="card-body">
						<span><b id="date" style="font-size: 10pt;"></b></span>&nbsp;
						<span id="time" style="font-size: 10pt"></span>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-3">
						<div class="card text-white text-center mb-3" style="width: 100%;">
							<div class="card-header" style="background: #A7727D;">Jumlah Nasabah / Siswa</div>
							<div class="card-body" style="background: #C0CBB7;">
								<div class="row">
									<div class="col-md-12">
										<h5 class="card-title">
											<b>{{$siswa}}</b>
										</h5>
									</div>
									{{-- <div class="col-md-6">
										<img src="{{asset('assets/images/siswa.png')}}" alt="siswa PNG">
									</div> --}}
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card text-white mb-3 text-center" style="width: 100%;">
							<div class="card-header" style="background: #829460;">Jumlah Debet</div>
							<div class="card-body" style="background: #9FC77F;">
								<div class="row">
									<div class="col-md-12">
										<h5 class="card-title">
											<b>Rp. {{number_format($debet,0,',','.')}}</b>
										</h5>
									</div>
									{{-- <div class="col-md-6">
										<img src="{{asset('assets/images/debet.png')}}" alt="siswa PNG">
									</div> --}}
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card text-white mb-3 text-center" style="width: 100%;">
							<div class="card-header" style="background: #57CBD2;">Jumlah Kredit</div>
							<div class="card-body" style="background: #9FEAEF;">
								<div class="row">
									<div class="col-md-12">
										<h5 class="card-title">
											<b>Rp. {{number_format($kredit,0,',','.')}}</b>
										</h5>
									</div>
									{{-- <div class="col-md-6">
										<img src="{{asset('assets/images/kredit.png')}}" alt="siswa PNG">
									</div> --}}
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card text-white mb-3 text-center" style="width: 100%;">
							<div class="card-header" style="background: #967E76;">Jumlah Saldo</div>
							<div class="card-body" style="background: #D7C0AE;">
								<div class="row">
									<div class="col-md-12">
										<h5 class="card-title">
											<b>Rp. {{number_format($saldo,0,',','.')}}</b>
										</h5>
									</div>
									{{-- <div class="col-md-6">
										<img src="{{asset('assets/images/kredit.png')}}" alt="siswa PNG">
									</div> --}}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<h5>AKSES CEPAT DEBET</h5>
				<form id="form-debet" class="card mb-3" style="width: 100%; ">
					<div class="card-header text-center" style="background: #ADACF9;"><span style="color: #ffffff">DEBET</span></div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-12 mb-3">
								<label for="">Nomor Rekening Tabungan</label>
								<input type="text" name="norek_debet" id="norek_debet" class="form-control" placeholder="000 000 000" autocomplete="off" onkeyup="cari_siswa_debet()">
								<div id="tempat_data_debet"></div>
							</div>
							<div class="col-md-12">
								<label for="">Jumlah Debet</label>
								<input type="text" name="jumlah_debet" id="jumlah_debet" class="form-control" placeholder="000 000 000" autocomplete="off" onkeyup="ubahFormatDebet(this)">
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="col-md-12">
							<button type="button" class="btn simpan-debet" style="width: 100%"> SIMPAN DEBET </button>
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-6">
				<h5>AKSES CEPAT KREDIT</h5>
				<form id="form-kredit" class="card mb-3" style="width: 100%;">
					<div class="card-header text-center" style="background: #F9ACB1;"><span style="color: #ffffff">KREDIT</span></div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-12 mb-3">
								<label for="">Nomor Rekening Tabungan</label>
								<input type="text" name="norek_kredit" id="norek_kredit" class="form-control" placeholder="000 000 000" autocomplete="off" onkeyup="cari_siswa_kredit()">
								<div id="tempat_data_kredit"></div>
							</div>
							<div class="col-md-12">
								<label for="">Jumlah Kredit</label>
								<input type="text" name="jumlah_kredit" id="jumlah_kredit" class="form-control" placeholder="000 000 000" autocomplete="off" onkeyup="ubahFormatKredit(this)">
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="col-md-12">
							<button type="button" class="btn simpan-kredit" style="width: 100%"> PROSES KREDIT </button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection

@push('script')
{{-- <script src="{{ url('assets/js/index.js') }}"></script> --}}
<script src="{{url('assets/plugins/jquery-knob/jquery.knob.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
	// SIMPAN KREDIT
	$('.simpan-kredit').click(function (e) { 
        e.preventDefault();
		
		var data = new FormData($("#form-kredit")[0]);
			data.append("akses", "cepat");
			
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
                $(".simpan-kredit").prop("disabled", false);
                Swal.fire('Maaf!', 'Gagal Menyimpan', 'error');
            }
        }).fail(function() {
            $(".simpan-kredit").prop("disabled", false);
            Swal.fire("MAAF!", "Terjadi Kesalahan, Silahkan Ulangi Kembali !!", "warning");
        });
    });

	// SIMPAN DEBET
	$('.simpan-debet').click(function (e) { 
        e.preventDefault();
		
		var data = new FormData($("#form-debet")[0]);
			data.append("akses", "cepat");
			
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
                $(".simpan-debet").prop("disabled", false);
                Swal.fire('Maaf!', 'Gagal Menyimpan', 'error');
            }
        }).fail(function() {
            $(".simpan-debet").prop("disabled", false);
            Swal.fire("MAAF!", "Terjadi Kesalahan, Silahkan Ulangi Kembali !!", "warning");
        });
    });

	// START ONKEYUP CARI SISWA DEBET
	function cari_siswa_debet(){
		var cari = $('input[name=norek_debet]').val();
		if(cari==''){
			$('#tempat_data_debet').html('');
			return;
		}
		$.post("{{route('dashboard-debet-cari')}}",{cari:cari},function(data){
            var html = '';
            if(data.data.length!=0){
                $.each(data.data,function(k,v){
                    html+='<a href="javascript:void(0)" onclick="pilih_siswa_debet(\''+v.no_rekening+'\')">'+v.no_rekening+' (Nama = '+v.nama_siswa+')</a><br>';
                });
            }
            $('#tempat_data_debet').html(html);
		});
		
	}

    function pilih_siswa_debet(param){
        $('#tempat_data_debet').html('');
		$.post("{{route('dashboard-debet-pilih')}}",{no_rekening:param},function(data){
            var rek = data.data.no_rekening;

            $('#norek_debet').val(rek);
		});
	}
	// END ONKEYUP CARI SISWA DEBET
	
	// START ONKEYUP CARI SISWA KREDIT
	function cari_siswa_kredit(param){
		var cari = $('input[name=norek_kredit]').val();
		if(cari==''){
			$('#tempat_data_kredit').html('');
			return;
		}
		$.post("{{route('dashboard-kredit-cari')}}",{cari:cari, param:param},function(data){
            var html = '';
            if(data.data.length!=0){
                $.each(data.data,function(k,v){
                    html+='<a href="javascript:void(0)" onclick="pilih_siswa_kredit(\''+v.no_rekening+'\')">'+v.no_rekening+' (Nama = '+v.nama_siswa+')</a><br>';
                });
            }
            $('#tempat_data_kredit').html(html);
		});
		
	}

	function pilih_siswa_kredit(param) {
		$('#tempat_data_kredit').html('');
		$.post("{{route('dashboard-kredit-pilih')}}",{no_rekening:param},function(data){
            var rek = data.data.no_rekening;

            $('#norek_kredit').val(rek);
		});
	}
	// END ONKEYUP CARI SISWA KREDIT

	$(document).ready(function() {
		$(".knob").knob()
		arrbulan = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
		date = new Date();
		hari = date.getDay();
		tanggal = date.getDate();
		bulan = date.getMonth();
		tahun = date.getFullYear();
		// document.write(tanggal+"-"+arrbulan[bulan]+"-"+tahun+"<br/>"+jam+" : "+menit+" : "+detik+"."+millisecond);

		$('#date').html(tanggal+" "+arrbulan[bulan]+" "+tahun)
	});

	function ubahFormatDebet(val){
		$('#jumlah_debet').val(formatRupiah(val.value,'Rp. '))
	}

	function ubahFormatKredit(val){
		$('#jumlah_kredit').val(formatRupiah(val.value,'Rp. '))
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
		return prefix == undefined ? rupiah : rupiah ? 'Rp. ' + rupiah : ''
	}
	
	function renderTime(){
		var currentTime = new Date();
		var h = currentTime.getHours();
		var m = currentTime.getMinutes();
		var s = currentTime.getSeconds();
		if (h == 0){
			h = 24;
		}
		if (h < 10){
			h = "0" + h;
		}
		if (m < 10){
			m = "0" + m;
		}
		if (s < 10){
			s = "0" + s;
		}
		// var myClock = document.getElementById('time');
		$('#time').html("<b>"+h+" : " + m + " : " + s + " WIB</b>");
		setTimeout ('renderTime()',1000);
	}
	
	renderTime();
</script>
@endpush