<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('personal_disease_histories', function (Blueprint $table) {
                $table->id();
                $table->string('code');
                $table->string('name');
                $table->string('code_system');
                $table->text('value_set')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        public function down()
        {
            Schema::dropIfExists('personal_disease_histories');
        }
    };
