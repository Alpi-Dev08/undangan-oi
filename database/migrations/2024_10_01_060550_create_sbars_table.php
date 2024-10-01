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
    public function up()
    {
        Schema::create('sbars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id'); // ID perawat atau user
            $table->date('tanggal');
            $table->string('no_rm'); // Nomor Rekam Medis
            $table->string('nama_pasien');
            $table->date('tanggal_sbar');
            $table->time('jam_sbar');
            $table->text('situation');
            $table->text('background');
            $table->text('assessment');
            $table->text('recommendation');
            $table->boolean('is_verified')->default(false);
            $table->timestamps();

            // Tambahkan kolom examination_id
            $table->foreignId('examination_id')->constrained()->onDelete('cascade');
        });
    }    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sbars');
    }
};
