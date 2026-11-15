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
        Schema::create('ms_room', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('token', 8)->unique();
            $table->foreignId('admin_id')->constrained('ms_user')->cascadeOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('ms_user', function (Blueprint $table) {
            $table->foreignId('room_id')->nullable()->constrained('ms_room')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ms_user', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
            $table->dropColumn('room_id');
        });

        Schema::dropIfExists('ms_room');
    }
};
