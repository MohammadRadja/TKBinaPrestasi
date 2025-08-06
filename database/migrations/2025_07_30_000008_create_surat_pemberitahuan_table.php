<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('surat_pemberitahuan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('judul');
            $table->text('isi');
            $table->foreignUuid('dibuat_oleh')->constrained('pengguna')->onDelete('cascade');
            $table->enum('target_role', ['admin', 'guru', 'siswa', 'semua'])->default('semua');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('surat_pemberitahuan');
    }
};
