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
        Schema::create('barang_masuks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barang_id')->nullable();
            $table->foreign('barang_id')->references('id_barang')->on('barang')->cascadeOnDelete();
            $table->foreignId('pemasok_id')->nullable()->constrained('pemasoks')->cascadeOnDelete();
            $table->integer('quantity');
            $table->string('penerima');
            $table->date('tanggal_masuk');
            $table->string('keterangan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_masuks');
    }
};