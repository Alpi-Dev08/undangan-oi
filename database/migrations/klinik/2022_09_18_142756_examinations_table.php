<?php

    use App\Models\Klinik\HealthProfesional;
    use App\Models\Klinik\MedicalRecord;
    use App\Models\Klinik\Package;
    use App\Models\Klinik\Patient;
    use App\Models\Klinik\ServiceType;
    use App\Models\User;
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
        Schema::create('examinations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Patient::class);
            $table->foreignIdFor(MedicalRecord::class);
            $table->foreignIdFor(HealthProfesional::class);
            $table->string('examination_code')->nullable();
            $table->date('examination_date')->nullable();
            $table->string('symtomp_area')->nullable();
            $table->string('symtomp')->nullable();
            $table->date('symtomp_date')->nullable();
            $table->string('subjective')->nullable();
            $table->string('objective')->nullable();
            $table->string('assessment')->nullable();
            $table->string('plan')->nullable();
            $table->string('total')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('medical_record_id')->references('id')->on('medical_records')->onDelete('cascade');
            $table->foreign('health_profesional_id')->references('id')->on('health_profesionals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('examinations');
    }
};
