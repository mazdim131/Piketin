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
        Schema::create('ms_riwayat_piket', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_absensi_piket')->constrained('tr_absensi_piket')->cascadeOnDelete();
            $table->enum('status_kehadiran', ['hadir', 'izin', 'sakit', 'alpa', 'tanpa_keterangan'])
                ->default('hadir');
            $table->dateTime('tanggal_kehadiran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_riwayat_piket');
    }
};
