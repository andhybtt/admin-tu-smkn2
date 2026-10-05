<?php

namespace App\Services;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

/**
 * Template, ekspor, dan impor data siswa (CSV) beserta pembuatan akun login siswa.
 * Akun siswa: username = NISN, password = NIS.
 */
class SiswaCsv
{
    public const DELIMITER = ';';

    public const HEADERS = [
        'No', 'Nama', 'NISN', 'NIS', 'Kelas', 'Nama Orang Tua', 'Alamat Orang Tua',
        'No HP Murid', 'No HP Orang Tua', 'Pekerjaan Orang Tua', 'Keterangan',
    ];

    /** Alias nama kolom (sudah dinormalisasi) => kunci internal. */
    private const ALIASES = [
        'no' => 'no', 'nomor' => 'no',
        'nama' => 'nama', 'namasiswa' => 'nama', 'namamurid' => 'nama', 'namalengkap' => 'nama',
        'nisn' => 'nisn',
        'nis' => 'nis',
        'kelas' => 'kelas',
        'namaorangtua' => 'nama_ortu', 'namaortu' => 'nama_ortu',
        'alamatorangtua' => 'alamat_ortu', 'alamatortu' => 'alamat_ortu',
        'nohpmurid' => 'hp_siswa', 'nomerhpmurid' => 'hp_siswa', 'nomorhpmurid' => 'hp_siswa',
        'hpmurid' => 'hp_siswa', 'nohpsiswa' => 'hp_siswa',
        'nohporangtua' => 'hp_ortu', 'nomerhporangtua' => 'hp_ortu', 'nomorhporangtua' => 'hp_ortu',
        'hporangtua' => 'hp_ortu', 'hportu' => 'hp_ortu', 'nohportu' => 'hp_ortu',
        'pekerjaanorangtua' => 'pekerjaan_ortu', 'pekerjaanortu' => 'pekerjaan_ortu',
        'keterangan' => 'keterangan', 'catatan' => 'keterangan',
    ];

    // ------------------------------------------------------------------
    // Template & ekspor
    // ------------------------------------------------------------------

    public static function writeTemplate($out): void
    {
        fwrite($out, "\xEF\xBB\xBF"); // BOM UTF-8 agar Excel membaca karakter dengan benar
        self::line($out, self::HEADERS);
        self::line($out, [
            1, 'CONTOH - hapus baris ini', self::text('0051234599'), self::text('12345099'), 'X RPL 1',
            'Budi Contoh', 'Jl. Contoh No. 1, Karanganyar', self::text('081234567890'),
            self::text('081298765432'), 'Wiraswasta', 'Juara 1 lomba LKS tingkat kabupaten',
        ]);
    }

    public static function writeExport($out): void
    {
        fwrite($out, "\xEF\xBB\xBF");
        self::line($out, self::HEADERS);

        $no = 0;
        Siswa::orderBy('kelas_sekarang')->orderBy('nama_lengkap')->cursor()->each(function (Siswa $s) use ($out, &$no) {
            self::line($out, [
                ++$no,
                $s->nama_lengkap,
                self::text($s->nisn),
                self::text($s->nis),
                $s->kelas_sekarang,
                $s->nama_ayah ?: $s->nama_ibu,
                $s->alamat_ortu,
                self::text($s->no_hp_siswa),
                self::text($s->no_telp_ortu),
                $s->pekerjaan_ayah ?: $s->pekerjaan_ibu,
                $s->catatan,
            ]);
        });
    }

    private static function line($out, array $fields): void
    {
        fputcsv($out, $fields, self::DELIMITER);
    }

    /** Paksa Excel membaca sebagai teks agar angka 0 di depan tidak hilang. */
    private static function text(?string $value): string
    {
        return $value === null || $value === '' ? '' : '="' . $value . '"';
    }

    // ------------------------------------------------------------------
    // Impor
    // ------------------------------------------------------------------

    /**
     * @return array{created:int, updated:int, skipped:int, errors:array<int, array{line:int, message:string}>}
     */
    public function import(string $path): array
    {
        $result = ['created' => 0, 'updated' => 0, 'skipped' => 0, 'errors' => []];

        [$rows, $fatal] = $this->parse($path);

        if ($fatal) {
            $result['errors'][] = ['line' => 1, 'message' => $fatal];
            return $result;
        }

        foreach ($rows as $line => $row) {
            if (Str::startsWith(Str::lower($row['nama'] ?? ''), 'contoh')) {
                $result['skipped']++;
                continue;
            }

            try {
                $status = DB::transaction(fn () => $this->importRow($row));
                $result[$status]++;
            } catch (Throwable $e) {
                $message = $e instanceof \DomainException
                    ? $e->getMessage()
                    : 'Gagal menyimpan data (' . Str::limit($e->getMessage(), 120) . ')';
                $result['errors'][] = ['line' => $line, 'message' => $message];
            }
        }

        return $result;
    }

    /** @return 'created'|'updated' */
    private function importRow(array $row): string
    {
        $nama = $row['nama'] ?? '';
        $nisn = $row['nisn'] ?? '';
        $nis = $row['nis'] ?? '';

        if ($nama === '') {
            throw new \DomainException('Nama wajib diisi.');
        }
        if ($nis === '') {
            throw new \DomainException('NIS wajib diisi (dipakai sebagai kata sandi awal).');
        }
        if ($nisn === '') {
            throw new \DomainException('NISN wajib diisi (dipakai sebagai username).');
        }
        if (! ctype_digit($nisn)) {
            throw new \DomainException("NISN \"{$nisn}\" harus berupa angka. Jika terbaca seperti 5,1E+09, ubah format kolom menjadi Teks.");
        }
        $nisn = str_pad($nisn, 10, '0', STR_PAD_LEFT);

        $siswa = Siswa::withTrashed()->where('nis', $nis)->first();

        $nisnTaken = Siswa::withTrashed()->where('nisn', $nisn)
            ->when($siswa, fn ($q) => $q->where('id', '!=', $siswa->id))
            ->exists();
        if ($nisnTaken) {
            throw new \DomainException("NISN {$nisn} sudah dipakai siswa lain.");
        }

        $data = array_filter([
            'nama_lengkap'     => $nama,
            'nisn'             => $nisn,
            'kelas_sekarang'   => $row['kelas'] ?? null,
            'nama_ayah'        => $row['nama_ortu'] ?? null,
            'alamat_ortu'      => $row['alamat_ortu'] ?? null,
            'no_hp_siswa'      => $row['hp_siswa'] ?? null,
            'no_telp_ortu'     => $row['hp_ortu'] ?? null,
            'pekerjaan_ayah'   => $row['pekerjaan_ortu'] ?? null,
            'catatan'          => $row['keterangan'] ?? null,
        ], fn ($v) => $v !== null && $v !== '');

        // Akun login siswa
        $user = User::where('username', $nisn)->first();
        if ($user && $user->role !== 'subyek') {
            throw new \DomainException("Username {$nisn} sudah dipakai akun non-siswa.");
        }
        if ($user) {
            $user->update(['name' => $nama]);
        } else {
            $email = $nisn . '@siswa.smkn2kra.sch.id';
            if (User::where('email', $email)->exists()) {
                throw new \DomainException("Email akun {$email} sudah terpakai.");
            }
            $user = User::create([
                'name' => $nama, 'username' => $nisn, 'email' => $email,
                'role' => 'subyek', 'password' => $nis,
            ]);
        }
        $data['user_id'] = $user->id;

        if ($siswa) {
            if ($siswa->trashed()) {
                $siswa->restore();
            }
            $siswa->update($data);
            return 'updated';
        }

        Siswa::create($data + ['nis' => $nis, 'status' => 'aktif']);
        return 'created';
    }

    /**
     * @return array{0: array<int, array<string,string>>, 1: ?string} [baris(nomor baris => data), pesan error fatal]
     */
    private function parse(string $path): array
    {
        $content = (string) file_get_contents($path);
        $content = preg_replace('/^\xEF\xBB\xBF/', '', $content);

        if (! mb_check_encoding($content, 'UTF-8')) {
            $content = mb_convert_encoding($content, 'UTF-8', 'Windows-1252');
        }

        $firstLine = strtok($content, "\r\n") ?: '';
        $delimiter = collect([';', ',', "\t"])
            ->sortByDesc(fn ($d) => substr_count($firstLine, $d))
            ->first();

        $handle = fopen('php://temp', 'r+');
        fwrite($handle, $content);
        rewind($handle);

        $header = fgetcsv($handle, 0, $delimiter);
        if (! $header) {
            return [[], 'File kosong atau format tidak dikenali.'];
        }

        $map = [];
        foreach ($header as $i => $title) {
            $title = preg_replace('/\(.*?\)/', '', (string) $title);
            $key = preg_replace('/[^a-z0-9]/', '', Str::lower($title));
            if (isset(self::ALIASES[$key])) {
                $map[$i] = self::ALIASES[$key];
            }
        }

        $missing = array_diff(['nama', 'nisn', 'nis'], $map);
        if ($missing) {
            return [[], 'Kolom wajib tidak ditemukan: ' . implode(', ', array_map('strtoupper', $missing)) . '. Gunakan template yang disediakan.'];
        }

        $rows = [];
        $line = 1;
        while (($cols = fgetcsv($handle, 0, $delimiter)) !== false) {
            $line++;
            if (count(array_filter($cols, fn ($c) => trim((string) $c) !== '')) === 0) {
                continue; // baris kosong
            }

            $row = [];
            foreach ($map as $i => $key) {
                $row[$key] = $this->clean($key, $cols[$i] ?? '');
            }
            $rows[$line] = $row;
        }
        fclose($handle);

        return [$rows, null];
    }

    private function clean(string $key, string $value): string
    {
        $value = trim($value);

        // Hilangkan pembungkus ="..." atau apostrof pembuka yang dipakai agar Excel menyimpan teks
        if (preg_match('/^="(.*)"$/s', $value, $m)) {
            $value = $m[1];
        }
        $value = ltrim($value, "'");
        $value = trim($value);

        if (in_array($key, ['hp_siswa', 'hp_ortu'], true) && $value !== '') {
            $value = preg_replace('/[^\d+]/', '', $value);
            if ($value !== '' && $value[0] === '8') {
                $value = '0' . $value; // angka 0 di depan hilang oleh Excel
            }
        }

        if (in_array($key, ['nisn', 'nis'], true)) {
            $value = preg_replace('/\s+/', '', $value);
        }

        return $value;
    }
}
