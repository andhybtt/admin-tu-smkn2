<?php
namespace App\Livewire\Sistem;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use App\Models\DanaBos;
#[Title("Keuangan (RKAS/BOS)")]
class Keuangan extends Component {
    use WithPagination;
    public function render() {
        return view("livewire.sistem.keuangan", ["records" => DanaBos::latest()->paginate(10)]);
    }
}
