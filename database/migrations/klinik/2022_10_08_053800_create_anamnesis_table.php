<?php

    use App\Models\Klinik\AnamnesisCategory;
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
        Schema::create('anamnesis', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(AnamnesisCategory::class);
            $table->string('name');
            $table->json('options')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('anamnesis_category_id')->references('id')->on('anamnesis_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anamnesis');
    }
};
