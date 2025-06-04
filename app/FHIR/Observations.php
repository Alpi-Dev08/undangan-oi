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
}
