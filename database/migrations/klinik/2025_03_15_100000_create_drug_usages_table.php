<?php

use App\Models\Klinik\Drug;
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
        Schema::create('drug_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Drug::class)->constrained()->onDelete('cascade');
            $table->date('date');
            $table->string('user_name');
            $table->integer('quantity');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('drug_usages');
    }
};
