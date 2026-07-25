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
        // Ubah 'jabatans' menjadi 'jabatan' sesuai soal ERD
        Schema::create('jabatan', function (Blueprint $table) {
            $table->id(); // BIGINT
            $table->string('name', 100);
            $table->string('created_by', 100)->nullable();
            $table->string('updated_by', 100)->nullable();
            $table->timestamps(); // Ini otomatis membuat created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Pastikan dropIfExists juga menggunakan nama 'jabatan'
        Schema::dropIfExists('jabatan');
    }
};