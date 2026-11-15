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
        Schema::table('ms_user', function (Blueprint $table) {
            $candidates = ['token'];
            $toDrop = array_values(array_filter(
                $candidates,
                fn (string $col) => Schema::hasColumn('ms_user', $col)
            ));

            if ($toDrop !== []) {
                Schema::table('ms_user', function (Blueprint $table) use ($toDrop) {
                    $table->dropColumn($toDrop);
                });
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ms_user', function (Blueprint $table) {
            $table->string('token')->nullable();
        });
    }
};
