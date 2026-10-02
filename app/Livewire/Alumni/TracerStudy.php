<?php

namespace App\Livewire\Alumni;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('TracerStudy — SMKN Karanganyar')]
class TracerStudy extends Component
{
    public function render()
    {
        return view('livewire.alumni.tracer-study');
    }
}

