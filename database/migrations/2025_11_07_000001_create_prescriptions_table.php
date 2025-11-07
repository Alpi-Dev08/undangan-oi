<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Membuat tabel prescriptions (header resep)
     * - Menyimpan informasi umum resep terkait suatu pemeriksaan
     * - Kunci relasi: examination_id
     */
    public function up(): void
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('examination_id');
            $table->unsignedBigInteger('doctor_id');
            $table->date('resep_date')->nullable();
            $table->text('catatan_umum')->nullable();
            $table->unsignedInteger('total_items')->default(0);
            $table->string('status')->default('saved');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('examination_id')
                ->references('id')->on('examinations')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('doctor_id')
                ->references('id')->on('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

    /**
     * Menghapus tabel prescriptions jika rollback
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};