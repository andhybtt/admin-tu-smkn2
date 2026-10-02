<?php
namespace App\Livewire\Kesiswaan;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use App\Models\SiswaPkl;
#[Title("Administrasi PKL")]
class Pkl extends Component {
    use WithPagination;
    public function render() {
        return view("livewire.kesiswaan.pkl", ["records" => SiswaPkl::with("siswa")->latest()->paginate(10)]);
    }
}
