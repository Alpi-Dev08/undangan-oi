<?php

use App\Models\Klinik\Examination;
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
        Schema::create('ereseps', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Examination::class);
            $table->string('eresep_number');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('examination_id')->references('id')->on('examinations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ereseps');
    }
};
