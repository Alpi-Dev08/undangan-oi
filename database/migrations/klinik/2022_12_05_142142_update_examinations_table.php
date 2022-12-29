<?php

    use App\Models\Klinik\Plan;
    use App\Models\Klinik\ServiceCategory;
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
        Schema::table('examinations',function($table){
            $table->unsignedBigInteger('patient_id')->nullable()->change();
            $table->unsignedBigInteger('medical_record_id')->nullable()->change();
            $table->unsignedBigInteger('health_profesional_id')->nullable()->change();
            //$table->foreignIdFor(ServiceCategory::class)->after('medical_record_id')->nullable();
            //$table->foreignIdFor(Plan::class)->after('service_category_id')->nullable();
            $table->dropColumn('symtomp_area');
            $table->dropColumn('symtomp');
            $table->dropColumn('symtomp_date');
            $table->dropColumn('plan');

            /*$table->string('resep')->after('assessment')->nullable();
            $table->char('is_appointment',1)->default('0')->nullable();
            $table->char('appointment_status',1)->nullable();
            $table->timestamp('appointment_date')->nullable();*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
