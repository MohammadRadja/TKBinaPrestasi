<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('aktivitas_harian', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('siswa_id')->references('id')->on('siswa')->onDelete('cascade');
            $table->foreignUuid('guru_id')->references('id')->on('guru')->onDelete('cascade');
            $table->foreignUuid('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
            $table->date('tanggal');
            $table->text('aktivitas');
            $table->text('catatan')->nullable();
            $table->string('foto_aktivitas')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aktivitas_harian');
    }
};
