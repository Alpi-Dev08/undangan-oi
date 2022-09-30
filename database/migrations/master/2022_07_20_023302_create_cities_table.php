<?php

    use App\Models\Master\Country;
    use App\Models\Master\Province;
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
            Schema::create('cities', function (Blueprint $table) {
                $table->id();
                $table->foreignIdFor(Country::class);
                $table->foreignIdFor(Province::class);
                $table->string('area_code')->nullable();
                $table->string('name');
                $table->timestamps();
                $table->softDeletes();

                $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
                $table->foreign('province_id')->references('id')->on('provinces')->onDelete('cascade');
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::dropIfExists('cities');
        }
    };
