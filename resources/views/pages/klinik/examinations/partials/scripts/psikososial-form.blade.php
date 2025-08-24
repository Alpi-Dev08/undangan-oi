<script>
    $(function() {
        // Reusable function for toggle detail inputs
        function initializeToggleInputs() {
            const toggleConfigs = [{
                    radioName: 'riwayat_pekerjaan[zat_bahaya]',
                    detailId: 'zat_bahaya_detail',
                    triggers: ['Ya']
                },
                {
                    radioName: 'riwayat_pekerjaan[berpergian]',
                    detailId: 'bepergian_detail',
                    triggers: ['Ya']
                },
                {
                    radioName: 'riwayat_kesehatan[alergi_obat]',
                    detailId: 'alergi_obat_detail',
                    triggers: ['Ada']
                },
                {
                    radioName: 'riwayat_kesehatan[alergi_makanan]',
                    detailId: 'alergi_makanan_detail',
                    triggers: ['Ada']
                },
                {
                    radioName: 'khusus',
                    detailId: 'lainnya-text',
                    triggers: ['Lainnya']
                }
            ];

            toggleConfigs.forEach(config => {
                const radios = document.getElementsByName(config.radioName);
                const detailInput = document.getElementById(config.detailId);

                if (radios.length && detailInput) {
                    radios.forEach(radio => {
                        radio.addEventListener('change', function() {
                            if (config.triggers.includes(this.value) && this.checked) {
                                detailInput.style.display = 'block';
                            } else {
                                detailInput.style.display = 'none';
                            }
                        });
                    });
                }
            });
        }

        // Initialize all toggle inputs
        initializeToggleInputs();

        // Form validation
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                // Add any form validation logic here
            });
        }
    });
</script>
