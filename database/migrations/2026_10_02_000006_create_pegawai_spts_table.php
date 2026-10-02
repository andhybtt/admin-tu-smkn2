<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('pegawai_spts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->cascadeOnDelete();
            $table->string('tujuan');
            $table->date('tanggal_berangkat');
            $table->date('tanggal_kembali');
            $table->string('agenda');
            $table->enum('status', ['pengajuan', 'disetujui', 'ditolak', 'selesai']);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('pegawai_spts'); }
};
