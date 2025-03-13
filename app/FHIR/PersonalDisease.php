<?php

namespace App\FHIR;

use App\Models\Klinik\PersonalDiseaseHistory;
use Satusehat\Integration\FHIR\Condition;

class PersonalDisease extends Condition
{
    // You can add new methods here
    public function addCategory($category = 'diagnosis')
    {
        $this->condition['category'][] = [
            'coding' => [
                [
                    'system' => 'http://terminology.kemkes.go.id',
                    'code' => $category,
                    'display' => ucfirst($category),
                ],
            ],
        ];
    }

    // You can also override existing methods
    public function addCode($code = null, $display = null)
    {
        $code_check = PersonalDiseaseHistory::where('code', $code)->first();
        if ($code_check) {
            $display = $code_check->name;
            $system = $code_check->code_system;
        }
        // Then add your custom logic
        $this->condition['code']['coding'][] = [
            'system' => $system,
            'code' => $code,
            'display' => $display ?? 'Custom Display',
        ];
    }

    // Add more custom methods as needed
}
