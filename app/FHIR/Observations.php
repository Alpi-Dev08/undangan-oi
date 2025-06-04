<?php
namespace App\FHIR;

use Satusehat\Integration\FHIR\Observation;

class Observations extends Observation{
    private array $observation = ['resourceType' => 'Observation'];
    public function addCode(string $observationCode): Observation
    {
        $code = [
            'system' => 'http://loinc.org',
            'code' => '',
            'display' => '',
        ];

        $display = '';
        $code = '';
        switch ($observationCode) {
            case '8480-6':
                $display = 'Systolic blood pressure';
                $code = '8480-6';
                break;
            case '8462-4':
                $display = 'Diastolic blood pressure';
                $code = '8462-4';
                break;
            case '8867-4':
                $display = 'Heart rate';
                $code = '8867-4';
                break;
            case '8310-5':
                $display = 'Body temperature';
                $code = '8310-5';
                break;
            case '9279-1':
                $display = 'Respiratory rate';
                $code = '9279-1';
                break;
            case '8302-2':
                $display = 'Body height';
                $code = '8302-2';
                break;
            case '29463-7':
                $display = 'Body weight';
                $code = '29463-7';
                break;
            case '10199-8':
                $display = 'Physical findings of Head Narrative';
                $code = '10199-8';
                break;
            case '10197-2':
                $display = 'Physical findings of Eye Narrative';
                $code = '10197-2';
                break;

        }

        $this->observation['code'] = [
            'coding' => [
                [
                    'system' => 'http://loinc.org',
                    'code' => $code,
                    'display' => $display,
                ],
            ],
        ];

        return $this;
    }

    public function addComponent(array $observationComponent) : Observation
    {
        $this->observation['valueQuantity'] = $observationComponent;

        return $this;
    }

    /**
     * Adds a category to the observation.
     *
     * @param  string  $category  the code of the category
     * @return Observation The updated observation object.
     */
    public function addCategory(string $category): Observation
    {
        $display = '';
        $code = '';
        switch ($category) {
            case 'vital-signs':
                $display = 'Vital Signs';
                $code = 'vital-signs';
                break;
            case 'exam':
                $display = 'Exam';
                $code = 'exam';
                break;
        }

        // NOTE: we currently only support 'vital-signs'
        $this->observation['category'][] = [
            'coding' => [
                [
                    'system' => 'http://terminology.hl7.org/CodeSystem/observation-category',
                    'code' => $code,
                    'display' => $display,
                ],
            ],
        ];

        return $this;
    }
}
