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
            $table->string('kode_peminjaman')->nullable()->unique();
            $table->unsignedBigInteger('id_barang');
            $table->foreign('id_barang')->references('id_barang')->on('barang');
            $table->uuid('id_user');
            $table->foreign('id_user')->references('id_user')->on('users');
            $table->date('tgl_peminjaman');
            $table->date('batas_pengembalian');
            $table->date('tgl_pengembalian')->nullable();
            $table->integer('jumlah');
            $table->tinyInteger('status')->default(0); // 0 = belum disetujui, 1 = disetujui, 2 = ditolak
            $table->decimal('denda')->default(0.00);
            $table->text('keterangan');
            $table->text('kondisi')->nullable();
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