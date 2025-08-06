<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_lengkap', 50);
            $table->string('username', 50)->unique();
            $table->string('email', 50)->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'siswa', 'guru',]);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pengguna');
    }
};
