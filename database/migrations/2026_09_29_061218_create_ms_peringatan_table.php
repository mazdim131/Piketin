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
        Schema::create('ms_peringatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('ms_user')->cascadeOnDelete();
            $table->foreignId('id_jadwal_piket')->constrained('ms_jadwal_piket')->cascadeOnDelete();
            $table->enum('status_peringatan', ['belum_dibaca', 'dibaca'])->default('belum_dibaca');
            $table->dateTime('tanggal_peringatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_peringatan');
    }
};
