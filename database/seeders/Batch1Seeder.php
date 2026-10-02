<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\SiswaKeuangan;
use App\Models\SiswaPkl;
use App\Models\TracerStudy;
use Carbon\Carbon;

class Batch1Seeder extends Seeder {
    public function run(): void {
        $siswas = Siswa::take(10)->get();
        if ($siswas->isEmpty()) return;
        
        foreach ($siswas as $s) {
            SiswaKeuangan::create([
                'siswa_id' => $s->id,
                'jenis_transaksi' => 'iuran_komite',
                'nominal' => 150000,
                'tanggal_transaksi' => Carbon::now()->subDays(rand(1,30)),
                'status' => 'lunas'
            ]);
            SiswaKeuangan::create([
                'siswa_id' => $s->id,
                'jenis_transaksi' => 'beasiswa_pip',
                'nominal' => 1000000,
                'tanggal_transaksi' => Carbon::now()->subDays(rand(1,10)),
                'status' => 'proses'
            ]);
            
            SiswaPkl::create([
                'siswa_id' => $s->id,
                'nama_dudi' => 'PT Inovasi Teknologi ' . rand(1, 99),
                'alamat_dudi' => 'Kawasan Industri Cikarang',
                'tanggal_mulai' => Carbon::now()->subMonths(3),
                'tanggal_selesai' => Carbon::now()->addMonths(3),
                'status' => 'sedang_berjalan'
            ]);
            
            TracerStudy::create([
                'siswa_id' => $s->id,
                'tahun_lulus' => '2025',
                'status_alumni' => 'bekerja',
                'nama_instansi' => 'PT Astra Honda Motor',
                'profesi_atau_jurusan' => 'Staff Teknik',
                'kontak_terbaru' => '0812' . rand(10000000, 99999999)
            ]);
        }
    }
}
