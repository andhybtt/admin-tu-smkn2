<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('mitra_dudis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_instansi');
            $table->enum('jenis_kerjasama', ['pkl', 'rekrutmen', 'beasiswa', 'kurikulum']);
            $table->date('tanggal_mou');
            $table->date('masa_berlaku');
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('mitra_dudis'); }
};
