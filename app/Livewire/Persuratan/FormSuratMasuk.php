<?php

namespace App\Livewire\Persuratan;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

#[Title('Catat Surat Masuk — SMKN Karanganyar')]
class FormSuratMasuk extends Component
{
    use WithFileUploads;

    #[Rule('required|string|max:50')]
    public string $nomor_agenda = '';

    #[Rule('required|string|max:100')]
    public string $nomor_surat = '';

    #[Rule('required|date')]
    public string $tanggal_surat = '';

    #[Rule('required|date')]
    public string $tanggal_terima = '';

    #[Rule('required|string|max:150')]
    public string $pengirim = '';

    #[Rule('required|string|max:255')]
    public string $perihal = '';

    #[Rule('required|in:Dinas,Undangan,Pemberitahuan,Permohonan,Lainnya')]
    public string $kategori = 'Dinas';

    #[Rule('required|in:Biasa,Penting,Segera,Rahasia')]
    public string $derajat = 'Biasa';

    #[Rule('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $file_dokumen;

    public ?string $scanned_image_base64 = null;

    public function mount()
    {
        $this->tanggal_terima = date('Y-m-d');
        $this->tanggal_surat = date('Y-m-d');
        $tahun = date('Y');
        $this->nomor_agenda = "SMKN-KRA/SM/{$tahun}/" . str_pad((string) rand(1, 999), 3, '0', STR_PAD_LEFT);
    }

    public function handleScannedImage(string $base64Data)
    {
        $this->scanned_image_base64 = $base64Data;
        $this->file_dokumen = null;
    }

    public function hapusFile()
    {
        $this->file_dokumen = null;
        $this->scanned_image_base64 = null;
    }

    public function simpanSurat()
    {
        $this->validate();

        $pathSimpan = null;

        if ($this->file_dokumen) {
            $pathSimpan = $this->file_dokumen->store('surat-masuk/' . date('Y'), 'public');
        } elseif ($this->scanned_image_base64) {
            $imageParts = explode(';base64,', $this->scanned_image_base64);
            if (count($imageParts) === 2) {
                $imageDecoded = base64_decode($imageParts[1]);
                $filename = 'scan_' . time() . '_' . Str::random(6) . '.jpg';
                $pathSimpan = 'surat-masuk/' . date('Y') . '/' . $filename;
                Storage::disk('public')->put($pathSimpan, $imageDecoded);
            }
        }

        session()->flash('success', "Surat masuk [{$this->nomor_surat}] sukses dicatat dalam arsip TU.");

        return $this->redirectRoute('persuratan.masuk', navigate: true);
    }

    public function render()
    {
        return view('livewire.persuratan.form-surat-masuk');
    }
}
