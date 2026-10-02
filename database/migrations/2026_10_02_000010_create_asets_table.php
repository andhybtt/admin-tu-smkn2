<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('asets', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang')->unique();
            $table->string('nama_barang');
            $table->enum('kategori', ['elektronik', 'mebel', 'kendaraan', 'bangunan']);
            $table->enum('kondisi', ['baik', 'rusak_ringan', 'rusak_berat']);
            $table->string('lokasi');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('asets'); }
};
