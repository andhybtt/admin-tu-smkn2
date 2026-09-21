<?php

namespace App\Livewire\Kepegawaian;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Data Guru & Pegawai — SMKN Karanganyar')]
class DataGuruStaf extends Component
{
    public array $pegawaiList = [
        [
            'nip' => '197505122000031002',
            'nama' => 'Drs. H. Sukamto, M.Pd.',
            'jabatan' => 'Kepala Sekolah',
            'status' => 'PNS'
        ],
        [
            'nip' => '198208142010012015',
            'nama' => 'Sri Wahyuni, S.Kom.',
            'jabatan' => 'Kepala Tata Usaha',
            'status' => 'PNS'
        ],
        [
            'nip' => '199011242022211005',
            'nama' => 'Ahmad Fauzi, S.Pd.',
            'jabatan' => 'Guru Kejuruan RPL',
            'status' => 'P3K'
        ]
    ];

    public function render()
    {
        return view('livewire.kepegawaian.data-guru-staf');
    }
}
