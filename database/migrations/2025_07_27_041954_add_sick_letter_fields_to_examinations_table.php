<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('examinations', function (Blueprint $table) {
        $table->string('sick_letter_number')->nullable();
        $table->text('sick_letter_data')->nullable()->after('sick_letter_number');
    });
}

public function down()
{
    Schema::table('examinations', function (Blueprint $table) {
        $table->dropColumn(['sick_letter_number', 'sick_letter_data']);
    });
}
};
