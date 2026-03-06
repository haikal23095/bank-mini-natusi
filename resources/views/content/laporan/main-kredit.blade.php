@extends('layout.main')

@push('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link href="{{asset('assets/plugins/datetimepicker/css/classic.css')}}" rel="stylesheet">
<link href="{{asset('assets/plugins/datetimepicker/css/classic.date.css')}}" rel="stylesheet">
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

		<div class="row main-layer">
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
                                    <option value="nama_kelas"> Nama Kelas</option>
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
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-6">
                                <span>TOTAL KREDIT :</span>
                            </div>
                            <div class="col-md-6">
                                <div class="card text-white bg-primary">
                                    <span id="totalKredit"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <a href="javascript:void(0)" onclick="exportLapKredit()" id="exportButton" style="color: #000">
                            <span><i style="color: #829460;" class='bx bxs-file-export bx-xs'></i> Export to excel</span>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="table-responsive">
                        <table id="datatabel" class="table table-striped table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <td class="text-center">NO</td>
                                    <td class="text-center">NAMA NASABAH (SISWA)</td>
                                    <td class="text-center">NOMOR REKENING</td>
                                    <td class="text-center">JUMLAH KREDIT</td>
                                    <td class="text-center">SANDI</td>
                                    <td class="text-center">TANGGAL</td>
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
    function loadTable(filterBy, filter = '', startDate = '', endDate = ''){
        var table = $('#datatabel').DataTable({
            scrollX: true,
            searching: false, 
            ordering: false,
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
                url: "{{route('lap-kredit')}}",
                data: {
                    startDate: startDate,
                    endDate: endDate,
                    filter: filter,
                    filterBy: filterBy
                }
            },
            columns: [
                { data: "DT_RowIndex", name: "DT_RowIndex"},
                { data: "nama_siswa", name: "nama_siswa"},
                { data: "no_rekening", name: "no_rekening"},
                { data: "format", name: "format"},
                { data: "sandi", name: "sandi"},
                { data: "tanggal_transaksi", name: "tanggal_transaksi"},
                { data: "actions", name: "actions"},
            ],
        })

        table.on('xhr', function() {
            var tKredit = table.ajax.json().tKredit;
            $('#totalKredit').text(formatRupiah(tKredit, 'Rp. '));
        });
    }

    // SEARCH
    function searchData() {
        $('.btn_cari').attr('disabled', true);
        var startDate = $('#min').val(); // range awal tanggal
        var endDate = $('#max').val(); // range akhir tanggal
        var filter = $('#filter').val(); // value inputan search
        var filterBy = $('#filterBy').val(); // value select filter
        if (filterBy && filter && startDate && endDate) {
            $('#datatabel').DataTable().destroy();
            loadTable(filterBy, filter, startDate, endDate);
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

    // EDIT
    function editData(id) {
        $('.main-layer').hide();
        $.post("{{route('editLapKredit')}}", {id:id})
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

    // DELETE
    function deleteData(id) {
        Swal.fire({
            title: 'Apakah Kamu Yakin?',
            text: "Data Transaksi Akan Dihapus Permanen",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus'
            }).then((result) => {
            if (result.isConfirmed) {
                $.post("{{route('deleteLapKredit')}}",{id:id})
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

    // EXPORT
    function exportLapKredit() {
        var startDate = $('#min').val();
        var endDate = $('#max').val();
        var filter = $('#filter').val();
        var filterBy = $('#filterBy').val();
        if (filter && filterBy && startDate && endDate) {
            if (startDate <= endDate) {
                $.post("{!! route('exportLapKredit') !!}", {
                    startDate: startDate,
                    endDate: endDate,
                    filter: filter,
                    filterBy: filterBy
                }, function(data) {
                    var newWin = window.open('', 'Print-Window');
                    newWin.document.open();
                    newWin.document.write(
                        '<html><head><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css"></head><body>' +
                        data.content + '</body></html>');
                    setTimeout(() => {
                        newWin.document.close();
                        newWin.close();
                    }, 3000);
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Whoops',
                    text: 'Tanggal Tidak Sesuai!',
                    showConfirmButton: false,
                    timer: 1200
                });
            }
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Whoops',
                text: 'Tanggal Belum Dipilih!',
                showConfirmButton: false,
                timer: 1200
            });
        }
    }

    function hideForm(){
        $('.other-page').empty()
        $('.main-layer').show()
    }

    function formatRupiah(angka, prefix) {
        var number_string = angka.toString().replace(/[^,\d]/g, "");
        split = number_string.split(",");
        sisa = split[0].length % 3;
        rupiah = split[0].substr(0, sisa);
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
        }

        rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
        return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
    }
</script>
@endpush