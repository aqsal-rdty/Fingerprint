<?php

use Illuminate\Support\Facades\Route;
use App\Models\Guru;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\Auth\LoginController;
// use App\Http\Controllers\RayonController;
// use App\Http\Controllers\JurusanController;
// use App\Http\Controllers\RombelController;
use App\Http\Controllers\GuruController;
// use App\Http\Controllers\FPController;
use App\Http\Controllers\FPGController;
// use App\Http\Controllers\SiswaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserDataController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

Route::get('/excel/{nip_pegawai}', [GuruController::class, 'exportExcel'])->name('rekapkehadiran.export');
Route::get('/rekapkehadiran/{nip}', [GuruController::class, 'LihatRekap'])->name('rekapkehadiran.lihat');

Route::get('/guru/sinkronisasi', [UserDataController::class, 'sinkronguru'])->name('kehadiran.sinkron');
Route::get('/guru/sinkronguru', [UserDataController::class, 'sinkronguru'])->name('guruSinkronisasi');
Route::get('/guru/sinkron', [UserDataController::class, 'sinkronguru'])->name('guruSinkronisasi');
Route::get('/sinkronguru', [UserDataController::class, 'sinkronguru'])->name('sinkron_guru');

Route::middleware(['admin'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/guru/dashboard', [GuruController::class, 'dashboard'])->name('guru.dashboard');

    Route::get('/guru/kehadiran', [UserDataController::class, 'indexguru'])->name('guru.kehadiran');
    Route::get('/kehadiran/refresh', [UserDataController::class, 'refreshKehadiran'])->name('kehadiran.refresh');
    Route::get('/guru/sinkron', [UserDataController::class, 'sinkronguru'])->name('guruSinkronisasi');
    Route::get('/sinkronguru', [UserDataController::class, 'sinkronguru'])->name('sinkron_guru');
    Route::get('/guru/rekap-bulan', [UserDataController::class, 'rekapBulan'])->name('guru.rekapbulanan');

    Route::prefix('guru')->middleware(['admin'])->group(function () {
        Route::get('/rekap-absensi', [GuruController::class, 'rekapAbsensi'])->name('guru.rekapabsensi');
    });

    Route::prefix('laporan')->group(function () {
        Route::get('/', [LaporanController::class, 'laporan_kehadiran'])->name('laporan.index');
        Route::post('/harian', [LaporanController::class, 'laporan_harian_tampil'])->name('laporan_harian');
        Route::post('/bulanan', [LaporanController::class, 'laporan_bulanan_tampil'])->name('laporan_bulanan');
        Route::get('/laporan_harian/{rombel}/{tanggal}', [LaporanController::class, 'laporan_harian'])->name('laporan_harian_show');
        Route::get('/laporan_bulanan/{rombel}/{bulan}/{tahun}', [LaporanController::class, 'laporan_bulanan'])->name('laporan_bulanan_show');
    });

    Route::get('/master', [MasterController::class, 'index'])->name('master.index');

    // Route::prefix('fingerprint')->group(function () {
    //     Route::get('/', [FPController::class, 'index'])->name('fingerprint_index');
    //     Route::get('/create', [FPController::class, 'create'])->name('fingerprint_create');
    //     Route::post('/store', [FPController::class, 'store'])->name('fingerprint_store');
    //     Route::get('/edit/{id}', [FPController::class, 'edit'])->name('fingerprint_edit');
    //     Route::put('/update/{id}', [FPController::class, 'update'])->name('fingerprint_update');
    //     Route::get('/delete/{id}', [FPController::class, 'delete'])->name('fingerprint_delete');
    //     Route::get('/check/{id}', [FPController::class, 'check_connection'])->name('fingerprint_check');
    //     Route::get('/active/{id}', [FPController::class, 'active'])->name('fingerprint_active');
    //     Route::get('/deactive/{id}', [FPController::class, 'deactive'])->name('fingerprint_deactive');
    // });

    Route::prefix('fingerprintguru')->group(function () {
        Route::get('/', [FPGController::class, 'index'])->name('fingerprintguru_index');
        Route::get('/create', [FPGController::class, 'create'])->name('fingerprintguru_create');
        Route::post('/store', [FPGController::class, 'store'])->name('fingerprintguru_store');
        Route::get('/edit/{id}', [FPGController::class, 'edit'])->name('fingerprintguru_edit');
        Route::put('/update/{id}', [FPGController::class, 'update'])->name('fingerprintguru_update');
        Route::get('/delete/{id}', [FPGController::class, 'delete'])->name('fingerprintguru_delete');
        Route::get('/check/{id}', [FPGController::class, 'check_connection'])->name('fingerprintguru_check');
        Route::get('/active/{id}', [FPGController::class, 'active'])->name('fingerprintguru_active');
        Route::get('/deactive/{id}', [FPGController::class, 'deactive'])->name('fingerprintguru_deactive');
    });

    // Route::prefix('siswa')->group(function () {
    //     Route::get('/', [SiswaController::class, 'index'])->name('siswa.index');
    //     Route::get('/create', [SiswaController::class, 'create'])->name('siswa.create');
    //     Route::post('/store', [SiswaController::class, 'store'])->name('siswa.store');
    //     Route::get('/edit/{nis}', [SiswaController::class, 'edit'])->name('siswa.edit');
    //     Route::put('/update/{nis}', [SiswaController::class, 'update'])->name('siswa.update');
    //     Route::delete('/delete/{nis}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
    // });

    Route::prefix('guru')->group(function () {
        Route::get('/', [GuruController::class, 'index'])->name('guru.index');
        Route::get('/create', [GuruController::class, 'create'])->name('guru.create');
        Route::post('/store', [GuruController::class, 'store'])->name('guru.store');
        Route::get('/edit/{nip}', [GuruController::class, 'edit'])->name('guru.edit');
        Route::put('/update/{nip}', [GuruController::class, 'update'])->name('guru.update');
        Route::get('/rekap-semua', [GuruController::class, 'rekapSemua'])->name('guru.detail_rekapsemua');
    });

    // Route::prefix('jurusan')->group(function () {
    //     Route::get('/', [JurusanController::class, 'index'])->name('jurusan.index');
    //     Route::get('/create', [JurusanController::class, 'create'])->name('jurusan.create');
    //     Route::post('/store', [JurusanController::class, 'store'])->name('jurusan.store');
    //     Route::put('/update/{id}', [JurusanController::class, 'update'])->name('jurusan.update');
    //     Route::get('/edit/{id}', [JurusanController::class, 'edit'])->name('jurusan.edit');
    // });

    // Route::prefix('rayon')->group(function () {
    //     Route::get('/', [RayonController::class, 'index'])->name('rayon.index');
    //     Route::get('/create', [RayonController::class, 'create'])->name('rayon.create');
    //     Route::post('/store', [RayonController::class, 'store'])->name('rayon.store');
    //     Route::get('/edit/{id}', [RayonController::class, 'edit'])->name('rayon.edit');
    //     Route::put('/update/{id}', [RayonController::class, 'update'])->name('rayon.update');
    //     Route::delete('/delete/{id}', [RayonController::class, 'destroy'])->name('rayon.destroy');
    // });

    // Route::prefix('rombel')->group(function () {
    //     Route::get('/', [RombelController::class, 'index'])->name('rombel.index');
    //     Route::get('/create', [RombelController::class, 'create'])->name('rombel.create');
    //     Route::post('/store', [RombelController::class, 'store'])->name('rombel.store');
    //     Route::get('/edit/{id}', [RombelController::class, 'edit'])->name('rombel.edit');
    //     Route::put('/update/{id}', [RombelController::class, 'update'])->name('rombel.update');
    //     Route::delete('/delete/{id}', [RombelController::class, 'destroy'])->name('rombel.destroy');
    // });
});