<?php

    use App\Models\Master\Country;
    use App\Models\Master\Province;
    use App\Models\Master\City;
    use App\Models\Master\District;
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('sub_districts', function (Blueprint $table) {
                $table->id();
                $table->foreignIdFor(Country::class);
                $table->foreignIdFor(Province::class);
                $table->foreignIdFor(City::class);
                $table->foreignIdFor(District::class);
                $table->string('name');
                $table->string('area_code')->nullable();
                $table->integer('postal_code')->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
                $table->foreign('province_id')->references('id')->on('provinces')->onDelete('cascade');
                $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
                $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::dropIfExists('sub_districts');
        }
    };
