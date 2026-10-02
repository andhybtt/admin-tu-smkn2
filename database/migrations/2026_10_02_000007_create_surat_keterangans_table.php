<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('surat_keterangans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemohon');
            $table->string('nis_nip')->nullable();
            $table->enum('jenis_surat', ['keterangan_aktif', 'pengantar_lomba', 'keterangan_kelakuan_baik', 'lainnya']);
            $table->string('keperluan');
            $table->enum('status_berkas', ['menunggu', 'diproses', 'selesai', 'diambil']);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('surat_keterangans'); }
};
