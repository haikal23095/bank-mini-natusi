@extends('layout.main')

@push('style')
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

		<div class="row">
			<div class="col-md-12 text-center">
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
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="filter" id="filter" class="form-control" style="width: 100%; border-radius: 10px !important" placeholder="Nama" autocomplete="off">
                            </div>
                            <div class="col-md-2 twodate">
                                <input type="date" id="min" class="form-control">
                            </div>
                            <div class="col-md-2 twodate">
                                <input type="date" id="max" class="form-control">
                            </div>
                            <div class="col-md-1">
                                <button type="button" name="btn_cari" id="btn_cari" class="btn btn-primary btn_cari" onclick="searchData()" style="width: 100%">cari</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div id="cardIdentitas">
                        <div class="col-md-12" style="margin-left: 0px;">
                            <div class="row">
                                <input type="hidden" name="id_siswa" id="id_siswa">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <p>Nama</p>
                                        </div>
                                        <div class="col-md-1">
                                            :
                                        </div>
                                        <div class="col-md-6">
                                            <p id="nama" style="text-align: left"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <p>No. Rekening</p>
                                        </div>
                                        <div class="col-md-1">
                                            :
                                        </div>
                                        <div class="col-md-6">
                                            <p id="norek" style="text-align: left"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-5"></div>
                                        <div class="col-md-5"></div>
                                        <div class="col-md-2" style="margin-top: -3rem">
                                            {{-- <button type="button" class="btn btn-warning" style="width: 100%"><i class='bx bxs-printer'></i></button> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-info btn-sm text-white" style="margin-left: 20px;" onclick="cetakDataSiswa()"> CETAK DATA SISWA</button>
                                        </div>
                                        <div class="col-md-6"></div>
                                    </div>
                                </div>
                                <div class="col-md-6"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 2rem">
                    <div class="table-responsive">
                        <table id="datatabel" class="table table-striped table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <td class="text-center">NO</td>
                                    <td class="text-center">TANGGAL</td>
                                    <td class="text-center">SANDI</td>
                                    <td class="text-center">DEBET</td>
                                    <td class="text-center">KREDIT</td>
                                    <td class="text-center">SALDO</td>
                                    <td class="text-center">PENGESAHAN PETUGAS</td>
                                    <td class="text-center">AKSI</td>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
		</div>
	</div>
@endsection

@push('script')
<script src="{{url('assets/plugins/jquery-knob/jquery.knob.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
	$(document).ready(function() {
		$(".knob").knob();
        $('#cardIdentitas').hide();
        loadTable();
	});

    // DATATABLE
    function loadTable(filter = '', startDate = '', endDate = ''){
        var table = $('#datatabel').DataTable({
            scrollX: true,
            searching: false, 
            ordering: false, 
            // paging: false,
            processing: true,
            serverSide: true,
            language: {
                infoEmpty: "Data Not Available",
            },
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
                url: "{{route('main-rek-siswa')}}",
                data: {
                    startDate: startDate,
                    endDate: endDate,
                    filter: filter,
                }
            },
            columns: [
                { data: "DT_RowIndex", name: "DT_RowIndex"},
                { data: "tanggal_transaksi", name: "tanggal_transaksi"},
                { data: "sandi", name: "sandi"},
                { data: "debet", name: "debet"},
                { data: "kredit", name: "kredit"},
                { data: "saldo", name: "saldo"},
                { data: "nama_petugas", name: "nama_petugas"},
                { data: "actions", name: "actions", class: "text-center"},
            ],
        })

        table.on('xhr', function() {
            var nama = table.ajax.json().nama;
            var rekening = table.ajax.json().rekening;
            var id_siswa = table.ajax.json().id_siswa;
            $('#nama').text(nama);
            $('#norek').text(rekening);
            $('#id_siswa').val(id_siswa);
        });
    }

    function searchData() {
        $('.btn_cari').attr('disabled', true);
        var startDate = $('#min').val(); // range awal tanggal
        var endDate = $('#max').val(); // range akhir tanggal
        var filter = $('#filter').val(); // value inputan search
        if (filter && startDate && endDate) {
            $('#datatabel').DataTable().destroy();
            loadTable(filter, startDate, endDate);
            $('#cardIdentitas').show();
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

    function kembali() {
        $(".other-page").empty();
        $(".main-layer").show();
    }

    function cetak(id) {
        window.open("{{route('cetak_rek_koran')}}/"+id);
        // location.reload();
    }

    function cetakDataSiswa() {
        var id = $('#id_siswa').val();
        window.open("{{route('cetak_data_siswa')}}/"+id);
    }
</script>
@endpush