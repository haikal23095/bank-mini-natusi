<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController as Auth;
use App\Http\Controllers\DashboardController as dashAdmin;
use App\Http\Controllers\AdminController as Admin;
use App\Http\Controllers\DebetController as Debet;
use App\Http\Controllers\KreditController as Kredit;
use App\Http\Controllers\TransaksiController as Transaksi;
use App\Http\Controllers\SiswaController as Siswa;
use App\Http\Controllers\PenggunaController as Pengguna;
use App\Http\Controllers\LapDebetController as LapDebet;
use App\Http\Controllers\LapKreditController as LapKredit;
use App\Http\Controllers\RekSiswaController as RekSiswa;
use App\Http\Controllers\PengaturanController as Pengaturan;
use App\Http\Controllers\AturPasswordController as AturPassword;
use App\Http\Controllers\CetakController as Cetak;
use App\Http\Controllers\GetController as Get;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/Route::get('/clear', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('config:cache');
    return 'has been clear';
    // return what you want
});

Route::get('/', function () {
	return redirect()->route('dashAdmin');
});


// START AUTH
Route::get('login', 'App\Http\Controllers\AuthController@index')->name('login');
Route::post('proses_login', 'App\Http\Controllers\AuthController@proses_login')->name('proses_login');
Route::get('logout', 'App\Http\Controllers\AuthController@logout')->name('logout');
// END AUTH
// START DAERAH
Route::post('getKabupaten', [Get::class, 'getKabupaten'])->name('get_kabupaten');
Route::post('getKecamatan', [Get::class, 'getKecamatan'])->name('get_kecamatan');
Route::post('getDesa', [Get::class, 'getDesa'])->name('get_desa');
// END DAERAH

Route::group(['middleware' => ['auth']], function () {
	Route::group(['prefix'=>'debet'],function(){
		// DEBET
		Route::get('/form-debet', [Debet::class, 'form'])->name('form-debet');
		Route::post('/cari-siswa', [Kredit::class, 'cari'])->name('debet-cari');
		Route::post('/pilih-siswa', [Kredit::class, 'pilih'])->name('debet-pilih');
		// Route::post('/save-debet', [Debet::class, 'store'])->name('save-debet');
	});

	Route::group(['prefix'=>'transaksi'],function(){
		// TRANSAKSI
		Route::post('/save-transaksi', [Transaksi::class, 'store'])->name('save-transaksi');
	});

	Route::group(['prefix'=>'kredit'],function(){
		// KREDIT
		Route::get('/form-kredit', [Kredit::class, 'form'])->name('form-kredit');
		Route::post('/cari-siswa', [Kredit::class, 'cari'])->name('kredit-cari');
		Route::post('/pilih-siswa', [Kredit::class, 'pilih'])->name('kredit-pilih');
		// Route::post('/save-kredit', [Kredit::class, 'store'])->name('save-kredit');
	});

	Route::group(['prefix'=>'rek-koran'],function(){
		// REK KORAN
		Route::get('/', [RekSiswa::class, 'main'])->name('main-rek-siswa');
		Route::post('/cetak-rek-koran', [RekSiswa::class, 'cetak'])->name('cetak-rek-koran');
	});

    Route::group(['middleware' => ['cek_login:admin']], function () {
		Route::group(['prefix'=>'admin'],function(){
			// DASHBOARD
			Route::get('/dashboard', [dashAdmin::class, 'main'])->name('dashAdmin');
			Route::post('/dashboard/cari-siswa-debet', [dashAdmin::class, 'cariDebet'])->name('dashboard-debet-cari');
			Route::post('/dashboard/pilih-siswa-debet', [dashAdmin::class, 'pilihDebet'])->name('dashboard-debet-pilih');
			Route::post('/dashboard/cari-siswa-kredit', [dashAdmin::class, 'cariKredit'])->name('dashboard-kredit-cari');
			Route::post('/dashboard/pilih-siswa-kredit', [dashAdmin::class, 'pilihKredit'])->name('dashboard-kredit-pilih');
		});

		Route::group(['prefix'=>'siswa'],function(){
			// SISWA
			Route::get('/', [Siswa::class, 'main'])->name('main-siswa');
			Route::post('/form-siswa', [Siswa::class, 'form'])->name('form-siswa');
			Route::post('/detail-siswa', [Siswa::class, 'detail'])->name('detail-siswa');
			Route::post('/delete-siswa', [Siswa::class, 'delete'])->name('delete-siswa');
			Route::post('/save-siswa', [Siswa::class, 'store'])->name('save-siswa');
		});

		Route::group(['prefix'=>'Pengguna'],function(){
			// PENGGUNA
			Route::get('/', [Pengguna::class, 'main'])->name('main-pengguna');
			Route::post('/form-pengguna', [Pengguna::class, 'form'])->name('form-pengguna');
			Route::post('/save-pengguna', [Pengguna::class, 'store'])->name('save-pengguna');
			Route::post('/delete-pengguna', [Pengguna::class, 'delete'])->name('delete-pengguna');
		});

		Route::group(['prefix'=>'Laporan'],function(){
			// DEBET
			Route::get('/debet', [LapDebet::class, 'main'])->name('lap-debet');
			Route::post('/edit-lap-debet', [LapDebet::class, 'edit'])->name('editLapDebet');
			Route::post('/delete-lap-debet', [LapDebet::class, 'delete'])->name('deleteLapDebet');
			Route::post('/export-lap-debet', [LapDebet::class, 'export'])->name('exportLapDebet');

			// KREDIT
			Route::get('/kredit', [LapKredit::class, 'main'])->name('lap-kredit');
			Route::post('/edit-lap-kredit', [LapKredit::class, 'edit'])->name('editLapKredit');
			Route::post('/delete-lap-kredit', [LapKredit::class, 'delete'])->name('deleteLapKredit');
			Route::post('/export-la-kredit', [LapKredit::class, 'export'])->name('exportLapKredit');
		});

		Route::group(['prefix'=>'pengaturan'],function(){
			// PENGATURAN
			Route::get('/form', [Pengaturan::class, 'form'])->name('pengaturan');
			Route::post('/save-pengaturan', [Pengaturan::class, 'store'])->name('save-pengaturan');
		});

		Route::group(['prefix'=>'atur-password'],function(){
			// ATUR PASSWORD
			Route::get('/form', [AturPassword::class, 'form'])->name('atur-password');
			Route::post('/save-password', [AturPassword::class, 'store'])->name('save-password');
		});
    });

	// CETAK
	Route::group(['prefix'=>'cetak'],function(){
		// Rek. Koran
		Route::get('/rek-koran', [Cetak::class, 'cetakRekKoran'])->name('cetak_rek_koran');
		Route::get('/rek-koran/{id}', [Cetak::class, 'cetakRekKoran']);

		Route::get('/data-siswa', [Cetak::class, 'cetakDataSiswa'])->name('cetak_data_siswa');
		Route::get('/data-siswa/{id}', [Cetak::class, 'cetakDataSiswa']);
	});
});