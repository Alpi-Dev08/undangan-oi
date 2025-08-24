<?php

    use App\Models\Klinik\Unit;
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
            Schema::create('drugs', function (Blueprint $table) {
                $table->id();
                $table->foreignIdFor(Unit::class);
                $table->string('name')->nullable();
                $table->float('price')->nullable();

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
            Schema::dropIfExists('drugs');
        }
    };
