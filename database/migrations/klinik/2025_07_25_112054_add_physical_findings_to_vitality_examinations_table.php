<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan migration untuk menambahkan field physical findings
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vitality_examinations', function (Blueprint $table) {
            // Cek apakah kolom belum ada sebelum menambahkan
            if (!Schema::hasColumn('vitality_examinations', 'head_findings')) {
                $table->text('head_findings')->nullable()->comment('Temuan fisik kepala');
            }
            if (!Schema::hasColumn('vitality_examinations', 'eye_findings')) {
                $table->text('eye_findings')->nullable()->comment('Temuan fisik mata');
            }
            if (!Schema::hasColumn('vitality_examinations', 'ear_findings')) {
                $table->text('ear_findings')->nullable()->comment('Temuan fisik telinga');
            }
            if (!Schema::hasColumn('vitality_examinations', 'nose_findings')) {
                $table->text('nose_findings')->nullable()->comment('Temuan fisik hidung');
            }
            if (!Schema::hasColumn('vitality_examinations', 'throat_findings')) {
                $table->text('throat_findings')->nullable()->comment('Temuan fisik tenggorokan');
            }
            if (!Schema::hasColumn('vitality_examinations', 'chest_findings')) {
                $table->text('chest_findings')->nullable()->comment('Temuan fisik dada');
            }
            if (!Schema::hasColumn('vitality_examinations', 'back_findings')) {
                $table->text('back_findings')->nullable()->comment('Temuan fisik punggung');
            }
            if (!Schema::hasColumn('vitality_examinations', 'abdomen_findings')) {
                $table->text('abdomen_findings')->nullable()->comment('Temuan fisik perut');
            }

            // Field yang sudah ada di database tapi belum di migrasi - skip karena sudah ada
            // breath, apex_beat, waist_circumference (typo: waist_circumferennce),
            // neck_circumference, arm_circumference, chest_size,
            // abdominal_circumference (typo: adbdominal_circumference), others, skrining

            // Field tambahan yang mungkin diperlukan untuk physical findings lengkap
            if (!Schema::hasColumn('vitality_examinations', 'hair_findings')) {
                $table->text('hair_findings')->nullable()->comment('Temuan fisik rambut');
            }
            if (!Schema::hasColumn('vitality_examinations', 'lip_findings')) {
                $table->text('lip_findings')->nullable()->comment('Temuan fisik bibir');
            }
            if (!Schema::hasColumn('vitality_examinations', 'teeth_findings')) {
                $table->text('teeth_findings')->nullable()->comment('Temuan fisik gigi dan gusi');
            }
            if (!Schema::hasColumn('vitality_examinations', 'neck_findings')) {
                $table->text('neck_findings')->nullable()->comment('Temuan fisik leher');
            }
            if (!Schema::hasColumn('vitality_examinations', 'breast_findings')) {
                $table->text('breast_findings')->nullable()->comment('Temuan fisik payudara');
            }
            if (!Schema::hasColumn('vitality_examinations', 'genital_findings')) {
                $table->text('genital_findings')->nullable()->comment('Temuan fisik genital');
            }
            if (!Schema::hasColumn('vitality_examinations', 'upper_arm_findings')) {
                $table->text('upper_arm_findings')->nullable()->comment('Temuan fisik lengan atas');
            }
            if (!Schema::hasColumn('vitality_examinations', 'forearm_findings')) {
                $table->text('forearm_findings')->nullable()->comment('Temuan fisik lengan bawah');
            }
            if (!Schema::hasColumn('vitality_examinations', 'wrist_findings')) {
                $table->text('wrist_findings')->nullable()->comment('Temuan fisik pergelangan tangan');
            }
            if (!Schema::hasColumn('vitality_examinations', 'thigh_findings')) {
                $table->text('thigh_findings')->nullable()->comment('Temuan fisik paha');
            }
            if (!Schema::hasColumn('vitality_examinations', 'calf_findings')) {
                $table->text('calf_findings')->nullable()->comment('Temuan fisik betis');
            }
            if (!Schema::hasColumn('vitality_examinations', 'mouth_findings')) {
                $table->text('mouth_findings')->nullable()->comment('Temuan fisik mulut dan tenggorokan');
            }
            if (!Schema::hasColumn('vitality_examinations', 'buttocks_findings')) {
                $table->text('buttocks_findings')->nullable()->comment('Temuan fisik pantat');
            }
            if (!Schema::hasColumn('vitality_examinations', 'hand_findings')) {
                $table->text('hand_findings')->nullable()->comment('Temuan fisik tangan');
            }
            if (!Schema::hasColumn('vitality_examinations', 'nail_findings')) {
                $table->text('nail_findings')->nullable()->comment('Temuan fisik kuku');
            }
            if (!Schema::hasColumn('vitality_examinations', 'tongue_findings')) {
                $table->text('tongue_findings')->nullable()->comment('Temuan fisik lidah');
            }

            // Tambahkan foreign key untuk user_id jika belum ada
            if (!Schema::hasColumn('vitality_examinations', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->comment('ID user yang melakukan pemeriksaan');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse migration
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vitality_examinations', function (Blueprint $table) {
            // Drop foreign key jika ada
            if (Schema::hasColumn('vitality_examinations', 'user_id')) {
                $table->dropForeign(['user_id']);
            }

            // Drop kolom yang ditambahkan
            $columnsToCheck = [
                'head_findings', 'eye_findings', 'ear_findings', 'nose_findings',
                'hair_findings', 'lip_findings', 'teeth_findings', 'neck_findings',
                'throat_findings', 'chest_findings', 'breast_findings', 'back_findings',
                'abdomen_findings', 'genital_findings', 'upper_arm_findings', 'forearm_findings',
                'wrist_findings', 'thigh_findings', 'calf_findings', 'mouth_findings',
                'buttocks_findings', 'hand_findings', 'nail_findings', 'tongue_findings',
                'user_id'
            ];

            $existingColumns = [];
            foreach ($columnsToCheck as $column) {
                if (Schema::hasColumn('vitality_examinations', $column)) {
                    $existingColumns[] = $column;
                }
            }

            if (!empty($existingColumns)) {
                $table->dropColumn($existingColumns);
            }
        });
    }
};
