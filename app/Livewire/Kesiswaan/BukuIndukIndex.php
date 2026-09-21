<?php

namespace App\Livewire\Kesiswaan;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Buku Induk Siswa — SMKN Karanganyar')]
class BukuIndukIndex extends Component
{
    public string $search = '';
    public string $jurusan = '';

    public array $siswaList = [
        [
            'nisn' => '0071238910',
            'nama' => 'Aditya Pratama',
            'kelas' => 'XII RPL 1',
            'jurusan' => 'Rekayasa Perangkat Lunak',
            'status' => 'Aktif',
        ],
        [
            'nisn' => '0072349021',
            'nama' => 'Bagas Saputra',
            'kelas' => 'XI TBSM 2',
            'jurusan' => 'Teknik & Bisnis Sepeda Motor',
            'status' => 'Aktif',
        ],
        [
            'nisn' => '0069812301',
            'nama' => 'Clarissa Putri',
            'kelas' => 'XII AKL 1',
            'jurusan' => 'Akuntansi & Keuangan Lembaga',
            'status' => 'Aktif',
        ]
    ];

    public function render()
    {
        return view('livewire.kesiswaan.buku-induk-index');
    }
}
