<!DOCTYPE html>
<html>
<head>
	<style type="text/css" media="print">
		table {
			/* width: 30%;
			margin-top: 4rem;
			font-size: 8pt;
			text-align: center; */
			/* margin-left: -20px; */
		}
		.nomor{
			min-height: 10px;
		}
		@media print{
			table {
				margin-top: 4rem;
				font-size: 8pt;
				text-align: center;
				width: 73% !important;
				padding: 0;
				margin-left: 5px;
			}
		}
    </style>
</head>
<body>
	<?php 
		function rupiah($angka)
		{
		$hasil_rupiah = "" . number_format((int)$angka);
		$hasil_rupiah = str_replace(',', ',', $hasil_rupiah);
		return $hasil_rupiah;
		}
		
		function formatTanggal($tanggal)
		{
			return date("d/m/Y", strtotime($tanggal));
		}
	?>
	<div class="container">
		<div class="row">
			<table class="printableArea">
				@php
				$num = 1;
				@endphp
				@for($i = 0; $i < count($data); $i++)
				@php
					$tampil = $data[$i]->tampil;
				@endphp
				@if($num==17)
				<tr>
					<td style="width:10%; text-align: right;">{!! ($tampil=='ya' && ($num!=17||$num!=18)) ? $num : "<div class='nomor'></div>" !!}</td>
					<td style="width:14%;">{{ ($tampil=='ya' && ($num!=17||$num!=18)) ? formatTanggal($data[$i]->tanggal_transaksi) : '' }}</td>
					<td style="width:6%;">{{ ($tampil=='ya' && ($num!=17||$num!=18)) ? $data[$i]->sandi : '' }}</td>
					<td style="width:17%; {{ !empty($data[$i]->jumlah_debet) ? 'text-align: right;' : 'text-align: center;' }}">{{ ($tampil=='ya') ? (!empty($data[$i]->jumlah_debet) ? rupiah($data[$i]->jumlah_debet) : '') : '' }}</td>
					<td style="width:2%;"><div class='nomor'></div></td>
					<td style="width:17%; {{ !empty($data[$i]->jumlah_kredit) ? 'text-align: right;' : 'text-align: center';}}">{{ ($tampil=='ya') ? (!empty($data[$i]->jumlah_kredit) ? rupiah($data[$i]->jumlah_kredit) : '') : '' }}</td>
					<td style="width:17%; {{ !empty($data[$i]->sisa_saldo) ? 'text-align: right;' : 'text-align: center';}}">{{ ($tampil=='ya') ? (rupiah($data[$i]->sisa_saldo)) : '' }}</td>
					<td style="width:17%;">{{ ($tampil=='ya') ? (!empty($data[$i]->nama_petugas) ? $data[$i]->nama_petugas : '') : '' }}</td>
				</tr>
				<tr>
					<td style="width:10%; text-align: right;"><div class='nomor'></div></td>
					<td style="width:14%;"></td>
					<td style="width:6%;"></td>
					<td style="width:17%;"></td>
					<td style="width:2%;"><div class='nomor'></div></td>
					<td style="width:17%;"></td>
					<td style="width:17%;"></td>
					<td style="width:17%;"></td>
				</tr>
				<tr>
					<td style="width:10%; text-align: right;"><div class='nomor'></div></td>
					<td style="width:14%;"></td>
					<td style="width:6%;"></td>
					<td style="width:17%;"></td>
					<td style="width:2%;"><div class='nomor'></div></td>
					<td style="width:17%;"></td>
					<td style="width:17%;"></td>
					<td style="width:17%;"></td>
				</tr>
				@else
				<tr>
					<td style="width:10%; text-align: right;">{!! ($tampil=='ya' && ($num!=17||$num!=18)) ? $num : "<div class='nomor'></div>" !!}</td>
					<td style="width:14%;">{{ ($tampil=='ya' && ($num!=17||$num!=18)) ? formatTanggal($data[$i]->tanggal_transaksi) : '' }}</td>
					<td style="width:6%;">{{ ($tampil=='ya' && ($num!=17||$num!=18)) ? $data[$i]->sandi : '' }}</td>
					<td style="width:17%; {{ !empty($data[$i]->jumlah_debet) ? 'text-align: right;' : 'text-align: center;' }}">{{ ($tampil=='ya') ? (!empty($data[$i]->jumlah_debet) ? rupiah($data[$i]->jumlah_debet) : '') : '' }}</td>
					<td style="width:2%;"><div class='nomor'></div></td>
					<td style="width:17%; {{ !empty($data[$i]->jumlah_kredit) ? 'text-align: right;' : 'text-align: center';}}">{{ ($tampil=='ya') ? (!empty($data[$i]->jumlah_kredit) ? rupiah($data[$i]->jumlah_kredit) : '') : '' }}</td>
					<td style="width:17%; {{ !empty($data[$i]->sisa_saldo) ? 'text-align: right;' : 'text-align: center';}}">{{ ($tampil=='ya') ? (rupiah($data[$i]->sisa_saldo)) : '' }}</td>
					<td style="width:17%;">{{ ($tampil=='ya') ? (!empty($data[$i]->nama_petugas) ? $data[$i]->nama_petugas : '') : '' }}</td>
				</tr>
				@endif	
				@php
					$num++;
				@endphp
				@endfor
			</table>
		</div>
	</div>
</body>
</html>
<script src="{{url('assets/js/jquery.min.js')}}"></script>
<script src="{{ asset('assets/js/printThis.js') }}"></script>
<script>
	window.print();
</script>