<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->nullable();
            $table->string('nama_lengkap');
            $table->string('jabatan');
            $table->string('golongan')->nullable();
            $table->enum('status_pegawai', ['pns', 'pppk', 'honorer']);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('pegawais'); }
};
