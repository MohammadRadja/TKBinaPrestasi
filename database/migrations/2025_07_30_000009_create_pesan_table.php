<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pesan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pengguna_id');
            $table->text('isi_pesan');
            $table->timestamp('waktu_kirim')->useCurrent();
            $table->uuid('parent_id')->nullable();

            // Foreign key ke tabel pengguna
            $table->foreign('pengguna_id')->references('id')->on('pengguna')->onDelete('cascade');
        });

        // Menambahkan foreign key dan index untuk parent_id
        Schema::table('pesan', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('pesan')->onDelete('cascade');
            $table->index('parent_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesan');
    }
};
