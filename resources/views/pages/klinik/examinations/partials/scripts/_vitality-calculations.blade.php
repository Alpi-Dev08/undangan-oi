{{-- Scripts untuk Kalkulasi Vitality --}}
@push('customscript')
    <script>
        /**
         * Vitality Examination Calculator
         * Menangani kalkulasi BMI, berat ideal, dan assessment
         */
        class VitalityCalculator {
            constructor() {
                this.bmi = 0;
                this.weight = 0;
                this.height = 0;
                this.initializeEventListeners();

                // Log inisialisasi
                console.log('VitalityCalculator initialized');
            }

            /**
             * Inisialisasi event listeners
             */
            initializeEventListeners() {
                const self = this;

                // Event listener untuk perubahan berat badan
                $('#weight').on('change', function() {
                    self.weight = parseFloat($(this).val()) || 0;
                    self.height = parseFloat($('#height').val()) || 0;
                    self.calculateBMI();

                    console.log('Weight changed:', self.weight);
                });

                // Event listener untuk perubahan tinggi badan
                $('#height').on('change', function() {
                    self.weight = parseFloat($('#weight').val()) || 0;
                    self.height = parseFloat($(this).val()) || 0;
                    self.calculateBMI();
                    self.calculateIdealWeight();

                    console.log('Height changed:', self.height);
                });

                // Event listener untuk ICD-10 selection
                $('#icdtens').on('change', function() {
                    self.updateAssessment($(this));
                });
            }

            /**
             * Kalkulasi BMI dan kategori
             */
            calculateBMI() {
                if (this.weight <= 0 || this.height <= 0) {
                    $('#body_mass_index').val('');
                    $('#bmi_conclusion').val('');
                    return;
                }

                // Konversi tinggi ke meter
                const heightInMeters = this.height / 100;
                this.bmi = this.weight / (heightInMeters * heightInMeters);

                // Set nilai BMI
                $('#body_mass_index').val(this.bmi.toFixed(2));

                // Tentukan kategori BMI
                const category = this.getBMICategory(this.bmi);
                $('#bmi_conclusion').val(category);

                console.log('BMI calculated:', this.bmi.toFixed(2), 'Category:', category);
            }

            /**
             * Mendapatkan kategori BMI
             * @param {number} bmi
             * @returns {string}
             */
            getBMICategory(bmi) {
                if (bmi < 18.5) {
                    return 'Underweight';
                } else if (bmi >= 18.5 && bmi <= 24.9) {
                    return 'Normal Weight';
                } else if (bmi >= 25 && bmi <= 29.9) {
                    return 'Overweight';
                } else if (bmi >= 30 && bmi <= 34.9) {
                    return 'Obesity class I';
                } else if (bmi >= 35 && bmi <= 39.9) {
                    return 'Obesity class II';
                } else if (bmi >= 40) {
                    return 'Obesity class III';
                }
                return 'Unknown';
            }

            /**
             * Kalkulasi berat badan ideal
             */
            calculateIdealWeight() {
                if (this.height <= 0) {
                    $('#ideal_weight').val('');
                    return;
                }

                let idealWeight = this.height - 100;

                // Adjustment berdasarkan gender
                @if (isset($user) && $user->info && $user->info->gender == '1')
                    // Laki-laki: kurangi 10%
                    idealWeight = idealWeight - (idealWeight * 10 / 100);
                @else
                    // Perempuan: kurangi 15%
                    idealWeight = idealWeight - (idealWeight * 15 / 100);
                @endif

                idealWeight = idealWeight > 0 ? idealWeight : 0;
                $('#ideal_weight').val(idealWeight.toFixed(2));

                console.log('Ideal weight calculated:', idealWeight.toFixed(2));
            }

            /**
             * Update assessment berdasarkan ICD-10 selection
             * @param {jQuery} selectElement
             */
            updateAssessment(selectElement) {
                const selectedText = selectElement.find('option:selected').text();
                const currentAssessment = $('#assessment').val() || '';

                if (selectedText && selectedText !== 'Pilih ICD-10') {
                    const newAssessment = currentAssessment + selectedText + '\n';
                    $('#assessment').val(newAssessment);

                    console.log('Assessment updated with:', selectedText);
                }
            }
        }

        /**
         * Alpine.js component untuk Vitality Examination
         */
        function vitalityExamination() {
            return {
                calculator: null,

                init() {
                    // Initialize calculator when component is mounted
                    setTimeout(() => {
                        this.calculator = new VitalityCalculator();
                        console.log('Vitality examination component initialized');
                    }, 0);
                },

                // Method untuk reset form jika diperlukan
                resetCalculations() {
                    $('#weight').val('');
                    $('#height').val('');
                    $('#body_mass_index').val('');
                    $('#bmi_conclusion').val('');
                    $('#ideal_weight').val('');

                    console.log('Calculations reset');
                }
            }
        }

        // Inisialisasi saat document ready
        $(document).ready(function() {
            console.log('Vitality form scripts loaded');
        });
    </script>
@endpush
