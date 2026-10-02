<?php
namespace App\Livewire\Kepegawaian;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use App\Models\PegawaiPresensi;
#[Title("Presensi & e-Kinerja")]
class Presensi extends Component {
    use WithPagination;
    public function render() {
        return view("livewire.kepegawaian.presensi", ["records" => PegawaiPresensi::with("pegawai")->latest()->paginate(10)]);
    }
}
