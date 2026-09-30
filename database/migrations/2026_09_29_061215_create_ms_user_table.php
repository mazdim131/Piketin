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

            // 1. Opsi enum diisi role yang jelas
            $table->enum('role', ['admin', 'siswa', 'guru'])->default('siswa');

            // 2. Foreign Key id_kelas (Presisi dengan id ms_sekolah)
            $table->foreignId('id_kelas')->nullable()->constrained('ms_sekolah')->onDelete('cascade');

            // 3. Foreign Key id_jadwal_piket (Nullable jika user belum punya jadwal)
            $table->foreignId('id_jadwal_piket')->nullable()->constrained('ms_jadwal_piket')->onDelete('set null');

            // 4. Timestamps standar (created_at & updated_at)
            $table->timestamps();

            // 5. Soft delete agar user yang punya transaksi kas tetap bisa dinonaktifkan
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
