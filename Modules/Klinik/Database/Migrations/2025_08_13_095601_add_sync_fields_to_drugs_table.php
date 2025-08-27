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
            $table->decimal('similarity_score', 5, 2)->nullable()->after('manufacturer');
            $table->json('matching_metadata')->nullable()->after('similarity_score');
            $table->timestamp('last_sync_attempt')->nullable()->after('matching_metadata');
            
            // Add indexes for optimization
            $table->index('manufacturer');
            $table->index('similarity_score');
            $table->index('last_sync_attempt');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drugs', function (Blueprint $table) {
            $table->dropColumn([
                'manufacturer',
                'similarity_score',
                'matching_metadata',
                'last_sync_attempt'
            ]);
        });
    }
};