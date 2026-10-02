<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('tracer_studies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->cascadeOnDelete();
            $table->year('tahun_lulus');
            $table->enum('status_alumni', ['bekerja', 'wirausaha', 'kuliah', 'mencari_kerja']);
            $table->string('nama_instansi')->nullable();
            $table->string('profesi_atau_jurusan')->nullable();
            $table->string('kontak_terbaru')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('tracer_studies'); }
};
