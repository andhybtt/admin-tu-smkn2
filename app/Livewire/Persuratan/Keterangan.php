<?php

namespace App\Livewire\Persuratan;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Keterangan — SMKN Karanganyar')]
class Keterangan extends Component
{
    public function render()
    {
        return view('livewire.persuratan.keterangan');
    }
}

