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
        Schema::create('barang', function (Blueprint $table) {
            $table->id('id_barang');
            $table->string('code_barang')->nullable();
            $table->string('nama_barang')->nullable();
            $table->integer('quantity')->nullable();
            $table->unsignedBigInteger('id_kategory');
            $table->foreign('id_kategory')->references('id')->on('kategori_barang')->onDelete('cascade');
            $table->text('posisi')->nullable();
            $table->text('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};