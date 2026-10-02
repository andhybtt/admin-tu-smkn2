<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('dapodiks', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_sinkronisasi');
            $table->dateTime('tanggal_sinkron');
            $table->enum('status', ['berhasil', 'gagal', 'proses']);
            $table->integer('jumlah_data')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('dapodiks'); }
};
