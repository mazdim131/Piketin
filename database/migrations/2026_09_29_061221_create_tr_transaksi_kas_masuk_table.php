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
        Schema::create('tr_transaksi_kas_masuk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->nullable()->constrained('ms_user');
            $table->decimal('nominal_masuk', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tr_transaksi_kas_masuk');
    }
};
