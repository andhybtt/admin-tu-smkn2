<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $siswas = [
            [
                'nis' => '12345001',
                'nisn' => '0051234561',
                'nama_lengkap' => 'Ahmad Fathoni',
                'tempat_lahir' => 'Karanganyar',
                'tanggal_lahir' => '2005-04-12',
                'jenis_kelamin' => 'L',
                'agama' => 'Islam',
                'alamat' => 'Jl. Lawu No. 123, Karanganyar',
                'nama_ayah' => 'Budi Santoso',
                'nama_ibu' => 'Siti Aminah',
                'pekerjaan_ayah' => 'Wiraswasta',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'no_telp_ortu' => '081234567890',
                'tahun_masuk' => 2021,
                'kelas_sekarang' => 'XII RPL 1',
                'kompetensi_keahlian' => 'Rekayasa Perangkat Lunak',
                'status' => 'aktif',
            ],
            [
                'nis' => '12345002',
                'nisn' => '0051234562',
                'nama_lengkap' => 'Bunga Citra',
                'tempat_lahir' => 'Surakarta',
                'tanggal_lahir' => '2006-08-22',
                'jenis_kelamin' => 'P',
                'agama' => 'Islam',
                'alamat' => 'Jl. Slamet Riyadi No. 45, Surakarta',
                'nama_ayah' => 'Anton Wijaya',
                'nama_ibu' => 'Ratna Sari',
                'pekerjaan_ayah' => 'PNS',
                'pekerjaan_ibu' => 'Guru',
                'no_telp_ortu' => '089876543210',
                'tahun_masuk' => 2022,
                'kelas_sekarang' => 'XI TKJ 2',
                'kompetensi_keahlian' => 'Teknik Komputer dan Jaringan',
                'status' => 'aktif',
            ],
            [
                'nis' => '12345003',
                'nisn' => '0051234563',
                'nama_lengkap' => 'Candra Wijaya',
                'tempat_lahir' => 'Sragen',
                'tanggal_lahir' => '2004-11-05',
                'jenis_kelamin' => 'L',
                'agama' => 'Kristen',
                'alamat' => 'Perum Asri Raya, Sragen',
                'nama_ayah' => 'Haryanto',
                'nama_ibu' => 'Maria',
                'pekerjaan_ayah' => 'Karyawan Swasta',
                'pekerjaan_ibu' => 'Pedagang',
                'no_telp_ortu' => '082233445566',
                'tahun_masuk' => 2020,
                'kelas_sekarang' => 'Alumni',
                'kompetensi_keahlian' => 'Teknik Kendaraan Ringan',
                'status' => 'lulus',
            ],
        ];

        foreach ($siswas as $siswa) {
            Siswa::firstOrCreate(['nis' => $siswa['nis']], $siswa);
        }
    }
}
