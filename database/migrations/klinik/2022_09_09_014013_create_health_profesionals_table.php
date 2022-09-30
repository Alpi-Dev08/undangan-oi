<?php

    use App\Models\Klinik\HealthProfesionalType;
    use App\Models\Klinik\Speciality;
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
        Schema::create('health_profesionals', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(HealthProfesionalType::class);
            $table->foreignIdFor(Speciality::class)->nullable();
            $table->string('str_number')->nullable();
            $table->string('str_expire_date')->nullable();
            $table->string('str_file')->nullable();
            $table->string('sip_number')->nullable();
            $table->string('sip_expire_date')->nullable();
            $table->string('sip_file')->nullable();
            $table->string('kkj_registration_card')->nullable();
            $table->string('health_profesional_status')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('health_profesional_type_id')->references('id')->on('health_profesional_types')->onDelete('cascade');
            $table->foreign('speciality_id')->references('id')->on('specialities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('health_profesionals');
    }
};
