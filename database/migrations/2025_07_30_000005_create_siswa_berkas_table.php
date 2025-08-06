<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('siswa_berkas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->string('jenis_berkas', 50);
            $table->string('file_path');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('siswa_berkas');
    }
};
