<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Dashboard\Index as DashboardIndex;
use App\Livewire\Persuratan\SuratMasukIndex;
use App\Livewire\Persuratan\FormSuratMasuk;
use App\Livewire\Persuratan\SuratKeluarIndex;
use App\Livewire\Kesiswaan\BukuIndukIndex;
use App\Livewire\Kepegawaian\DataGuruStaf;
use App\Livewire\Kesiswaan\LegalisirIjazah;

use App\Livewire\Auth\Login;

use App\Livewire\Kesiswaan\Keuangan as KesiswaanKeuangan;
use App\Livewire\Kesiswaan\Pkl as KesiswaanPkl;
use App\Livewire\Alumni\TracerStudy;
use App\Livewire\Kepegawaian\Presensi;
use App\Livewire\Kepegawaian\Spt;
use App\Livewire\Persuratan\Keterangan;
use App\Livewire\Sistem\Dapodik;
use App\Livewire\Sistem\Keuangan as SistemKeuangan;
use App\Livewire\Sistem\Aset;
use App\Livewire\Sistem\Akreditasi;

Route::get('/login', Login::class)->name('login')->middleware('guest');
Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/login');
})->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', DashboardIndex::class)->name('dashboard');

    Route::prefix('persuratan')->name('persuratan.')->group(function () {
        Route::get('/masuk', SuratMasukIndex::class)->name('masuk');
        Route::get('/masuk/create', FormSuratMasuk::class)->name('masuk.create');
        Route::get('/keluar', SuratKeluarIndex::class)->name('keluar');
        Route::get('/keterangan', Keterangan::class)->name('keterangan');
    });

    Route::prefix('kesiswaan')->name('kesiswaan.')->group(function () {
        Route::get('/buku-induk', BukuIndukIndex::class)->name('buku-induk');
        Route::get('/legalisir', LegalisirIjazah::class)->name('legalisir');
        Route::get('/keuangan', KesiswaanKeuangan::class)->name('keuangan');
        Route::get('/pkl', KesiswaanPkl::class)->name('pkl');
    });

    Route::prefix('alumni')->name('alumni.')->group(function () {
        Route::get('/tracer-study', TracerStudy::class)->name('tracer-study');
    });

    Route::prefix('kepegawaian')->name('kepegawaian.')->group(function () {
        Route::get('/data-guru-staf', DataGuruStaf::class)->name('index');
        Route::get('/presensi', Presensi::class)->name('presensi');
        Route::get('/spt', Spt::class)->name('spt');
    });

    Route::prefix('sistem')->name('sistem.')->group(function () {
        Route::get('/dapodik', Dapodik::class)->name('dapodik');
        Route::get('/keuangan', SistemKeuangan::class)->name('keuangan');
        Route::get('/aset', Aset::class)->name('aset');
        Route::get('/akreditasi', Akreditasi::class)->name('akreditasi');
    });
});
