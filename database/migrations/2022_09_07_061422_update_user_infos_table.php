<?php

use App\Models\Master\BloodType;
use App\Models\Master\CardType;
use App\Models\Master\City;
use App\Models\Master\Country;
use App\Models\Master\District;
    use App\Models\Master\Education;
    use App\Models\Master\Gender;
use App\Models\Master\MaritalStatus;
use App\Models\Master\Province;
use App\Models\Master\Religion;
use App\Models\Master\SubDistrict;
use App\Models\Master\Work;
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
        Schema::table('user_infos', function($table) {
            $table->foreignIdFor(Religion::class)->after('user_id')->nullable();
            $table->foreignIdFor(Gender::class)->after('religion_id')->nullable();
            $table->foreignIdFor(BloodType::class)->after('gender_id')->nullable();
            $table->foreignIdFor(Work::class)->after('blood_type_id')->nullable();
            $table->foreignIdFor(Education::class)->after('work_id')->nullable();
            $table->foreignIdFor(MaritalStatus::class)->after('education_id')->nullable();
            $table->foreignIdFor(CardType::class)->after('marital_status_id')->nullable();
            $table->foreignIdFor(Country::class)->after('card_type_id')->nullable();
            $table->foreignIdFor(Province::class)->after('country_id')->nullable();
            $table->foreignIdFor(City::class)->after('province_id')->nullable();
            $table->foreignIdFor(District::class)->after('city_id')->nullable();
            $table->foreignIdFor(SubDistrict::class)->after('district_id')->nullable();
            $table->bigInteger('card_number')->after('sub_district_id')->nullable();
            $table->string('patient_trustee_name')->nullable()->after('card_number');

            $table->foreign('religion_id')->references('id')->on('religions')->onDelete('cascade');
            $table->foreign('gender_id')->references('id')->on('genders')->onDelete('cascade');
            $table->foreign('blood_type_id')->references('id')->on('blood_types')->onDelete('cascade');
            $table->foreign('card_type_id')->references('id')->on('card_types')->onDelete('cascade');
            $table->foreign('work_id')->references('id')->on('works')->onDelete('cascade');
            $table->foreign('education_id')->references('id')->on('educations')->onDelete('cascade');
            $table->foreign('marital_status_id')->references('id')->on('marital_statuses')->onDelete('cascade');
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
        Schema::table('user_infos', function($table) {
            $table->dropForeign('lists_religion_id_foreign');
            $table->dropIndex('lists_religion_id_index');
            $table->dropColumn('religion_id');

            $table->dropForeign('lists_gender_id_foreign');
            $table->dropIndex('lists_gender_id_index');
            $table->dropColumn('gender_id');

            $table->dropForeign('lists_blood_type_id_foreign');
            $table->dropIndex('lists_blood_type_id_index');
            $table->dropColumn('blood_type_id');

            $table->dropForeign('lists_card_type_id_foreign');
            $table->dropIndex('lists_card_type_id_index');
            $table->dropColumn('card_type_id');

            $table->dropForeign('lists_work_id_foreign');
            $table->dropIndex('lists_work_id_index');
            $table->dropColumn('work_id');

            $table->dropForeign('lists_education_id_foreign');
            $table->dropIndex('lists_education_id_index');
            $table->dropColumn('education_id');

            $table->dropForeign('lists_marital_status_id_foreign');
            $table->dropIndex('lists_marital_status_id_index');
            $table->dropColumn('marital_status_id');

            $table->dropForeign('lists_country_id_foreign');
            $table->dropIndex('lists_country_id_index');
            $table->dropColumn('country_id');

            $table->dropForeign('lists_province_id_foreign');
            $table->dropIndex('lists_province_id_index');
            $table->dropColumn('province_id');

            $table->dropForeign('lists_city_id_foreign');
            $table->dropIndex('lists_city_id_index');
            $table->dropColumn('city_id');

            $table->dropForeign('lists_district_id_foreign');
            $table->dropIndex('lists_district_id_index');
            $table->dropColumn('district_id');

            $table->dropForeign('lists_sub_district_id_foreign');
            $table->dropIndex('lists_sub_district_id_index');
            $table->dropColumn('sub_district_id');

            $table->dropColumn('card_number');
        });
    }
};
