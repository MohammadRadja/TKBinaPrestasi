<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('pengguna_id')->constrained('pengguna')->onDelete('cascade');
            $table->foreignUuid('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
            $table->string('nama_lengkap', 50);
            $table->string('nama_panggilan', 10)->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('tempat_tanggal_lahir', 100);
            $table->enum('agama', ['Islam', 'Kristen Protestan', 'Kristen Katolik', 'Hindu', 'Buddha', 'Konghucu']);
            $table->integer('anak_ke')->nullable();
            $table->string('nama_ayah', 50);
            $table->string('nama_ibu', 50);
            $table->string('pekerjaan_ayah', 30)->nullable();
            $table->string('pekerjaan_ibu', 30)->nullable();
            $table->string('no_hp', 15)->nullable();
            $table->text('alamat');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
