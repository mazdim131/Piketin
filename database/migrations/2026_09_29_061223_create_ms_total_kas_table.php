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
        Schema::create('ms_total_kas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_transaksi_masuk')->constrained('tr_transaksi_kas_masuk');
            $table->foreignId('id_transaksi_keluar')->nullable()->constrained('tr_transaksi_kas_keluar');
            $table->decimal('jumlah_total_kas', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_total_kas');
    }
};
