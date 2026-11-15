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
        $candidates = ['hari', 'jobdesk', 'name', 'day'];
        $toDrop = array_values(array_filter(
            $candidates,
            fn (string $col) => Schema::hasColumn('ms_jadwal_piket', $col)
        ));

        if ($toDrop !== []) {
            Schema::table('ms_jadwal_piket', function (Blueprint $table) use ($toDrop) {
                $table->dropColumn($toDrop);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ms_jadwal_piket', function (Blueprint $table) {
            $table->string('hari')->nullable();
            $table->string('jobdesk')->nullable();
            $table->string('name')->nullable();
            $table->string('day')->nullable();
        });
    }
};
