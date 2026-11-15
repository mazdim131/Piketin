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
        Schema::table('ms_jadwal_piket', function (Blueprint $table) {
            $table->enum('day', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ms_jadwal_piket', function (Blueprint $table) {
            //
        });
    }
};
