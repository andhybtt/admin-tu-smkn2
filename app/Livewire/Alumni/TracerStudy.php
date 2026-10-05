<?php
namespace App\Livewire\Alumni;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Title("Tracer Study BKK")]
class TracerStudy extends Component {
    use WithPagination;
    public function render() {
        return view("livewire.alumni.tracer-study", ["records" => \App\Models\TracerStudy::with("siswa")->latest()->paginate(10)]);
    }
}
