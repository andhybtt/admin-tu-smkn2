<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Dapodik;
use App\Models\DanaBos;
use App\Models\Aset;
use App\Models\MitraDudi;
use Carbon\Carbon;

class Batch3Seeder extends Seeder {
    public function run(): void {
        Dapodik::create([
            'jenis_sinkronisasi' => 'Tarik Data Siswa & GTK',
            'tanggal_sinkron' => Carbon::now()->subHours(2),
            'status' => 'berhasil',
            'jumlah_data' => 1250
        ]);
        Dapodik::create([
            'jenis_sinkronisasi' => 'Push Nilai Rapor',
            'tanggal_sinkron' => Carbon::now()->subDays(1),
            'status' => 'gagal',
            'jumlah_data' => 0
        ]);

        DanaBos::create([
            'tahun_anggaran' => date('Y'),
            'tahap' => 1,
            'jumlah_dana' => 850000000,
            'status_pencairan' => 'dilaporkan',
            'tanggal_pencairan' => Carbon::now()->subMonths(5)
        ]);
        DanaBos::create([
            'tahun_anggaran' => date('Y'),
            'tahap' => 2,
            'jumlah_dana' => 850000000,
            'status_pencairan' => 'cair',
            'tanggal_pencairan' => Carbon::now()->subDays(10)
        ]);
        DanaBos::create([
            'tahun_anggaran' => date('Y'),
            'tahap' => 3,
            'jumlah_dana' => 850000000,
            'status_pencairan' => 'menunggu',
            'tanggal_pencairan' => null
        ]);

        Aset::create([
            'kode_barang' => 'ELK-001',
            'nama_barang' => 'Server CBT Ujian Nasional',
            'kategori' => 'elektronik',
            'kondisi' => 'baik',
            'lokasi' => 'Ruang Server / Lab Komputer 1'
        ]);
        Aset::create([
            'kode_barang' => 'MBL-102',
            'nama_barang' => 'Meja Kursi Siswa (Set)',
            'kategori' => 'mebel',
            'kondisi' => 'rusak_ringan',
            'lokasi' => 'Gudang Belakang'
        ]);

        MitraDudi::create([
            'nama_instansi' => 'PT Telekomunikasi Indonesia (Telkom)',
            'jenis_kerjasama' => 'pkl',
            'tanggal_mou' => Carbon::now()->subYears(2),
            'masa_berlaku' => Carbon::now()->addYears(3),
            'status_aktif' => true
        ]);
        MitraDudi::create([
            'nama_instansi' => 'Universitas Sebelas Maret',
            'jenis_kerjasama' => 'rekrutmen',
            'tanggal_mou' => Carbon::now()->subYears(1),
            'masa_berlaku' => Carbon::now()->subDays(1),
            'status_aktif' => false
        ]);
    }
}
