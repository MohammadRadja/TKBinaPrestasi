<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('guru_id')->references('id')->on('guru')->onDelete('cascade');
            $table->string('nama_kelas', 50);
            $table->enum('tingkat', ['A', 'B']);
            $table->integer('kapasitas')->default(0);
            $table->string('tahun_ajaran', 9);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
