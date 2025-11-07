<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Membuat tabel prescription_items (detail resep)
     * - Menyimpan baris item obat per resep
     * - Kunci relasi: prescription_id
     */
    public function up(): void
    {
        Schema::create('prescription_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prescription_id');
            $table->unsignedBigInteger('drug_id')->nullable();
            $table->string('drug_name')->nullable();
            $table->string('kfa_code')->nullable();
            $table->unsignedInteger('qty')->default(1);
            $table->string('unit')->nullable();
            $table->string('dosis')->nullable();
            $table->string('aturan_pakai')->nullable();
            $table->text('keterangan')->nullable();
            $table->text('perintah_perawat')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('prescription_id')
                ->references('id')->on('prescriptions')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('drug_id')
                ->references('id')->on('drugs')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->index(['prescription_id']);
            $table->index(['drug_id']);
            $table->index(['kfa_code']);
        });
    }

    /**
     * Menghapus tabel prescription_items jika rollback
     */
    public function down(): void
    {
        Schema::dropIfExists('prescription_items');
    }
};