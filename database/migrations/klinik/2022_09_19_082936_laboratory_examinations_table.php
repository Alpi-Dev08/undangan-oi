<?php

    use App\Models\Klinik\Examination;
    use App\Models\Klinik\LaboratoryExaminationType;
    use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('laboratory_examinations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(LaboratoryExaminationType::class);
            $table->foreignIdFor(Examination::class);
            $table->string('laboratory_registration_number');
            $table->string('status')->nullable();
            $table->string('total')->nullable();
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
        Schema::dropIfExists('laboratory_examinations');
    }
};
