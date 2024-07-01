<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Uuid;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id_user')->primary()->default(Uuid::uuid4());
            $table->string('username');
            $table->string('email', 125)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('role', ['1', '2', '3', '4', '5'])->default('4');
            $table->string('password');
            $table->unsignedBigInteger('mahasiswa_id')->nullable();
            $table->foreign('mahasiswa_id')->references('id_mahasiswa')->on('mahasiswa')->cascadeOnDelete();
            $table->unsignedBigInteger('dosen_id')->nullable();
            $table->foreign('dosen_id')->references('id_dosen')->on('dosen')->cascadeOnDelete();
            $table->string('avatar')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email', 125)->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id', 125)->primary();
            $table->string('user_id', 125)->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};