<?php
namespace App\Livewire\Persuratan;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use App\Models\SuratKeterangan;
#[Title("Keterangan & Pengantar")]
class Keterangan extends Component {
    use WithPagination;
    public function render() {
        return view("livewire.persuratan.keterangan", ["records" => SuratKeterangan::latest()->paginate(10)]);
    }
}
