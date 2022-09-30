<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);

            $table->text('title_prefix')->nullable();
            $table->string('title_suffix')->nullable();
            $table->string('photo')->nullable();
            $table->string('photo_url')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('weight')->nullable();
            $table->string('height')->nullable();
            $table->string('address')->nullable();
            $table->integer('postal_code')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::table('user_infos', function (Blueprint $table) {
            $table->dropForeign('user_infos_user_id_foreign');
            $table->dropIndex('user_infos_user_id_index');
        });*/

        Schema::dropIfExists('user_infos');
    }
}
