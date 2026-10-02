<?php
namespace App\Livewire\Kepegawaian;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use App\Models\Pegawai;
#[Title("Data Pegawai & Karier")]
class DataGuruStaf extends Component {
    use WithPagination;
    public function render() {
        return view("livewire.kepegawaian.data-guru-staf", ["records" => Pegawai::latest()->paginate(10)]);
    }
}
