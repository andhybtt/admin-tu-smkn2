<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            if (! Schema::hasColumn('siswas', 'no_hp_siswa')) {
                $table->string('no_hp_siswa', 30)->nullable()->after('no_telp_ortu')
                    ->comment('Nomor HP murid untuk notifikasi');
            }
            if (! Schema::hasColumn('siswas', 'alamat_ortu')) {
                $table->text('alamat_ortu')->nullable()->after('pekerjaan_ibu');
            }
        });
    }

    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            if (Schema::hasColumn('siswas', 'no_hp_siswa')) {
                $table->dropColumn('no_hp_siswa');
            }
            if (Schema::hasColumn('siswas', 'alamat_ortu')) {
                $table->dropColumn('alamat_ortu');
            }
        });
    }
};
