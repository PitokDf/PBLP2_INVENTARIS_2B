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
        Schema::create('pemasoks', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('alamat');
            $table->char('kode_pos');
            $table->string('kota');
            $table->char('no_hp', 15);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemasoks');
    }
};