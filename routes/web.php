<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PesanController;
Route::get('/', function () {
    return view('guest.home');
})->name('home');

// Auth
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/forgot-password', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'resetPassword'])->name('password.reset');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Pages Siswa
Route::view('/profil', 'guest.tentang-kami');
Route::view('/program', 'guest.program');
Route::view('/biodata', 'guest.biodata');
Route::view('/jadwal', 'guest.jadwal');
Route::view('/kontak', 'guest.kontak');
Route::view('/pendaftaran', 'guest.pendaftaran');

/* =======================================================================
 * 🟢 ROUTES SISWA
 * ======================================================================= */
Route::prefix('siswa')
    ->name('siswa.')
    ->group(function () {
        /* =======================================================================
         * 🟢 Dashboard & Profil
         * ======================================================================= */
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/profil', [AuthController::class, 'profil'])->name('profil');
        Route::post('/profil/update', [SiswaController::class, 'updateProfil'])->name('profil.update');

        /* =======================================================================
         * 🟢 Biodata
         * ======================================================================= */
        Route::prefix('biodata')
            ->name('biodata.')
            ->group(function () {
                Route::get('/', [SiswaController::class, 'biodata'])->name('index');
                Route::post('/save', [SiswaController::class, 'biodatasave'])->name('save');
            });

        /* =======================================================================
         * 🟢 Jadwal Masuk Sekolah
         * ======================================================================= */
        Route::prefix('jadwal')
            ->name('jadwal.')
            ->group(function () {
                Route::get('/', [SiswaController::class, 'showJadwal'])->name('index');
            });

        /* =======================================================================
         * 🟢 Pembayaran
         * ======================================================================= */
        Route::prefix('pembayaran')
            ->name('pembayaran.')
            ->group(function () {
                Route::get('/', [SiswaController::class, 'dataPembayaran'])->name('index');
                Route::post('/', [SiswaController::class, 'tambahPembayaran'])->name('store');
                Route::put('/{id}', [SiswaController::class, 'UpdatePembayaran'])->name('update');
                Route::delete('/{id}', [SiswaController::class, 'deletePembayaran'])->name('delete');
            });
    });

// =============================
// 🟢 ROUTES ADMIN
// =============================
Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        // 🟢 Dashboard & Profil
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/profil', [AuthController::class, 'profil'])->name('profil');

        /* =======================================================================
         * 🟢 Kelas
         * ======================================================================= */
        Route::prefix('kelas')
            ->name('kelas.')
            ->group(function () {
                Route::get('/', [AdminController::class, 'dataKelas'])->name('index');
                Route::post('/', [AdminController::class, 'tambahKelas'])->name('store');
                Route::put('/{id}', [AdminController::class, 'updateKelas'])->name('update');
                Route::delete('/{id}', [AdminController::class, 'deleteKelas'])->name('delete');
            });

        /* =======================================================================
         * 🟢 SISWA
         * ======================================================================= */
        Route::prefix('siswa')
            ->name('siswa.')
            ->group(function () {
                Route::get('/', [AdminController::class, 'dataSiswa'])->name('index');
                Route::post('/', [AdminController::class, 'tambahSiswa'])->name('store');
                Route::put('/{id}', [AdminController::class, 'updateSiswa'])->name('update');
                Route::delete('/{id}', [AdminController::class, 'deleteSiswa'])->name('delete');
                Route::get('/export', [AdminController::class, 'exportSiswa'])->name('export');
            });

        /* =======================================================================
         * 🟢 GURU
         * ======================================================================= */
        Route::prefix('guru')
            ->name('guru.')
            ->group(function () {
                Route::get('/', [AdminController::class, 'dataGuru'])->name('index');
                Route::post('/', [AdminController::class, 'tambahGuru'])->name('store');
                Route::put('/{id}', [AdminController::class, 'updateGuru'])->name('update');
                Route::delete('/{id}', [AdminController::class, 'deleteGuru'])->name('delete');
                Route::get('/export', [AdminController::class, 'exportSiswa'])->name('export');
            });

        /* =======================================================================
         * 🟢 ABSENSI SISWA
         * ======================================================================= */
        Route::prefix('absensi')
            ->name('absensi.')
            ->group(function () {
                Route::get('/', [AdminController::class, 'dataAbsensi'])->name('index');
            });

        /* =======================================================================
         * 🟢 NILAI SISWA
         * ======================================================================= */
        Route::prefix('nilai')
            ->name('nilai.')
            ->group(function () {
                Route::get('/', [AdminController::class, 'dataNilai'])->name('index');
                Route::post('/', [AdminController::class, 'tambahNilai'])->name('store');
                Route::put('/{id}', [AdminController::class, 'updateNilai'])->name('update');
                Route::delete('/{id}', [AdminController::class, 'deleteNilai'])->name('delete');
            });

        /* =======================================================================
         * 🟢 AKTIVITAS HARIAN SISWA
         * ======================================================================= */
        Route::prefix('aktivitas')
            ->name('aktivitas.')
            ->group(function () {
                Route::get('/', [AdminController::class, 'dataAktivitas'])->name('index');
                Route::post('/', [AdminController::class, 'tambahAktivitas'])->name('store');
                Route::put('/{id}', [AdminController::class, 'updateAktivitas'])->name('update');
                Route::delete('/{id}', [AdminController::class, 'deleteAktivitas'])->name('delete');
            });

        /* =======================================================================
         * 🟢 Mading
         * ======================================================================= */
        Route::prefix('mading')
            ->name('mading.')
            ->group(function () {
                Route::get('/', [AdminController::class, 'dataMading'])->name('index');
                Route::post('/', [AdminController::class, 'tambahMading'])->name('store');
                Route::put('/{id}', [AdminController::class, 'updateMading'])->name('update');
                Route::delete('/{id}', [AdminController::class, 'deleteMading'])->name('delete');
            });

        /* =======================================================================
         * 🟢 Pembayaran
         * ======================================================================= */
        Route::prefix('pembayaran')
            ->name('pembayaran.')
            ->group(function () {
                Route::get('/', [AdminController::class, 'dataPembayaran'])->name('index');
                Route::put('/{id}/approve', [AdminController::class, 'approvePembayaran'])->name('approve');
                Route::put('/{id}/reject', [AdminController::class, 'rejectPembayaran'])->name('reject');
            });
    });
// =============================
// 🟢 ROUTES GURU
// =============================
Route::prefix('guru')
    ->name('guru.')
    ->group(function () {
        // 🟢 Dashboard & Profil
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/profil', [AuthController::class, 'profil'])->name('profil');

        /* =======================================================================
         * 🟢 ABSENSI SISWA
         * ======================================================================= */
        Route::prefix('absensi')
            ->name('absensi.')
            ->group(function () {
                Route::get('/', [GuruController::class, 'dataAbsensi'])->name('index');
                Route::post('/', [GuruController::class, 'tambahAbsensi'])->name('store');
                Route::put('/{id}', [GuruController::class, 'updateAbsensi'])->name('update');
                Route::delete('/{id}', [GuruController::class, 'deleteAbsensi'])->name('delete');
            });

        /* =======================================================================
         * 🟢 NILAI SISWA
         * ======================================================================= */
        Route::prefix('nilai')
            ->name('nilai.')
            ->group(function () {
                Route::get('/', [GuruController::class, 'dataNilai'])->name('index');
                Route::post('/', [GuruController::class, 'tambahNilai'])->name('store');
                Route::put('/{id}', [GuruController::class, 'updateNilai'])->name('update');
                Route::delete('/{id}', [GuruController::class, 'deleteNilai'])->name('delete');
            });

        /* =======================================================================
         * 🟢 AKTIVITAS HARIAN SISWA
         * ======================================================================= */
        Route::prefix('aktivitas')
            ->name('aktivitas.')
            ->group(function () {
                Route::get('/', [GuruController::class, 'dataAktivitas'])->name('index');
                Route::post('/', [GuruController::class, 'tambahAktivitas'])->name('store');
                Route::put('/{id}', [GuruController::class, 'updateAktivitas'])->name('update');
                Route::delete('/{id}', [GuruController::class, 'deleteAktivitas'])->name('delete');
            });
    });

// Forum Chat Routes
Route::prefix('forum')
    ->name('forum.')
    ->group(function () {
        Route::get('/chat', [PesanController::class, 'index'])->name('chat');
        Route::post('/pesan/kirim', [PesanController::class, 'kirimPesan'])->name('pesan.kirim');
        Route::delete('/pesan/{id}', [PesanController::class, 'hapusPesan'])->name('pesan.hapus');
        Route::get('/pesan/{id}/edit', [PesanController::class, 'editPesan'])->name('pesan.edit');
        Route::put('/pesan/{id}/update', [PesanController::class, 'updatePesan'])->name('pesan.update');
        Route::get('/pesan/reply/{id}/edit', [PesanController::class, 'editReply'])->name('pesan.reply.edit');
        Route::put('/pesan/reply/{id}/update', [PesanController::class, 'updateReply'])->name('pesan.reply.update');
    });
