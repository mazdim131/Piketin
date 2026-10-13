<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ms_user', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('email')->unique();
            $table->string('password');

            $table->string('token')->nullable();
            $table->enum('role', ['admin', 'siswa', 'guru'])->default('siswa');
            $table->foreignId('id_kelas')->nullable()->constrained('ms_sekolah')->onDelete('cascade');
            $table->foreignId('id_jadwal_piket')->nullable()->constrained('ms_jadwal_piket')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_user');
    }
};
