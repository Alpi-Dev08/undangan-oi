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
        Schema::table('drugs', function (Blueprint $table) {
            $table->string('manufacturer')->nullable()->after('name');
            $table->decimal('similarity_score', 5, 2)->nullable()->after('kfa_code');
            $table->text('matching_metadata')->nullable()->after('kfa_data');
            $table->timestamp('last_sync_attempt')->nullable()->after('updated_at');
            
            // Index untuk optimasi pencarian
            $table->index(['name', 'manufacturer'], 'drugs_name_manufacturer_index');
            $table->index('similarity_score', 'drugs_similarity_score_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drugs', function (Blueprint $table) {
            $table->dropIndex(['drugs_name_manufacturer_index']);
            $table->dropIndex(['drugs_similarity_score_index']);
            $table->dropColumn(['manufacturer', 'similarity_score', 'matching_metadata', 'last_sync_attempt']);
        });
    }
};