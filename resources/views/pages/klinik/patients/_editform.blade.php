<!--begin::Content-->
<div id="kt_account_profile_details" class="collapse show" x-data="editPatientForm()">
    <!--begin::Form-->
    <form id="kt_account_profile_details_form" class="form" method="POST"
        action="{{ route('patients.update', ['user' => $user->id, 'patient' => $user->id]) }}"
        enctype="multipart/form-data" @submit="handleSubmit">
        @csrf
        @method('PUT')

        <!--begin::Card body-->
        <div class="card-body border-top p-9">

            {{-- Photo Upload Section --}}
            @include('pages.klinik.patients.partials._photo-upload', [
                'info' => $info,
            ])

            {{-- ID Card Section --}}
            @include('pages.klinik.patients.partials._id-card', [
                'cards' => $cards,
                'info' => $info,
            ])

            {{-- Personal Information --}}
            @include('pages.klinik.patients.partials._personal-info', [
                'user' => $user,
                'info' => $info,
                'religions' => $religions,
                'genders' => $genders,
                'maritals' => $maritals,
                'bloods' => $bloods,
                'educations' => $educations,
                'works' => $works,
            ])

            {{-- Contact Information --}}
            @include('pages.klinik.patients.partials._contact-info', [
                'user' => $user,
                'info' => $info,
            ])

            {{-- Address Information --}}
            @include('pages.klinik.patients.partials._address-info', [
                'countries' => $countries,
                'provinces' => $provinces ?? null,
                'cities' => $cities ?? null,
                'districts' => $districts ?? null,
                'subdistricts' => $subdistricts ?? null,
                'info' => $info,
            ])

            {{-- Employment Information --}}
            @include('pages.klinik.patients.partials._employment-info', [
                'info' => $info,
            ])

        </div>
        <!--end::Card body-->

        <!--begin::Actions-->
        <div class="card-footer d-flex justify-content-end py-6 px-9">
            <button type="reset" class="btn btn-white btn-active-light-primary me-2" @click="resetForm">
                {{ __('Discard') }}
            </button>

            <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit"
                :disabled="isSubmitting" x-text="isSubmitting ? 'Saving...' : '{{ __('Save Changes') }}'">
            </button>
        </div>
        <!--end::Actions-->
    </form>
    <!--end::Form-->
</div>
<!--end::Content-->

@push('customscript')
    <script type="text/javascript">
        /**
         * Alpine.js component untuk mengelola form edit pasien
         * Menangani state form, validasi, dan fungsionalitas remote chained dropdown
         */
        function editPatientForm() {
            return {
                isSubmitting: false,

                /**
                 * Inisialisasi component
                 * Mengatur remote chained dropdown untuk lokasi
                 */
                init() {
                    console.log('Initializing edit patient form');
                    this.initializeRemoteChained();
                    this.initializeNikValidation();
                },

                /**
                 * Menangani submit form
                 * @param {Event} event - Form submit event
                 */
                handleSubmit(event) {
                    console.log('Form submission started');
                    this.isSubmitting = true;
                    // Form akan submit secara normal
                },

                /**
                 * Reset form ke nilai awal
                 */
                resetForm() {
                    console.log('Resetting form to initial values');
                    this.isSubmitting = false;
                    // Reset form ke nilai awal
                    document.getElementById('kt_account_profile_details_form').reset();
                },

                /**
                 * Inisialisasi remote chained dropdown untuk lokasi
                 * Mengatur dependency antar dropdown (negara -> provinsi -> kota -> kecamatan -> kelurahan)
                 */
                initializeRemoteChained() {
                    console.log('Initializing remote chained dropdowns');

                    // Provinsi berdasarkan negara
                    $("#province").remoteChained({
                        parents: "#country",
                        url: "/masters/province-country"
                    });

                    // Kota berdasarkan provinsi
                    $("#city").remoteChained({
                        parents: "#province",
                        url: "/masters/city-province"
                    });

                    // Kecamatan berdasarkan kota
                    $("#district").remoteChained({
                        parents: "#city",
                        url: "/masters/district-city"
                    });

                    // Kelurahan berdasarkan kecamatan
                    $("#subdistrict").remoteChained({
                        parents: "#district",
                        url: "/masters/district-sub"
                    });
                },

                /**
                 * Inisialisasi validasi NIK dengan AJAX
                 * Mengecek keunikan nomor kartu identitas
                 */
                initializeNikValidation() {
                    console.log('Initializing NIK validation');

                    $('#card_number').on('blur', function() {
                        var cardNumber = $(this).val();
                        var cardTypeId = $('#card_type_id').val();

                        if (cardNumber && cardTypeId) {
                            $.ajax({
                                url: '/patients/check-card-number',
                                method: 'POST',
                                data: {
                                    card_number: cardNumber,
                                    card_type_id: cardTypeId,
                                    _token: $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(response) {
                                    if (response.exists) {
                                        $('#error-message').text('Nomor kartu sudah terdaftar').show();
                                        $('#card_number').addClass('is-invalid');
                                    } else {
                                        $('#error-message').hide();
                                        $('#card_number').removeClass('is-invalid');
                                        if (response.his_number) {
                                            $('#his_number').val(response.his_number);
                                        }
                                    }
                                },
                                error: function() {
                                    console.error('Error validating card number');
                                }
                            });
                        }
                    });
                }
            }
        }
    </script>
@endpush
