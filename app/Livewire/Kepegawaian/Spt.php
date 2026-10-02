<?php
namespace App\Livewire\Kepegawaian;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use App\Models\PegawaiSpt;
#[Title("Perjalanan Dinas (SPT)")]
class Spt extends Component {
    use WithPagination;
    public function render() {
        return view("livewire.kepegawaian.spt", ["records" => PegawaiSpt::with("pegawai")->latest()->paginate(10)]);
    }
}
