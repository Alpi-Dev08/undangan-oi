<?php

namespace App\FHIR;

use App\Models\Klinik\FamilyDiseaseHistory;
use Satusehat\Integration\FHIR\Condition;

class FamilyDisease extends Condition
{
    // You can add new methods here
    public function addCategory($category = 'diagnosis')
    {
        $this->condition['category'][] = [
            'coding' => [
                [
                    'system' => 'http://terminology.hl7.org/CodeSystem/v3-RoleCode',
                    'code' => 'FAMMEMB',
                    'display' => 'family member',
                ],
            ],
        ];
    }

    // You can also override existing methods
    public function addCode($code = null, $display = null)
    {
        $code_check = FamilyDiseaseHistory::where('code', $code)->first();
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
