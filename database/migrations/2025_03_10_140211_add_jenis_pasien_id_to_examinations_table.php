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
        Schema::table('examinations', function (Blueprint $table) {
            $table->unsignedBigInteger('jenis_pasien_id')->nullable()->after('id');
            $table->foreign('jenis_pasien_id')->references('id')->on('jenis_pasien')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('examinations', function (Blueprint $table) {
            $table->dropForeign(['jenis_pasien_id']);
            $table->dropColumn('jenis_pasien_id');
        });
    }
};
