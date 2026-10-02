<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            
            $table->string('nis')->unique()->comment('Nomor Induk Siswa Sekolah');
            $table->string('nisn')->nullable()->unique()->comment('Nomor Induk Siswa Nasional');
            $table->string('nama_lengkap');
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('agama')->nullable();
            $table->text('alamat')->nullable();
            
            $table->string('nama_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->string('no_telp_ortu')->nullable();
            
            $table->year('tahun_masuk')->nullable();
            $table->string('kelas_sekarang')->nullable();
            $table->string('kompetensi_keahlian')->nullable();
            
            $table->enum('status', ['aktif', 'lulus', 'pindah', 'keluar', 'meninggal'])->default('aktif');
            $table->text('catatan')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
