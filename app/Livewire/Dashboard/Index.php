<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Dashboard — Tata Usaha SMKN Karanganyar')]
class Index extends Component
{
    public int $totalSuratMasuk = 142;
    public int $totalSuratKeluar = 89;
    public int $totalSiswaAktif = 1450;
    public int $totalGuruPegawai = 98;
    public int $pendingDisposisi = 5;

    public function render()
    {
        return view('livewire.dashboard.index');
    }
}
