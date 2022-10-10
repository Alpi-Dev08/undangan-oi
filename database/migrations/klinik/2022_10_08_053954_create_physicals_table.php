<?php

    use App\Models\Klinik\PhysicalCategory;
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
        Schema::create('physicals', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PhysicalCategory::class);
            $table->string('name');
            $table->json('options')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('physical_category_id')->references('id')->on('physical_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('physicals');
    }
};
