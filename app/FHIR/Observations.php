<?php

namespace App\FHIR;

use Satusehat\Integration\FHIR\Observation;

class Observations extends Observation
{
    private const OBSERVATION_CODES = [
        '8480-6'  => 'Systolic blood pressure',
        '8462-4'  => 'Diastolic blood pressure',
        '8867-4'  => 'Heart rate',
        '8310-5'  => 'Body temperature',
        '9279-1'  => 'Respiratory rate',
        '8302-2'  => 'Body height',
        '29463-7' => 'Body weight',
        '10199-8' => 'Physical findings of Head Narrative',
        '10197-2' => 'Physical findings of Eye Narrative',
        '10195-6' => 'Physical findings of Ear Narrative',
        '10203-8' => 'Physical findings of Nose Narrative',
        '32436-8' => 'Physical findings of Hair',
        '32446-7' => 'Physical findings of Lip',
        '85910-8' => 'Physical findings of Teeth and gum Narrative',
        '11411-6' => 'Physical findings of Neck Narrative',
        '56867-5' => 'Physical findings of Throat Narrative',
        '11391-0' => 'Physical findings of Chest Narrative',
        '10193-1' => 'Physical findings of Breasts Narrative',
        '10192-3' => 'Physical findings of Back Narrative',
        '10191-5' => 'Physical findings of Abdomen Narrative',
        '11400-9' => 'Physical findings of Genitala Narrative',
        '11386-0' => 'Physical findings of Upper Arm Narrative',
        '11398-5' => 'Physical findings of Forearm Narrative',
        '11415-7' => 'Physical findings of Wrist Narrative',
        '11414-0' => 'Physical findings of Thigh Narrative',
        '11389-4' => 'Physical findings of Calf Narrative',
        '10201-2' => 'Physical findings of Mouth and Throat and Teeth Narrative',
        '11388-6' => 'Physical findings of Buttocks Narrative',
        '11404-1' => 'Physical findings of Hand Narrative',
        '32456-6' => 'Physical findings of Nail',
    ];

    private const SNOMED_CODES = [
        '7569003' => 'Finger structure',
        '72914001' => 'Palatal structure',
        '91636008' => 'Bilateral palatine tonsils',
        '53505006' => 'Anal structure',
        '770812000' => 'Entire nail unit of finger',
    ];

    // Define mapping of observation codes to their display names
    private array $observation = ['resourceType' => 'Observation'];

    public function addCode(string $observationCode): Observation
    {
        $display                   = self::OBSERVATION_CODES[$observationCode] ?? '';
        $this->observation['code'] = [
            'coding' => [
                [
                    'system'  => 'http://loinc.org',
                    'code'    => $observationCode,
                    'display' => $display,
                ],
            ],
        ];
        return $this;
    }

    public function addBodySite(string $snomedCode): Observation
    {
        $display                   = self::SNOMED_CODES[$snomedCode] ?? '';
        $this->observation['bodySite'] = [
            'coding' => [
                [
                    'system'  => 'http://snomed.info/sct',
                    'code'    => $snomedCode,
                    'display' => $display,
                ],
            ],
        ];
        return $this;
    }

    public function addComponent(array $observationComponent): Observation
    {
        $this->observation['valueQuantity'] = $observationComponent;

        return $this;
    }

    public function addStringComponent(string $observationComponent): Observation
    {
        $this->observation['valueString'] = $observationComponent;

        return $this;
    }

    /**
     * Adds a category to the observation.
     *
     * @param string $category the code of the category
     *
     * @return Observation The updated observation object.
     */
    public function addCategory(string $category): Observation
    {
        $display = '';
        $code    = '';
        switch ($category) {
            case 'vital-signs':
                $display = 'Vital Signs';
                $code    = 'vital-signs';
                break;
            case 'exam':
                $display = 'Exam';
                $code    = 'exam';
                break;
        }

        // NOTE: we currently only support 'vital-signs'
        $this->observation['category'][] = [
            'coding' => [
                [
                    'system'  => 'http://terminology.hl7.org/CodeSystem/observation-category',
                    'code'    => $code,
                    'display' => $display,
                ],
            ],
        ];

        return $this;
    }


    /**
     * Adds effective date time to the observation
     *
     * @param string $dateTime The effective date time in ISO 8601 format
     * @return Observation The updated observation object
     */
    public function addEffectiveDateTime(string $dateTime): Observation
    {
        $this->observation['effectiveDateTime'] = $dateTime;
        return $this;
    }

    /**
     * Adds issued date time to the observation
     *
     * @param string $dateTime The issued date time in ISO 8601 format
     * @return Observation The updated observation object
     */
    public function addIssuedDateTime(string $dateTime): Observation
    {
        $this->observation['issued'] = $dateTime;
        return $this;
    }
}
