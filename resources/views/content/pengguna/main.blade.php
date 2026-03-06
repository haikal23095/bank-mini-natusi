@extends('layout.main')

@push('style')
<link href="{{asset('assets/plugins/datetimepicker/css/classic.css')}}" rel="stylesheet">
<link href="{{asset('assets/plugins/datetimepicker/css/classic.date.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<style>
    .table-responsive > .dataTables_wrapper > .row {
			margin-top: 0px !important;
    }
    .btn i {
        margin-right: 0px !important;
    }
</style>
@endpush

@section('content')
	<div class="page-content">
		@include('include.breadcrumb')
        <div class="card main-layer">
            <div class="card-body">
                <div class="row mb-3" style="margin-top: 1rem">
                    <div class="col-md-3">
                        <button type="button" class="btn btn-primary btn-sm" onclick="formAdd()"><i class="bx bxs-user"></i> TAMBAH PENGGUNA</button>
                    </div>
                    <div class="col-md-5"></div>
                    <div class="col-md-3"></div>
                </div>
                <div class="row" style="margin-top: 2rem">
                    <div class="table-responsive">
                        <table id="datatabel" class="table table-striped table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <td>NO</td>
                                    <td>NAMA</td>
                                    <td>USERNAME</td>
                                    <td>EMAIL</td>
                                    <td>SEBAGAI</td>
                                    <td>AKSI</td>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="other-page"></div>
	</div>
@endsection

@push('script')
<script src="{{url('assets/plugins/jquery-knob/jquery.knob.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('assets/plugins/datetimepicker/js/picker.js')}}"></script>
<script src="{{asset('assets/plugins/datetimepicker/js/picker.date.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
	$(document).ready(function() {
		$(".knob").knob();
        loadTable();
	});

    // DATATABLE
    function loadTable(){
        var table = $('#datatabel').DataTable({
            scrollX: true,
            searching: true, 
            paging: true,
            processing: true,
            serverSide: true,
            columnDefs: [
                {
                    sortable: false,
                    'targets': [0]
                }, {
                    searchable: false,
                    'targets': [0]
                },
            ],
            ajax: {
                url: "{{route('main-pengguna')}}",
            },
            columns: [
                { data: "DT_RowIndex", name: "DT_RowIndex"},
                { data: "name", name: "name"},
                { data: "username", name: "username"},
                { data: "email", name: "email"},
                { data: "level", name: "level"},
                { data: "actions", name: "actions", class: "text-center"},
            ],
        })
    }

    function formAdd(id='') {
        $('.main-layer').hide();
        $.post("{{route('form-pengguna')}}", {id:id})
        .done(function(data){
			if(data.status == 'success'){
				$('.other-page').html(data.content).fadeIn();
			} else {
				$('.main-layer').show();
			}
		})
        .fail(() => {
            $('.other-page').empty();
            $('.main-layer').show();
        })
    }

    function hapus(id) {
        Swal.fire({
            title: 'Apakah Kamu Yakin?',
            text: "Data Pengguna Akan Dihapus Permanen",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus'
            }).then((result) => {
            if (result.isConfirmed) {
                $.post("{{route('delete-pengguna')}}",{id:id})
                .done((data) => {
                    if(data.status == "success"){
                        Swal.fire('Berhasil!', 'Berhasil Menghapus Data', 'success');
                        location.reload();
                    }else{
                        Swal.fire('Maaf!', 'Gagal Menghapus Data', 'error');
                    }
                }).fail(() => {
                    Swal.fire('Maaf!', 'Terjadi Kesalahan!', 'warning');
                })
            }
        })
       
    }

    function hideForm(){
        $('.other-page').empty()
        $('.main-layer').show()
    }
</script>
@endpush