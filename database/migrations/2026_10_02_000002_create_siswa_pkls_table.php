<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('siswa_pkls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->cascadeOnDelete();
            $table->string('nama_dudi');
            $table->string('alamat_dudi')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->enum('status', ['pengajuan', 'disetujui', 'sedang_berjalan', 'selesai']);
            $table->string('nilai_sertifikat')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('siswa_pkls'); }
};
