<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Menambahkan kolom untuk akun Organizer di tabel users
        Schema::table('users', function (Blueprint $table) {
            // Nama organisasi (misal: "HIMA SI Amikom", "Kepanitiaan AMCC")
            $table->string('organization_name')->nullable()->after('name');
            
            // Status untuk persetujuan Superadmin (pending, approved, rejected)
            $table->enum('organizer_status', ['pending', 'approved', 'rejected'])->default('approved')->after('role');
        });

        // 2. Menghubungkan tabel events dengan tabel users (Organizer)
        Schema::table('events', function (Blueprint $table) {
            // Menambahkan user_id sebagai foreign key
            // Gunakan nullable() dulu agar data event lama tidak error saat di-migrate
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['organization_name', 'organizer_status']);
        });
    }
};