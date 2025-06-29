{{-- Patient Create Form dengan Alpine.js untuk state management --}}
<div id="kt_account_profile_details" class="collapse show" x-data="patientForm()">
    <form id="kt_account_profile_details_form" class="form" method="POST" action="{{ route('patients.store') }}"
        enctype="multipart/form-data" x-on:submit="handleSubmit">
        @csrf

        <div class="card-body border-top p-9">
            {{-- Photo Upload Section --}}
            @include('pages.klinik.patients.partials._photo-upload')

            {{-- ID Card Section --}}
            @include('pages.klinik.patients.partials._id-card')

            {{-- Personal Information Section --}}
            @include('pages.klinik.patients.partials._personal-info')

            {{-- Contact Information Section --}}
            @include('pages.klinik.patients.partials._contact-info')

            {{-- Address Information Section --}}
            @include('pages.klinik.patients.partials._address-info')

            {{-- Employment Information Section --}}
            @include('pages.klinik.patients.partials._employment-info')
        </div>

        {{-- Form Actions --}}
        <div class="card-footer d-flex justify-content-end py-6 px-9">
            <button type="reset" class="btn btn-white btn-active-light-primary me-2" x-bind:disabled="isSubmitting">
                {{ __('Discard') }}
            </button>

            <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit"
                x-bind:disabled="isSubmitting">
                <span x-show="!isSubmitting">
                    @include('partials.general._button-indicator', ['label' => __('Save Changes')])
                </span>
            </button>
        </div>
    </form>
</div>

@push('customscript')
    <script type="text/javascript">
        /**
         * Alpine.js component untuk mengelola state form patient
         * @returns {Object} Alpine.js component data
         */
        function patientForm() {
            return {
                isSubmitting: false,
                cardNumber: '',
                cardType: '',

                /**
                 * Initialize form dengan setup event listeners
                 */
                init() {
                    this.setupLocationChaining();
                    this.setupCardValidation();
                },

                /**
                 * Setup chaining untuk dropdown lokasi
                 */
                setupLocationChaining() {
                    $("#province").remoteChained({
                        parents: "#country",
                        url: "/masters/province-country"
                    });

                    $("#city").remoteChained({
                        parents: "#province",
                        url: "/masters/city-province"
                    });

                    $("#district").remoteChained({
                        parents: "#city",
                        url: "/masters/district-city"
                    });

                    $("#subdistrict").remoteChained({
                        parents: "#district",
                        url: "/masters/district-sub"
                    });
                },

                /**
                 * Setup validasi card number
                 */
                setupCardValidation() {
                    $("#card_number").on("input", (e) => {
                        this.validateCardNumber(e.target.value);
                    });
                },

                /**
                 * Validasi card number berdasarkan tipe kartu
                 * @param {string} cardNumber - Nomor kartu yang akan divalidasi
                 */
                async validateCardNumber(cardNumber) {
                    this.cardNumber = cardNumber;
                    this.cardType = $("#card_type_id").val();

                    // Validasi NIK (card_type = 1)
                    if (this.cardType == 1 && cardNumber.length == 16) {
                        try {
                            const response = await this.checkNikExists(cardNumber);
                            this.handleNikValidationResponse(response);
                        } catch (error) {
                            console.error('Error validating NIK:', error);
                            this.showValidationError(cardNumber);
                        }
                    }
                },

                /**
                 * Check apakah NIK sudah terdaftar
                 * @param {string} cardNumber - Nomor NIK
                 * @returns {Promise} Response dari server
                 */
                checkNikExists(cardNumber) {
                    return $.ajax({
                        url: "/klinik/patients/check-nik",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            card_number: cardNumber
                        }
                    });
                },

                /**
                 * Handle response dari validasi NIK
                 * @param {Object} response - Response dari server
                 */
                handleNikValidationResponse(response) {
                    if (response.status === "success") {
                        this.setCardValidationState(true);
                        $("#his_number").val(response.data);
                    } else {
                        this.showNikNotFoundDialog();
                    }
                },

                /**
                 * Set state validasi card
                 * @param {boolean} isValid - Status validasi
                 */
                setCardValidationState(isValid) {
                    const cardInput = $("#card_number");
                    if (isValid) {
                        cardInput.removeClass("is-invalid").addClass("is-valid");
                    } else {
                        cardInput.removeClass("is-valid").addClass("is-invalid");
                    }
                },

                /**
                 * Tampilkan dialog ketika NIK tidak ditemukan
                 */
                showNikNotFoundDialog() {
                    Swal.fire({
                        title: "{{ __('IHS Number Tidak Ditemukan') }}",
                        text: "{{ __('IHS Number tidak ditemukan, Apakah Akan Tetap Melanjutkan Registrasi?') }}",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "{{ __('Ya, Lanjutkan') }}",
                        cancelButtonText: "{{ __('Batal') }}"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.setCardValidationState(true);
                        } else {
                            window.location.href = "{{ route('patients.index') }}";
                        }
                    });
                },

                /**
                 * Handle form submission
                 * @param {Event} event - Form submit event
                 */
                handleSubmit(event) {
                    this.isSubmitting = true;

                    // Validasi form sebelum submit
                    if (!this.validateForm()) {
                        event.preventDefault();
                        this.isSubmitting = false;
                        return false;
                    }

                    // Log aktivitas submit
                    console.log('Form patient sedang disubmit:', {
                        timestamp: new Date().toISOString(),
                        cardNumber: this.cardNumber,
                        cardType: this.cardType
                    });
                },

                /**
                 * Validasi form sebelum submit
                 * @returns {boolean} Status validasi
                 */
                validateForm() {
                    const requiredFields = ['card_number', 'first_name', 'phone', 'place_of_birth', 'date_of_birth',
                        'gender_id'
                    ];
                    let isValid = true;

                    requiredFields.forEach(field => {
                        const element = document.querySelector(`[name="${field}"]`);
                        if (!element || !element.value.trim()) {
                            isValid = false;
                            this.showFieldError(field);
                        }
                    });

                    return isValid;
                },

                /**
                 * Tampilkan error pada field tertentu
                 * @param {string} fieldName - Nama field yang error
                 */
                showFieldError(fieldName) {
                    const element = document.querySelector(`[name="${fieldName}"]`);
                    if (element) {
                        element.classList.add('is-invalid');

                        // Hapus class error setelah user mulai mengetik
                        element.addEventListener('input', function() {
                            this.classList.remove('is-invalid');
                        }, {
                            once: true
                        });
                    }
                }
            }
        }
    </script>
@endpush
