<?php

use Illuminate\Support\Facades\Route;
// For Admin
use App\Http\Controllers\PakController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminArsipController;
use App\Http\Controllers\Admin\AdminPrintController;
use App\Http\Controllers\Admin\AdminGrafikController;
use App\Http\Controllers\Admin\AdminJadwalController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminProfileController;
// For Operator
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminPrintArsipController;
use App\Http\Controllers\Admin\AdminSubKegiatanController;
use App\Http\Controllers\Operator\OperatorArsipController;
use App\Http\Controllers\Operator\OperatorPrintController;
use App\Http\Controllers\Operator\OperatorGrafikController;
use App\Http\Controllers\Operator\OperatorJadwalController;
use App\Http\Controllers\Operator\OperatorReportController;
use App\Http\Controllers\Operator\OperatorProfileController;
use App\Http\Controllers\Operator\OperatorDashboardController;
use App\Http\Controllers\Operator\OperatorSubKegiatanController;

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

Route::get('/', function () {
    return view('login');
})->name('login');

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/logout', 'logout');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/pak', [PakController::class, 'pak']);
    Route::post('/todashboard', [PakController::class, 'redirect']);
    Route::post('/perubahan/pak', [PakController::class, 'perubahan']);

    // Route for admin
    Route::middleware(['admin'])->group(function () {
        Route::prefix('admin')->group(function () {
            Route::controller(AdminDashboardController::class)->group(function () {
                Route::get('/dashboard', 'index')->name('admin.dashboard');
                Route::get('/grafik-kg', 'kegiatan')->name('dashboard-data-kg');
                Route::get('/grafik-ku', 'keuangan')->name('dashboard-data');
            });
            Route::controller(AdminUserController::class)->group(function () {
                Route::get('/users', 'index');
                Route::get('/user/create', 'create');
                Route::post('/user/store', 'store');
                Route::get('/user/edit/{id}', 'edit');
                Route::patch('/user/update/{id}', 'update');
                Route::delete('/user/destroy/{id}', 'destroy');
                Route::get('/users/export', 'export');
            });
            Route::controller(AdminSubKegiatanController::class)->group(function () {
                Route::get('/subkegiatan', 'index');
                Route::get('/subkegiatan/export', 'export');
            });
            Route::controller(AdminJadwalController::class)->group(function () {
                Route::get('/jadwal', 'index');
            });
            Route::controller(AdminReportController::class)->group(function () {
                Route::get('/report', 'index');
                Route::get('/rekapitulasi', 'rekapitulasi');
            });
            Route::controller(AdminGrafikController::class)->group(function () {
                Route::get('/grafik/pengadaan', 'indexPengadaan');
                Route::get('/grafik/pengadaanData', 'pengadaanData');
                Route::get('/grafik/sebaran', 'indexSebaran');
                Route::get('/grafik/sebaranData', 'sebaranData');
                Route::get('/grafik/sumberDana', 'indexsumberDana');
                Route::get('/grafik/sumberDanaData', 'sumberDanaData');
                Route::get('/grafik/pelaksanaan', 'indexPelaksanaan');
                Route::get('/grafik/pelaksanaanData', 'pelaksanaanData');
                Route::get('/laporan', 'laporan');
                Route::get('/realisasi', 'realisasi');
                Route::get('/grafik/ranking', 'ranking');
                Route::get('/grafik/rankingData', 'rankingData');
            });
            Route::controller(AdminArsipController::class)->group(function () {
                Route::get('/arsip/rfk', 'index');
                Route::post('/arsip/print/cover', 'cover');
                Route::post('/arsip/print/jadwal', 'jadwal');
                Route::post('/arsip/print/rfk', 'rfk');
                Route::post('/arsip/print/grafik', 'grafik');
            });
            // For Print
            Route::controller(AdminPrintController::class)->group(function () {
                Route::get('/print/dau', 'dau');
                Route::get('/print/dak', 'dak');
                Route::get('/print/dbhc', 'dbhc');
                Route::get('/print/kontruksi', 'kontruksi');
                Route::get('/print/barang', 'barang');
                Route::get('/print/konsultansi', 'konsultansi');
                Route::get('/print/lainnya', 'lainnya');
                Route::get('/print/prioritas', 'prioritas');
                Route::get('/print/kendala', 'kendala');
            });
            // For Print Arsip All opd
            Route::controller(AdminPrintArsipController::class)->group(function () {
                Route::get('/print/arsip/cover', 'cover');
                Route::get('/print/arsip/jadwal', 'jadwal');
                Route::get('/print/arsip/rfk', 'rfk');
                Route::get('/print/arsip/grafik', 'grafik');
            });
            // For Profile
            Route::controller(AdminProfileController::class)->group(function () {
                Route::get('/profile/{id}', 'index');
                Route::patch('/profile/update/{id}', 'update');
            });
        });
    });
    // Route for operator
    Route::middleware(['operator'])->group(function () {
        Route::prefix('operator')->group(function () {
            Route::controller(OperatorDashboardController::class)->group(function () {
                Route::get('/dashboard', 'index')->name('operator.dashboard');
                Route::get('/grafik-kg', 'kegiatan');
                Route::get('/grafik-ku', 'keuangan');
            });
            Route::controller(OperatorSubKegiatanController::class)->group(function () {
                Route::get('/subkegiatan', 'index');
                Route::get('/subkegiatan/create', 'create');
                Route::post('/subkegiatan/store', 'store');
                Route::get('/subkegiatan/edit/{id}', 'show');
                Route::patch('/subkegiatan/update/{id}', 'update');
                Route::delete('/subkegiatan/destroy/{id}', 'destroy');
                Route::post('/perubahan', 'perubahan');
            });
            Route::controller(OperatorJadwalController::class)->group(function () {
                Route::get('/jadwal', 'index');
                Route::get('/jadwal/edit/lokasi/{id}', 'lokasi');
                Route::post('/jadwal/edit/lokasi/store', 'lokasiStore');
                Route::delete('/jadwal/edit/lokasi/destroy/{id}', 'lokasiDestroy');
                Route::get('/jadwal/edit/volume/{id}', 'volume');
                Route::post('/jadwal/edit/volume/store/{id}', 'volumeStore');
                Route::get('/jadwal/edit/pptk/{id}', 'pptk');
                Route::post('/jadwal/edit/pptk/store/{id}', 'pptkStore');
                Route::post('/jadwal/edit/userpptk/store/{id}', 'userpptkStore');
                Route::post('/jadwal/edit/userpptk/update', 'userpptkUpdate');
                Route::delete('/jadwal/edit/userpptk/destroy/{id}', 'userpptkDestroy');
                Route::get('/jadwal/edit/target/{id}', 'target');
                Route::post('/jadwal/edit/target/store/{id}', 'targetStore');
            });
            Route::controller(OperatorReportController::class)->group(function () {
                Route::get('/realisasi', 'index');
                Route::post('/realisasi/store', 'store');
                Route::get('/rekapitulasi', 'rekapitulasi');
            });
            Route::controller(OperatorGrafikController::class)->group(function () {
                Route::get('/grafik/pengadaan', 'indexPengadaan');
                Route::get('/grafik/pengadaanData', 'pengadaanData');
                Route::get('/grafik/sebaran', 'indexSebaran');
                Route::get('/grafik/sebaranData', 'sebaranData');
                Route::get('/grafik/sumberDana', 'indexsumberDana');
                Route::get('/grafik/sumberDanaData', 'sumberDanaData');
                Route::get('/grafik/pelaksanaan', 'indexPelaksanaan');
                Route::get('/grafik/pelaksanaanData', 'pelaksanaanData');
                // For laporan
                Route::get('/laporan', 'laporan');
            });
            Route::controller(OperatorArsipController::class)->group(function () {
                Route::get('/arsip/rfk', 'index');
                Route::post('/arsip/print/cover', 'cover');
                Route::post('/arsip/print/jadwal', 'jadwal');
                Route::post('/arsip/print/rfk', 'rfk');
                Route::post('/arsip/print/grafik', 'grafik');
            });
            // For Print
            Route::controller(OperatorPrintController::class)->group(function () {
                Route::get('/print/dau', 'dau');
                Route::get('/print/dak', 'dak');
                Route::get('/print/dbhc', 'dbhc');
                Route::get('/print/kontruksi', 'kontruksi');
                Route::get('/print/barang', 'barang');
                Route::get('/print/konsultansi', 'konsultansi');
                Route::get('/print/lainnya', 'lainnya');
                Route::get('/print/prioritas', 'prioritas');
                Route::get('/print/kendala', 'kendala');
            });
            // For Profile
            Route::controller(OperatorProfileController::class)->group(function () {
                Route::get('/profile/{id}', 'index');
                Route::patch('/profile/update/{id}', 'update');
            });
        });
    });
});
