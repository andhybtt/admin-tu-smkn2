<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard\Index as DashboardIndex;
use App\Livewire\Persuratan\SuratMasukIndex;
use App\Livewire\Persuratan\FormSuratMasuk;
use App\Livewire\Persuratan\SuratKeluarIndex;
use App\Livewire\Kesiswaan\BukuIndukIndex;
use App\Livewire\Kepegawaian\DataGuruStaf;
use App\Livewire\Kesiswaan\LegalisirIjazah;

Route::get('/', DashboardIndex::class)->name('dashboard');

Route::prefix('persuratan')->name('persuratan.')->group(function () {
    Route::get('/masuk', SuratMasukIndex::class)->name('masuk');
    Route::get('/masuk/create', FormSuratMasuk::class)->name('masuk.create');
    Route::get('/keluar', SuratKeluarIndex::class)->name('keluar');
});

Route::prefix('kesiswaan')->name('kesiswaan.')->group(function () {
    Route::get('/buku-induk', BukuIndukIndex::class)->name('buku-induk');
    Route::get('/legalisir', LegalisirIjazah::class)->name('legalisir');
});

Route::prefix('kepegawaian')->name('kepegawaian.')->group(function () {
    Route::get('/data-guru-staf', DataGuruStaf::class)->name('index');
});
