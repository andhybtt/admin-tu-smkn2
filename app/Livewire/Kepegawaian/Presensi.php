<?php

namespace App\Livewire\Kepegawaian;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Presensi — SMKN Karanganyar')]
class Presensi extends Component
{
    public function render()
    {
        return view('livewire.kepegawaian.presensi');
    }
}

