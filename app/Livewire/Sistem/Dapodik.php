<?php
namespace App\Livewire\Sistem;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
#[Title("Data Pokok (Dapodik)")]
class Dapodik extends Component {
    use WithPagination;
    public function render() {
        return view("livewire.sistem.dapodik", ["records" => \App\Models\Dapodik::latest()->paginate(10)]);
    }
}
