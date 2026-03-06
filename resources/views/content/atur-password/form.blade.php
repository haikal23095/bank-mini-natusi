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

@section('content')
	<div class="page-content">
		@include('include.breadcrumb')

        <form id="form-data" class="card">
            <div class="card-header">Atur Password</div>
            <div class="card-body">
                <input type="hidden" name="id" id="id" value="{{Auth::User()->id}}">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="">Password Sekarang</label>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group" id="show_hide_password_sekarang">
                            <input type="password" class="form-control border-end-0" id="inputChoosePassword" name="password_sekarang" value="{{Auth::User()->lihat_password}}" placeholder="Masukkan Password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="">Password Baru</label>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group" id="show_hide_password_baru">
                            <input type="password" class="form-control border-end-0" id="inputChoosePassword" name="password_baru" placeholder="********"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="">Ulangi Password Baru</label>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group" id="show_hide_password_baru_ulang">
                            <input type="password" class="form-control border-end-0" id="inputChoosePassword" name="password_baru_ulang" placeholder="********"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="col-md-12">
                    <button type="button" class="btn btn-debet mb-2" style="width: 100%" id="simpan"> SIMPAN PERUBAHAN </button>
                    <button type="button" class="btn btn-kembali" id="kembali" style="width: 100%" onclick="alert('Tombol Kembali belum ada aksi')"> KEMBALI </button>
                </div>
            </div>
        </form>
	</div>
@endsection

@push('script')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{url('assets/plugins/jquery-knob/jquery.knob.js')}}"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$(".knob").knob()

        $("#show_hide_password_sekarang a").on('click', function (event) {
            event.preventDefault();
            if ($('#show_hide_password_sekarang input').attr("type") == "text") {
                $('#show_hide_password_sekarang input').attr('type', 'password');
                $('#show_hide_password_sekarang i').addClass("bx-hide");
                $('#show_hide_password_sekarang i').removeClass("bx-show");
            } else if ($('#show_hide_password_sekarang input').attr("type") == "password") {
                $('#show_hide_password_sekarang input').attr('type', 'text');
                $('#show_hide_password_sekarang i').removeClass("bx-hide");
                $('#show_hide_password_sekarang i').addClass("bx-show");
            }
        });

        $("#show_hide_password_baru a").on('click', function (event) {
            event.preventDefault();
            if ($('#show_hide_password_baru input').attr("type") == "text") {
                $('#show_hide_password_baru input').attr('type', 'password');
                $('#show_hide_password_baru i').addClass("bx-hide");
                $('#show_hide_password_baru i').removeClass("bx-show");
            } else if ($('#show_hide_password_baru input').attr("type") == "password") {
                $('#show_hide_password_baru input').attr('type', 'text');
                $('#show_hide_password_baru i').removeClass("bx-hide");
                $('#show_hide_password_baru i').addClass("bx-show");
            }
        });

        $("#show_hide_password_baru_ulang a").on('click', function (event) {
            event.preventDefault();
            if ($('#show_hide_password_baru_ulang input').attr("type") == "text") {
                $('#show_hide_password_baru_ulang input').attr('type', 'password');
                $('#show_hide_password_baru_ulang i').addClass("bx-hide");
                $('#show_hide_password_baru_ulang i').removeClass("bx-show");
            } else if ($('#show_hide_password_baru_ulang input').attr("type") == "password") {
                $('#show_hide_password_baru_ulang input').attr('type', 'text');
                $('#show_hide_password_baru_ulang i').removeClass("bx-hide");
                $('#show_hide_password_baru_ulang i').addClass("bx-show");
            }
        });
	});

    // SIMPAN
    $('#simpan').click(function (e) { 
        e.preventDefault();
        var data = new FormData($("#form-data")[0]);

        $.ajax({
            url : "{{route('save-password')}}",
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
                        if(name=='password_sekarang'){name='Password Sekarang'}
                        else if(name=='password_baru'){name='Password Baru'}
                        else if(name=='password_baru_ulang'){name='Ulangi Password Baru'}
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
    }); 
</script>
@endpush