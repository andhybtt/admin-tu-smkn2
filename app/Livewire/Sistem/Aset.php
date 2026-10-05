<?php
namespace App\Livewire\Sistem;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
#[Title("Aset & Inventaris")]
class Aset extends Component {
    use WithPagination;
    public function render() {
        return view("livewire.sistem.aset", ["records" => \App\Models\Aset::latest()->paginate(10)]);
    }
}
