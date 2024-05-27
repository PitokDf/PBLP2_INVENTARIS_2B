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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_barang');
            $table->foreign('id_barang')->references('id_barang')->on('barang');
            $table->uuid('id_user');
            $table->foreign('id_user')->references('id_user')->on('users');
            $table->date('tgl_peminjaman')->nullable();
            $table->date('batas_pengembalian')->nullable();
            $table->date('tgl_pengembalian')->nullable();
            $table->boolean('status')->default(false);
            $table->decimal('denda')->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};