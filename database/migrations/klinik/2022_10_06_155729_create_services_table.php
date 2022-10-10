<?php

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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ServiceCategory::class);
            $table->string('name')->nullable();
            $table->json('items')->nullable();
            $table->float('price')->nullable();
            $table->char('parent_price',1)->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('service_category_id')->references('id')->on('service_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
};
