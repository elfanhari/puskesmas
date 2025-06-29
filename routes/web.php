<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PembelianBarangController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\PengambilanObatController;
use App\Http\Controllers\PermintaanBarangController;
use App\Http\Controllers\PoliController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PuskesmasController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Stmt\Return_;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Auth::loginUsingId(1); // admin
// Auth::loginUsingId(2); // petugas
// Auth::loginUsingId(3);  // dokter
// Auth::loginUsingId(4); // kepala
// Auth::logout();

Route::get('/', function () {
  return (auth()->check()) ? redirect(route('dashboard.index')) : redirect(route('login'));
})->name('home');

Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'cekLogin'])->name('login.store');

Route::middleware('auth')->group(function () {
  Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

  Route::get('/puskesmas', [PuskesmasController::class, 'index'])->name('puskesmas.index');
  Route::post('/puskesmas', [PuskesmasController::class, 'update'])->name('puskesmas.update');

  Route::prefix('user/{role}')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index');
    Route::get('/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/', [UserController::class, 'store'])->name('user.store');
    Route::get('/{user}', [UserController::class, 'show'])->name('user.show');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('user.destroy');
  });

  Route::resource('/obat', ObatController::class);
  Route::resource('/poli', PoliController::class);
  Route::resource('/pasien', PasienController::class);
  Route::get('/pasien/{pasien}/kartu-berobat', [PasienController::class, 'kartuBerobat'])->name('pasien.kartu-berobat');
  Route::resource('/pendaftaran', PendaftaranController::class);

  Route::resource('/rekam-medis', RekamMedisController::class)->parameters(['rekam-medis' => 'rekam_medis']);
  Route::get('/rekam-medis/{rekam_medis}/print', [RekamMedisController::class, 'print'])->name('rekam-medis.print');

  Route::post('/pengambilan-obat/{pengambilan_obat}/send-notif', [PengambilanObatController::class, 'sendNotif'])->name('pengambilan-obat.send-notif');
  Route::resource('/pengambilan-obat', PengambilanObatController::class);

  Route::get('/laporan/pasien', [LaporanController::class, 'laporanPasien'])->name('laporan.pasien');
  Route::get('/laporan/rekam-medis', [LaporanController::class, 'laporanRekamMedis'])->name('laporan.rekam-medis');


  Route::resource('/kategori-barang', KategoriBarangController::class);
  Route::resource('/barang', BarangController::class);

  Route::resource('/permintaan-barang', PermintaanBarangController::class);
  Route::put('/permintaan-barang/{id}/update-status', [PermintaanBarangController::class, 'updateStatus'])->name('permintaan-barang.update-status');
  Route::put('/permintaan-barang/{id}/update-feedback', [PermintaanBarangController::class, 'updateFeedback'])->name('permintaan-barang.update-feedback');

  Route::resource('/pembelian-barang', PembelianBarangController::class);
  Route::put('/pembelian-barang/{id}/update-status', [PembelianBarangController::class, 'updateStatus'])->name('pembelian-barang.update-status');
  Route::put('/pembelian-barang/{id}/update-feedback', [PembelianBarangController::class, 'updateFeedback'])->name('pembelian-barang.update-feedback');

  Route::get('/laporan/barang', [LaporanController::class, 'laporanBarang'])->name('laporan.barang');
  Route::get('/laporan/barang-keluar-masuk', [LaporanController::class, 'laporanBarangKeluarMasuk'])->name('laporan.barang-keluar-masuk');
  Route::get('/laporan/permintaan-pembelian-barang', [LaporanController::class, 'laporanPermintaanPembelian'])->name('laporan.permintaan-pembelian');

  Route::prefix('/profile')->group(function () {
    Route::get('/show', [ProfileController::class, 'index'])->name('profile.show');
    Route::get('/editdata', [ProfileController::class, 'editdata'])->name('profile.editdata');
    Route::post('/editdata', [ProfileController::class, 'storeEditData'])->name('profile.editdata.update');
    Route::get('/editfoto', [ProfileController::class, 'editfoto'])->name('profile.editfoto');
    Route::post('/editfoto', [ProfileController::class, 'storeEditFoto'])->name('profile.editfoto.update');
  });
});
