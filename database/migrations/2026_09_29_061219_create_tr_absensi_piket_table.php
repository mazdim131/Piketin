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
        Schema::create('tr_absensi_piket', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('ms_user')->onDelete('cascade');
            $table->enum('status', ['Menunggu Konfirmasi', 'Hadir', 'Izin', 'Sakit', 'Alpa'])
                ->default('Menunggu Konfirmasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tr_absensi_piket');
    }
};
