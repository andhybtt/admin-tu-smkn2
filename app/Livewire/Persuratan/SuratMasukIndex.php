<?php

namespace App\Livewire\Persuratan;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Agenda Surat Masuk — SMKN Karanganyar')]
class SuratMasukIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $kategoriFilter = '';

    // Dummy data untuk representasi awal tata usaha
    public array $suratData = [
        [
            'id' => 1,
            'nomor_agenda' => 'SMKN-KRA/SM/2026/001',
            'nomor_surat' => '421.5/312/DISDIK/VI/2026',
            'tanggal_terima' => '2026-09-15',
            'pengirim' => 'Dinas Pendidikan Wilayah VI',
            'perihal' => 'Undangan Rapat Koordinasi Kurikulum SMK Karanganyar',
            'status_disposisi' => 'Sudah Disposisi',
            'lampiran' => true,
        ],
        [
            'id' => 2,
            'nomor_agenda' => 'SMKN-KRA/SM/2026/002',
            'nomor_surat' => 'B-821/SMK-01/IX/2026',
            'tanggal_terima' => '2026-09-16',
            'pengirim' => 'PT Astra Honda Motor Semarang',
            'perihal' => 'Permohonan Kerjasama Praktik Kerja Lapangan (PKL) Siswa TBSM',
            'status_disposisi' => 'Belum Disposisi',
            'lampiran' => true,
        ],
        [
            'id' => 3,
            'nomor_agenda' => 'SMKN-KRA/SM/2026/003',
            'nomor_surat' => '005/741/KEC-KRA/2026',
            'tanggal_terima' => '2026-09-17',
            'pengirim' => 'Kecamatan Karanganyar',
            'perihal' => 'Pemberitahuan Upacara Hari Kesaktian Pancasila Tingkat Kabupaten',
            'status_disposisi' => 'Belum Disposisi',
            'lampiran' => false,
        ]
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $filtered = array_filter($this->suratData, function($item) {
            $matchSearch = empty($this->search) || 
                stripos($item['nomor_surat'], $this->search) !== false ||
                stripos($item['pengirim'], $this->search) !== false ||
                stripos($item['perihal'], $this->search) !== false;

            return $matchSearch;
        });

        return view('livewire.persuratan.surat-masuk-index', [
            'daftarSurat' => $filtered
        ]);
    }
}
