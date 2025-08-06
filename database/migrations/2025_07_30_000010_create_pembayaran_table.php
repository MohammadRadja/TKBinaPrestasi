<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Relasi ke siswa
            $table->foreignUuid('siswa_id')->constrained('siswa')->onDelete('cascade');

            // Detail pembayaran
            $table->enum('jenis_pembayaran', ['pendaftaran', 'seragam', 'spp', 'lainnya']);
            $table->decimal('jumlah', 12, 2);
            $table->enum('status', ['pending', 'lunas', 'gagal'])->default('pending');
            $table->enum('metode', ['transfer', 'tunai'])->nullable();

            // Opsional: bukti pembayaran
            $table->string('bukti_pembayaran')->nullable();

            $table->date('tanggal_pembayaran')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
