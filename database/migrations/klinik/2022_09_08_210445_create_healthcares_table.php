<?php

    use App\Models\Klinik\HealthcareCategory;
    use App\Models\Klinik\HealthcareType;
    use App\Models\Master\City;
    use App\Models\Master\Country;
    use App\Models\Master\District;
    use App\Models\Master\Province;
    use App\Models\Master\SubDistrict;
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
        Schema::create('healthcares', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(HealthcareCategory::class);
            $table->foreignIdFor(HealthcareType::class);
            $table->foreignIdFor(Country::class)->nullable();
            $table->foreignIdFor(Province::class)->nullable();
            $table->foreignIdFor(City::class)->nullable();
            $table->foreignIdFor(District::class)->nullable();
            $table->foreignIdFor(SubDistrict::class)->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->string('address')->nullable();
            $table->integer('postal_code')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('healthcare_category_id')->references('id')->on('healthcare_categories')->onDelete('cascade');
            $table->foreign('healthcare_type_id')->references('id')->on('healthcare_types')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
            $table->foreign('sub_district_id')->references('id')->on('sub_districts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('healthcares');
    }
};
