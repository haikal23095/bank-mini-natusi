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
    #simpan{
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
                    <h5>Tambah Pengguna</h5>
                </div>
                <div class="card-body">
                    <input type="hidden" name="id" id="id" value="{{ !empty($user) ? $user->id : ''}}">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="">Nama Pengguna</label>
                            <input type="text" name="nama" id="nama" class="form-control" value="{{ !empty($user->name) ? $user->name : ''}}" autocomplete="off">
                        </div>
                        <div class="col-md-6">
                            <label for="">Level User</label>
                            <select name="level" id="level" class="form-control" autocomplete="off">
                                <option value=""> - pilih level user -</option>
                                <option @if (!empty($user->level) && $user->level == 'admin') selected @endif value="admin">Admin</option>
                                <option @if (!empty($user->level) && $user->level == 'operator') selected @endif value="operator">Operator</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="">Email</label>
                            <input type="text" name="email" id="email" class="form-control" value="{{ !empty($user->email) ? $user->email : ''}}" autocomplete="off">
                        </div>
                        <div class="col-md-4">
                            <label for="">Username</label>
                            <input type="text" name="username" id="username" class="form-control" value="{{ !empty($user->username) ? $user->username : ''}}" autocomplete="off">
                        </div>
                        <div class="col-md-4">
                            <label for="">Password</label>
                            <input type="text" name="password" id="password" class="form-control" value="{{ !empty($user->lihat_password) ? $user->lihat_password : ''}}" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-debet mb-2" style="width: 100%" id="simpan">SIMPAN</button>
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
    $('.datepicker').pickadate({
		selectMonths: true,
		selectYears: true
        // getFullYear: true
	})

    $('#simpan').click(function  (e) { 
        e.preventDefault();

        var data = new FormData($("#form-data")[0]);
        var nama = $('#nama').val();
        var email = $('#email').val();
        var username = $('#username').val();
        var password = $('#password').val();
        var level = $('#level').val();

        if (!nama) {
            Swal.fire('Whooops','Nama Pengguna Tidak Boleh Kosong!','warning');
        } else if(!email) {
            Swal.fire('Whooops','Email Tidak Boleh Kosong!','warning');
        } else if (!username) {
            Swal.fire('Whooops','Username Tidak Boleh Kosong!','warning');
        } else if (!password) {
            Swal.fire('Whooops','Password Tidak Boleh Kosong!','warning');
        }  else if(!level) {
            Swal.fire('Whooops','Level User Tidak Boleh Kosong!','warning');
        } else {
            $.ajax({
                url : "{{route('save-pengguna')}}",
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

    $('.btnKembali').click(()=>{
		$('.other-page').fadeOut(function(){
			hideForm()
		})
	})
</script>