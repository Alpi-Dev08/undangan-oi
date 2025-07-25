<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Menjalankan migration untuk menambahkan field user pada table transactions
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Field untuk user yang mengkonfirmasi pembayaran
            $table->foreignIdFor(User::class, 'payment_confirmation_user_id')
                  ->nullable()
                  ->after('metode_pembayaran')
                  ->comment('User yang mengkonfirmasi pembayaran');

            // Field untuk user yang membuat record
            $table->foreignIdFor(User::class, 'created_by')
                  ->nullable()
                  ->after('payment_confirmation_user_id')
                  ->comment('User yang membuat transaksi');

            // Field untuk user yang mengupdate record
            $table->foreignIdFor(User::class, 'updated_by')
                  ->nullable()
                  ->after('created_by')
                  ->comment('User yang terakhir mengupdate transaksi');

            // Menambahkan foreign key constraints
            $table->foreign('payment_confirmation_user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');

            $table->foreign('created_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');

            $table->foreign('updated_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    /**
     * Rollback migration
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Drop foreign key constraints terlebih dahulu
            $table->dropForeign(['payment_confirmation_user_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);

            // Drop columns
            $table->dropColumn([
                'payment_confirmation_user_id',
                'created_by',
                'updated_by'
            ]);
        });
    }
};
