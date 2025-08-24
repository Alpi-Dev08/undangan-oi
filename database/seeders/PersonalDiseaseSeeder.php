<?php
namespace Database\Seeders;

use DB;
use JeroenZwart\CsvSeeder\CsvSeeder;

class PersonalDiseaseSeeder extends CsvSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function __construct(){
        $this->file = base_path().'/database/seeders/csv/personal_disease_histories.csv';
        $this->tablename = 'personal_disease_histories';
        $this->delimiter = ';';
    }

    public function run()
    {
        // Recommended when importing larger CSVs
		DB::disableQueryLog();

		parent::run();
    }
}
