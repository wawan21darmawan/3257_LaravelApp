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
        // Ubah 'penguruses' menjadi 'pengurus'
        Schema::create('pengurus', function (Blueprint $table) {
            $table->id(); // BIGINT
            $table->unsignedBigInteger('jabatan_id'); // BIGINT untuk relasi
            $table->string('name', 100);
            $table->string('description', 255)->nullable();
            $table->decimal('salary', 15, 2); // NUMERIC(15,2)
            $table->string('created_by', 100)->nullable();
            $table->string('updated_by', 100)->nullable();
            $table->timestamps(); // Otomatis membuat created_at & updated_at

            // Menyambungkan jabatan_id ke tabel jabatan
            $table->foreign('jabatan_id')->references('id')->on('jabatan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Pastikan nama tabelnya 'pengurus'
        Schema::dropIfExists('pengurus');
    }
};