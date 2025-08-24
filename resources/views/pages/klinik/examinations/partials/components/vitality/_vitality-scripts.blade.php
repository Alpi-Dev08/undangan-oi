<script>
/**
 * Vitality Examination Calculator
 * Menghitung BMI, berat ideal, dan kesimpulan BMI
 */
function vitalityExamination() {
    return {
        /**
         * Menghitung BMI berdasarkan berat dan tinggi badan
         * @returns {void}
         */
        calculateBMI() {
            try {
                const weight = parseFloat(document.getElementById('weight').value);
                const height = parseFloat(document.getElementById('height').value);

                if (weight > 0 && height > 0) {
                    // Konversi tinggi dari cm ke meter
                    const heightInMeters = height / 100;

                    // Hitung BMI
                    const bmi = weight / (heightInMeters * heightInMeters);

                    // Update field BMI
                    document.getElementById('body_mass_index').value = bmi.toFixed(2);

                    // Hitung berat ideal (menggunakan rumus Broca yang dimodifikasi)
                    const idealWeight = this.calculateIdealWeight(height);
                    document.getElementById('ideal_weight').value = idealWeight.toFixed(2);

                    // Tentukan kesimpulan BMI
                    const conclusion = this.getBMIConclusion(bmi);
                    document.getElementById('bmi_conclusion').value = conclusion;

                    console.log(`BMI calculated: ${bmi.toFixed(2)}, Ideal Weight: ${idealWeight.toFixed(2)}, Conclusion: ${conclusion}`);
                }
            } catch (error) {
                console.error('Error calculating BMI:', error);
            }
        },

        /**
         * Menghitung berat badan ideal berdasarkan tinggi
         * @param {number} height - Tinggi badan dalam cm
         * @returns {number} Berat badan ideal dalam kg
         */
        calculateIdealWeight(height) {
            // Rumus Broca yang dimodifikasi
            if (height <= 150) {
                return height - 100;
            } else if (height <= 160) {
                return height - 105;
            } else {
                return height - 110;
            }
        },

        /**
         * Menentukan kesimpulan BMI berdasarkan nilai BMI
         * @param {number} bmi - Nilai BMI
         * @returns {string} Kesimpulan BMI
         */
        getBMIConclusion(bmi) {
            if (bmi < 18.5) {
                return 'Underweight (Kurus)';
            } else if (bmi >= 18.5 && bmi < 25) {
                return 'Normal';
            } else if (bmi >= 25 && bmi < 30) {
                return 'Overweight (Kelebihan Berat Badan)';
            } else {
                return 'Obese (Obesitas)';
            }
        },

        /**
         * Inisialisasi form saat halaman dimuat
         * @returns {void}
         */
        init() {
            // Hitung BMI jika sudah ada data berat dan tinggi
            this.calculateBMI();
            console.log('Vitality examination form initialized');
        }
    }
}

// Inisialisasi saat DOM ready
document.addEventListener('DOMContentLoaded', function() {
    // Auto-calculate BMI jika ada perubahan pada weight atau height
    const weightInput = document.getElementById('weight');
    const heightInput = document.getElementById('height');

    if (weightInput && heightInput) {
        const calculator = vitalityExamination();
        calculator.init();
    }
});
</script>
