<?php

namespace App\Livewire\Persuratan;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Surat Keluar — SMKN Karanganyar')]
class SuratKeluarIndex extends Component
{
    public string $search = '';

    public array $suratKeluarList = [
        [
            'nomor_surat' => '421.5/104/SMKN.KRA/2026',
            'tujuan' => 'Dinas Pendidikan Jawa Tengah',
            'tanggal_kirim' => '2026-09-14',
            'perihal' => 'Laporan Pelaksanaan Uji Kompetensi Keahlian (UKK)',
            'status' => 'Terkirim'
        ],
        [
            'nomor_surat' => '421.5/105/SMKN.KRA/2026',
            'tujuan' => 'Orang Tua / Wali Murid Kelas XII',
            'tanggal_kirim' => '2026-09-16',
            'perihal' => 'Pemberitahuan Pelaksanaan Penilaian Tengah Semester',
            'status' => 'Draft'
        ]
    ];

    public function render()
    {
        return view('livewire.persuratan.surat-keluar-index');
    }
}
