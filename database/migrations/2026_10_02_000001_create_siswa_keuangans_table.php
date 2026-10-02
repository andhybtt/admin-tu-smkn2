<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('siswa_keuangans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->cascadeOnDelete();
            $table->enum('jenis_transaksi', ['iuran_komite', 'sumbangan_pendidikan', 'beasiswa_pip', 'beasiswa_lain']);
            $table->integer('nominal');
            $table->date('tanggal_transaksi');
            $table->enum('status', ['lunas', 'menunggak', 'cair', 'proses']);
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('siswa_keuangans'); }
};
