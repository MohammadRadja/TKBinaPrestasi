<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('nilai_siswa', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('siswa_id')->references('id')->on('siswa')->onDelete('cascade');
            $table->foreignUuid('guru_id')->references('id')->on('guru')->onDelete('cascade');
            $table->foreignUuid('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
            $table->string('mata_pelajaran');
            $table->integer('nilai');
            $table->text('keterangan')->nullable();
            $table->date('tanggal_input')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai_siswa');
    }
};
