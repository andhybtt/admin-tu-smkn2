<?php

namespace Database\Seeders;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Akun staf/pengelola sistem.
     * Akun siswa dibuat otomatis dari data siswa (username = NISN, password = NIS).
     */
    private const STAFF = [
        ['username' => 'petugas',    'password' => 'smkn2krapetugas', 'name' => 'Petugas TU',     'role' => 'petugas',   'email' => 'petugas@smkn2kra.sch.id'],
        ['username' => 'kepala tu',  'password' => 'smkn2krakatu',    'name' => 'Kepala TU',      'role' => 'kepala_tu', 'email' => 'kepalatu@smkn2kra.sch.id'],
        ['username' => 'kurikulum',  'password' => 'smkn2krakur',     'name' => 'Waka Kurikulum', 'role' => 'kurikulum', 'email' => 'kurikulum@smkn2kra.sch.id'],
        ['username' => 'pusat',      'password' => 'pusatadmin',      'name' => 'Admin Pusat',    'role' => 'admin',     'email' => 'admin@smkn2kra.sch.id'],
    ];

    /** Username akun demo lama yang harus dibersihkan. */
    private const LEGACY_USERNAMES = ['admin', 'kepala_tu', 'subyek'];

    public function run(): void
    {
        // Hapus akun demo lama (password: "password")
        User::whereIn('username', self::LEGACY_USERNAMES)->get()->each(function (User $user) {
            if (Hash::check('password', $user->password)) {
                $user->delete();
            }
        });

        foreach (self::STAFF as $staff) {
            $this->syncAccount($staff);
        }

        foreach (Siswa::whereNotNull('nisn')->whereNotNull('nis')->get() as $siswa) {
            $user = $this->syncAccount([
                'username' => $siswa->nisn,
                'password' => $siswa->nis,
                'name'     => $siswa->nama_lengkap,
                'role'     => 'subyek',
                'email'    => $siswa->nisn . '@siswa.smkn2kra.sch.id',
            ]);

            if ($siswa->user_id !== $user->id) {
                $siswa->user_id = $user->id;
                $siswa->save();
            }
        }
    }

    /**
     * Buat akun jika belum ada. Jika akun sudah ada, password hanya diganti
     * bila masih berupa password demo lama ("password"), sehingga password
     * yang sudah diubah pengguna tidak tertimpa saat seeder dijalankan ulang.
     */
    private function syncAccount(array $data): User
    {
        // Bebaskan email bila dipakai akun lain (mis. akun demo lama)
        User::where('email', $data['email'])
            ->where(fn ($q) => $q->whereNull('username')->orWhere('username', '!=', $data['username']))
            ->delete();

        $user = User::where('username', $data['username'])->first();

        if (! $user) {
            return User::create($data);
        }

        $update = ['name' => $data['name'], 'role' => $data['role'], 'email' => $data['email']];

        if (Hash::check('password', $user->password)) {
            $update['password'] = $data['password'];
        }

        $user->update($update);

        return $user;
    }
}
