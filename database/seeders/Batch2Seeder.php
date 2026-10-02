<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Pegawai;
use App\Models\PegawaiPresensi;
use App\Models\PegawaiSpt;
use App\Models\SuratKeterangan;
use Carbon\Carbon;

class Batch2Seeder extends Seeder {
    public function run(): void {
        $pegawais = [];
        for ($i=1; $i<=5; $i++) {
            $p = Pegawai::create([
                'nip' => '19800101201001100' . $i,
                'nama_lengkap' => 'Guru Teladan ' . $i . ', S.Pd',
                'jabatan' => 'Guru Mata Pelajaran',
                'golongan' => 'III/b',
                'status_pegawai' => 'pns'
            ]);
            $pegawais[] = $p;
        }

        foreach ($pegawais as $p) {
            PegawaiPresensi::create([
                'pegawai_id' => $p->id,
                'tanggal' => Carbon::today(),
                'jam_masuk' => '06:45:00',
                'jam_pulang' => null,
                'status' => 'hadir'
            ]);
            
            PegawaiSpt::create([
                'pegawai_id' => $p->id,
                'tujuan' => 'Dinas Pendidikan Provinsi',
                'tanggal_berangkat' => Carbon::now()->addDays(2),
                'tanggal_kembali' => Carbon::now()->addDays(4),
                'agenda' => 'Bimbingan Teknis Kurikulum',
                'status' => 'disetujui'
            ]);
        }
        
        for ($j=1; $j<=3; $j++) {
            SuratKeterangan::create([
                'nama_pemohon' => 'Siswa Aktif ' . $j,
                'nis_nip' => '100' . $j,
                'jenis_surat' => 'keterangan_aktif',
                'keperluan' => 'Pencairan Tunjangan Anak',
                'status_berkas' => 'diproses'
            ]);
        }
    }
}
