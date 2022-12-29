<?php

use App\Models\Klinik\Organization;
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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('code')->nullable();
            $table->foreignIdFor(Organization::class)->constrained();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('logo')->nullable();
            $table->foreignIdFor(Country::class)->constrained()->nullable();
            $table->foreignIdFor(Province::class)->constrained()->nullable();
            $table->foreignIdFor(City::class)->constrained()->nullable();
            $table->foreignIdFor(District::class)->constrained()->nullable();
            $table->foreignIdFor(SubDistrict::class)->constrained()->nullable();
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('json_satu_sehat')->nullable();
            $table->char('status',1)->default('1');
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
        Schema::dropIfExists('locations');
    }
};
