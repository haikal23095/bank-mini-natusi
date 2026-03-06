<!DOCTYPE html>
<html>
<head>
	<style type="text/css" media="print">
		.nomor{
			min-height: 10px;
		}
		#no_rekening {
		    margin-left: 11rem;
		    margin-top: 130px;
		}
		#nama_siswa {
		    margin-left: 11rem;
		    margin-top: -8px;
		}
		#nama_kelas {
		    margin-left: 11rem;
		    margin-top: -8px;
		}
		#alamat {
		    margin-left: 11rem;
		    margin-top: -8px;
		}
		#telp {
		    margin-left: 11rem;
		    margin-top: -8px;
		}
		#nik {
		    margin-left: 11rem;
		    margin-top: -8px;
		}
		@media print{
			table {
				margin-top: 4rem;
				font-size: 8pt;
				text-align: center;
				width: 60% !important;
				padding: 0;
				margin-left: 5px;
			}
		}
    </style>
</head>
<body>
	<div class="container">
		<div class="row data-siswa">
            <p id="no_rekening">{{$data->no_rekening}}</p>
            <p id="nama_siswa">{{$data->nama_siswa}}</p>
            <p id="nama_kelas">{{$data->nama_kelas}}</p>
            <p id="alamat">{{!empty($data->alamat) ? $data->alamat : ''}}</p>
            <p id="telp">{{!empty($data->no_telepon) ? $data->no_telepon : ''}}</p>
            <p id="nik">{{!empty($data->nomor_tanda_pengenal) ? $data->nomor_tanda_pengenal : ''}}</p>
		</div>
	</div>
</body>
</html>
<script>
	window.print();
</script>