<?php
namespace App\Livewire\Kesiswaan;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use App\Models\SiswaKeuangan;
#[Title("Keuangan & Beasiswa")]
class Keuangan extends Component {
    use WithPagination;
    public function render() {
        return view("livewire.kesiswaan.keuangan", ["records" => SiswaKeuangan::with("siswa")->latest()->paginate(10)]);
    }
}
