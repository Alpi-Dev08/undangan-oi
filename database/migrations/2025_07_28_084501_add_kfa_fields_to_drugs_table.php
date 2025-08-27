<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('drugs', function (Blueprint $table) {
            $table->string('kfa_code')->nullable()->after('stock')->comment('Kode KFA dari SATUSEHAT');
            $table->json('kfa_data')->nullable()->after('kfa_code')->comment('Data lengkap dari API KFA SATUSEHAT');
            $table->index('kfa_code', 'drugs_kfa_code_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('drugs', function (Blueprint $table) {
            $table->dropIndex('drugs_kfa_code_index');
            $table->dropColumn(['kfa_code', 'kfa_data']);
        });
    }
};