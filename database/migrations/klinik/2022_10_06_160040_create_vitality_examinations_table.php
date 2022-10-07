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
        Schema::create('vitality_examinations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Examination::class);
            $table->string('weight')->nullable();
            $table->string('height')->nullable();
            $table->string('blood_pressure')->nullable();
            $table->string('heart_rate')->nullable();
            $table->string('respiratory_rate')->nullable();
            $table->string('temperature')->nullable();
            $table->string('oxygen_saturation')->nullable();
            $table->string('body_mass_index')->nullable();
            $table->string('ideal_weight')->nullable();
            $table->string('body_fat')->nullable();
            $table->string('bmi_conclusion')->nullable();
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
        Schema::dropIfExists('vitality_examinations');
    }
};
