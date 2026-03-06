@extends('layout.main')

@push('style')
<link href="{{asset('assets/plugins/datetimepicker/css/classic.css')}}" rel="stylesheet">
<link href="{{asset('assets/plugins/datetimepicker/css/classic.date.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<style>
    .btn_cari {
        background: #D9ACF5;
    }
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
                    <div class="col-md-3" style="margin-left: 25px">
                        <button type="button" class="btn btn-primary btn-sm" onclick="formAdd()"><i class="bx bxs-plus-square"></i> TAMBAH NASABAH (SISWA)</button>
                    </div>
                    <div class="col-md-5"></div>
                    <div class="col-md-3"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12 text-center">
                        <div class="row">
                            <div class="col-md-2" style="margin-top: 10px;">
                                <span >Filter Pencarian</span>
                            </div>
                            <div class="col-md-3">
                                <select name="filterBy" id="filterBy" class="form-control" style="border-radius: 10px !important">
                                    <option value="">- Pilih Filter Pencarian -</option>
                                    <option value="nama_siswa">Nama Nasabah (Siswa)</option>
                                    <option value="nama_kelas">Nama Kelas / Jurusan</option>
                                </select>
                            </div>
                            {{-- <div class="col-md-2"> --}}
                                {{-- <input type="text" name="filter" id="filter" class="form-control" style="width: 100%; border-radius: 10px !important" placeholder="Nama"> --}}
                            {{-- </div> --}}
                            {{-- <div class="col-md-2 twodate"> --}}
                                {{-- <input type="date" id="min" class="form-control"> --}}
                            {{-- </div> --}}
                            <div class="col-md-4 twodate">
                                {{-- <input type="date" id="max" class="form-control"> --}}
                                <input type="text" name="filter" id="filter" class="form-control" style="width: 100%; border-radius: 10px !important" placeholder="Nama / Nama Kelas" autocomplete="off">
                            </div>
                            <div class="col-md-1">
                                <button type="button" name="btn_cari" id="btn_cari" class="btn btn_cari" style="width: 100%" onclick="searchData()">Cari</button>
                            </div>
                            <div class="col-md-1">
                                <button type="button" name="btn_refresh" id="btn_refresh" class="btn refresh" style="background-color: thistle" onclick="refresh()">Refresh</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 2rem">
                    <div class="table-responsive">
                        <table id="datatabel" class="table table-striped table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <td>NO</td>
                                    <td>NO REKENING</td>
                                    <td>NAMA SISWA</td>
                                    <td>KELAS</td>
                                    <!--<td>TANGGAL REGISTRASI</td>-->
                                    <td>SALDO</td>
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
        $('.select2').select2();

        loadTable();
	});

    // DATATABLE
    // function loadTable(filter = '', startDate = '', endDate = ''){
    function loadTable(filterBy='', filter = ''){
        var table = $('#datatabel').DataTable({
            scrollX: true,
            searching: false, 
            // paging: false,
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
                url: "{{route('main-siswa')}}",
                data: {
                    filterBy: filterBy,
                    filter: filter,
                }
            },
            columns: [
                { data: "DT_RowIndex", name: "DT_RowIndex"},
                { data: "no_rekening", name: "no_rekening"},
                { data: "nama_siswa", name: "nama_siswa"},
                { data: "nama_kelas", name: "nama_kelas"},
                // { data: "registrasi", name: "registrasi"},
                { data: "format", name: "format"},
                { data: "actions", name: "actions", class: "text-center"},
            ],
        })
    }

    function formAdd(id='') {
        $('.main-layer').hide();
        $.post("{{route('form-siswa')}}", {id:id})
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

    function detail(id) {
        $(".main-layer").hide();

        $.post("{{route('detail-siswa')}}",{id:id})
        .done((data) => {
            if(data.status == "success"){
                $(".other-page").html(data.content).fadeIn();
            }else{
                $(".other-page").empty();
                $(".main-layer").show();
            }
        }).fail(() => {
            $(".other-page").empty();
            $(".main-layer").show();
        })
    }

    function hapus(id) {
        Swal.fire({
            title: 'Apakah Kamu Yakin?',
            text: "Data Siswa Dan Transaksi Akan Dihapus Permanen",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus'
            }).then((result) => {
            if (result.isConfirmed) {
                $.post("{{route('delete-siswa')}}",{id:id})
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

    function searchData() {
        $('.btn_cari').attr('disabled', true);
        var filterBy = $('#filterBy').val(); // value option search
        var filter = $('#filter').val(); // value inputan search
        if (filterBy && filter) {
            $('#datatabel').DataTable().destroy();
            loadTable(filterBy, filter);
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Whoops',
                text: 'Pencarian Atau Tanggal Belum Dipilih!',
                showConfirmButton: false,
                timer: 1000
            });
        }
        $('.btn_cari').attr('disabled', false);
    }

    function refresh() {
        $('#filterBy').val('');
        $('#filter').val('');
        $('#datatabel').DataTable().destroy();
        loadTable();
    }

    function hideForm(){
        $('.other-page').empty()
        $('.main-layer').show()
    }
</script>
@endpush