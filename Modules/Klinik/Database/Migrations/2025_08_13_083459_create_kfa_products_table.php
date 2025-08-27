<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kfa_products', function (Blueprint $table) {
            $table->id();
            $table->string('kfa_code')->unique();
            $table->string('name');
            $table->string('manufacturer')->nullable();
            $table->string('product_type')->nullable();
            $table->string('dosage_form')->nullable();
            $table->string('strength')->nullable();
            $table->string('unit')->nullable();
            $table->string('packaging')->nullable();
            $table->decimal('fix_price', 15, 2)->nullable();
            $table->decimal('het_price', 15, 2)->nullable();
            $table->string('registration_number')->nullable();
            $table->date('registration_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->text('description')->nullable();
            $table->json('raw_data')->nullable();
            $table->timestamp('last_sync')->useCurrent();
            $table->timestamps();
            
            $table->index('kfa_code');
            $table->index('name');
            $table->index('product_type');
            $table->index('last_sync');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kfa_products');
    }
};