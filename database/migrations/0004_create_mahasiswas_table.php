<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id('id_mahasiswa');
            $table->string('nama')->nullable();
            $table->char('nim', 10)->unique()->nullable();
            $table->string('code_prodi');
            $table->foreign('code_prodi')->references('code_prodi')->on('prodis')->onDelete('cascade');
            $table->integer('angkatan')->nullable();
            $table->decimal('ipk', 3, 2)->default(0.00);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};