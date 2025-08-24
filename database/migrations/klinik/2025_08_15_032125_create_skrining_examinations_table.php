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
        Schema::create('skrining_examinations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('examination_id');
            $table->unsignedBigInteger('location_id');
            $table->date('examination_date');

            $table->string('first_name', 255)->nullable();
            $table->string('last_name', 255)->nullable();
            $table->enum('card_type', ['ktp', 'bpjs'])->nullable();
            $table->string('nik_bpjs', 255)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('age', 20)->nullable();
            $table->string('address', 255)->nullable();
            $table->unsignedBigInteger('gender_id')->nullable();
            $table->string('phone', 255)->nullable();

            $table->longText('hasil')->nullable();
            $table->string('satuan', 255)->nullable();
            $table->string('keterangan', 255)->nullable();
            $table->string('deskripsi', 255)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skrining_examinations');
    }
};
