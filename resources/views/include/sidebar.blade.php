<div class="sidebar-wrapper" data-simplebar="true">
	<div class="sidebar-header">
		<div class="header-image">
			<img src="{{ url('assets/images/login-images/logo.png')}}" width="40%">
		</div>
		<div class="header-text">
			<div class="logo-text">
				<h5 style="color: #ffffff; font-size: 10pt"><b>CV NATUSI</b></h5>
				<h5 style="color: #ffffff; font-size: 8pt;">BANK MINI</h5>
			</div>
		</div>
	</div>
	<div class="sidebar-header-profile text-center">
		<div class="header-profile">	
			<img class="rounded-circle" src="{{ asset('assets/images/avatar.png')}}" width="70"/><br>
			<span style="font-size: 14pt;">{{Auth::User()->name}}</span><br>
			<span>PENGELOLA KEUANGAN</span><br>
			<a href="{{route('logout')}}">Sign Out</a>
			<hr>
		</div>
	</div>
	<!--navigation-->
	<ul class="metismenu" id="menu">
		@if (Auth::User()->level=='admin')
		<!-- DASHBOARD -->
		<span style="color: #000;">DASHBOARD</span>
		<li class="{{ ($title == 'Dashboard') ? 'mm-active' : ''}}">
			<a href="{{route('dashAdmin')}}">
				<div class="parent-icon">
					<img src="{{ asset('assets/icon-sidebar/dashboard.svg') }}" alt="dashboard SVG"/>
					{{-- <i class='bx bx-home-circle'></i> --}}
				</div>
				<div class="menu-title">Dashboard</div>
			</a>
		</li>
		@endif
		<li class="{{ ($title == 'Debet') ? 'mm-active' : ''}}">
			<a href="{{route('form-debet')}}">
				<div class="parent-icon">
					<img src="{{ asset('assets/icon-sidebar/debet.svg') }}" alt="debet SVG"/>
					{{-- <i class='bx bx-credit-card-front'></i> --}}
				</div>
				<div class="menu-title">Debet</div>
			</a>
		</li>
		<li class="{{ ($title == 'Kredit') ? 'mm-active' : ''}}">
			<a href="{{route('form-kredit')}}">
				<div class="parent-icon">
					<img src="{{ asset('assets/icon-sidebar/kredit.svg') }}" alt="kredit SVG"/>
					{{-- <i class='bx bx-credit-card'></i> --}}
				</div>
				<div class="menu-title">Kredit</div>
			</a>
		</li>

		@if (Auth::User()->level=='admin')
		<!-- DATA MASTER -->
		<span style="color: #000;">DATA MASTER</span>
		<li class="{{ ($title == 'Data Nasabah (Siswa)') ? 'mm-active' : ''}}">
			<a href="{{route('main-siswa')}}">
				<div class="parent-icon">
					<img src="{{ asset('assets/icon-sidebar/master.svg') }}" alt="master SVG"/>
				</div>
				<div class="menu-title">Data Nasabah (Siswa)</div>
			</a>
		</li>
		<li class="{{ ($title == 'Data Pengguna') ? 'mm-active' : ''}}" style="margin-left: -5px">
			<a href="{{route('main-pengguna')}}">
				<div class="parent-icon">
					<i class="bx bxs-user" style="color: #000"></i>
				</div>
				<div class="menu-title">Data Pengguna</div>
			</a>
		</li>

		<!-- LAPORAN -->
		<span style="color: #000;">LAPORAN</span>
		<li class="{{ ($title == 'Laporan Debet') ? 'mm-active' : ''}}">
			<a href="{{route('lap-debet')}}">
				<div class="parent-icon">
					<img src="{{ asset('assets/icon-sidebar/laporan.svg') }}" alt="laporan SVG"/>
				</div>
				<div class="menu-title">Lap. Debet</div>
			</a>
		</li>
		<li class="{{ ($title == 'Laporan Kredit') ? 'mm-active' : ''}}">
			<a href="{{route('lap-kredit')}}">
				<div class="parent-icon">
					<img src="{{ asset('assets/icon-sidebar/laporan.svg') }}" alt="laporan SVG"/>
				</div>
				<div class="menu-title">Lap. Kredit</div>
			</a>
		</li>
		@endif
		<li class="{{ ($title == 'Rek. Koran') ? 'mm-active' : ''}}">
			<a href="{{route('main-rek-siswa')}}">
				<div class="parent-icon">
					<img src="{{ asset('assets/icon-sidebar/laporan.svg') }}" alt="laporan SVG"/>
				</div>
				<div class="menu-title">Rek. Koran</div>
			</a>
		</li>
		@if(Auth::User()->level=='admin')
		<!-- PENGATURAN -->
		<span style="color: #000;">PENGATURAN</span>
		<li class="{{ ($title == 'Pengaturan') ? 'mm-active' : ''}}">
			<a href="{{route('pengaturan')}}">
				<div class="parent-icon">
					<img src="{{ asset('assets/icon-sidebar/pengaturan.svg') }}" alt="pengaturan SVG"/>
					{{-- <i class='bx bx-cog'></i> --}}
				</div>
				<div class="menu-title">Pengaturan</div>
			</a>
		</li>
		<li class="{{ ($title == 'Atur Password') ? 'mm-active' : ''}}">
			<a href="{{route('atur-password')}}">
				<div class="parent-icon">
					<img src="{{ asset('assets/icon-sidebar/password.svg') }}" alt="password SVG"/>
					{{-- <i class='bx bx-lock-alt'></i> --}}
				</div>
				<div class="menu-title">Atur Password</div>
			</a>
		</li>
		@endif
	</ul>
	<!--end navigation-->
</div>