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
            "32436-8" => "Physical findings of Hair"
        ];

        // Define mapping of observation codes to their display names
        private array $observation = ['resourceType' => 'Observation'];

        public function addCode(string $observationCode)
        : Observation
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

        public function addComponent(array $observationComponent)
        : Observation
        {
            $this->observation['valueQuantity'] = $observationComponent;

            return $this;
        }

        public function addStringComponent(string $observationComponent)
        : Observation
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
        public function addCategory(string $category)
        : Observation
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
    }
