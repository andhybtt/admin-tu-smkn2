<?php

namespace App\Livewire\Kesiswaan;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use App\Models\Siswa;

#[Title('Buku Induk Siswa — SMKN Karanganyar')]
class BukuIndukIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterStatus = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Siswa::query();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('nama_lengkap', 'like', '%' . $this->search . '%')
                  ->orWhere('nis', 'like', '%' . $this->search . '%')
                  ->orWhere('nisn', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        $siswas = $query->orderBy('nama_lengkap', 'asc')->paginate(10);

        return view('livewire.kesiswaan.buku-induk-index', [
            'siswas' => $siswas
        ]);
    }
}
