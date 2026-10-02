<?php
namespace App\Livewire\Sistem;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use App\Models\MitraDudi;
#[Title("Akreditasi & MoU DUDI")]
class Akreditasi extends Component {
    use WithPagination;
    public function render() {
        return view("livewire.sistem.akreditasi", ["records" => MitraDudi::latest()->paginate(10)]);
    }
}
