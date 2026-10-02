<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roles = [
            'subyek' => 'Siswa / Alumni',
            'petugas' => 'Petugas TU',
            'kepala_tu' => 'Kepala TU',
            'kurikulum' => 'Bagian Kurikulum',
            'kepala_sekolah' => 'Kepala Sekolah',
            'admin' => 'Super Admin',
        ];

        foreach ($roles as $role => $name) {
            User::firstOrCreate(
                ['username' => $role],
                [
                    'name' => $name,
                    'email' => $role . '@smkn-karanganyar.sch.id',
                    'role' => $role,
                    'password' => Hash::make('password'),
                ]
            );
        }
    }
}
