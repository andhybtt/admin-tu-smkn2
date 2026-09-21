<?php

namespace App\Livewire\Kesiswaan;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Layanan Legalisir — SMKN Karanganyar')]
class LegalisirIjazah extends Component
{
    public array $antrianLegalisir = [
        [
            'nomor_permohonan' => 'LEG-2026-042',
            'nama_alumni' => 'Rizky Firmansyah',
            'tahun_lulus' => '2024',
            'dokumen' => 'Ijazah & Transkrip Nilai',
            'jumlah' => '5 Lembar',
            'status' => 'Siap Diambil'
        ],
        [
            'nomor_permohonan' => 'LEG-2026-043',
            'nama_alumni' => 'Dina Wahyuni',
            'tahun_lulus' => '2025',
            'dokumen' => 'Sertifikat UKK',
            'jumlah' => '3 Lembar',
            'status' => 'Proses Verifikasi'
        ]
    ];

    public function render()
    {
        return view('livewire.kesiswaan.legalisir-ijazah');
    }
}
