<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('dana_bos', function (Blueprint $table) {
            $table->id();
            $table->year('tahun_anggaran');
            $table->integer('tahap');
            $table->bigInteger('jumlah_dana');
            $table->enum('status_pencairan', ['menunggu', 'cair', 'dilaporkan']);
            $table->date('tanggal_pencairan')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('dana_bos'); }
};
