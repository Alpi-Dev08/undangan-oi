@php
    // Helper function to safely get nested property values
    if (!function_exists('getNestedValue')) {
        function getNestedValue($object, $path, $default = null)
        {
            $keys = explode('.', $path);
            $current = $object;

            foreach ($keys as $key) {
                if (!isset($current->$key)) {
                    return $default;
                }
                $current = $current->$key;
            }

            return $current;
        }
    }

    // Helper function to check if nested property equals value
    if (!function_exists('isNestedValueEqual')) {
        function isNestedValueEqual($object, $path, $value)
        {
            return getNestedValue($object, $path) === $value;
        }
    }

    // Initialize psikososial data
    $psikososial = isset($examination->psikososial) ? json_decode($examination->psikososial) : null;

    // Define form sections configuration
    $formSections = [
        'kebutuhan_khusus' => [
            'title' => 'Kebutuhan Khusus',
            'type' => 'radio_with_other',
            'name' => 'khusus',
            'options' => [
                'Alat bantu Dengar',
                'Kacamata',
                'Tongkat',
                'Kursi Roda',
                'Disabilitas',
                'Tidak Ada',
                'Lainnya',
            ],
            'other_field' => 'lainnya',
            'other_trigger' => 'Lainnya',
        ],
        'psikologi_sosial' => [
            'title' => 'Data Psikologi Dan Sosial',
            'type' => 'multiple_radio',
            'fields' => [
                'bicara' => ['label' => 'Bicara', 'options' => ['Jelas', 'Tidak Dimengerti']],
                'komunikasi' => ['label' => 'Komunikasi', 'options' => ['Verbal', 'Non Verbal']],
                'emosional' => [
                    'label' => 'Status Emosional',
                    'options' => ['Stabil/Tenang', 'Marah', 'Cemas', 'Takut', 'Sedih'],
                ],
                'nyeri' => [
                    'label' => 'Nyeri Dada',
                    'options' => ['Tidak ada', 'Ada (Tingkat Sedang)', 'Nyeri dada kiri tembus punggung'],
                ],
                'sosiologi' => [
                    'label' => 'Sosiologi',
                    'options' => ['Komunikatif', 'Komunikatif Tidak Efek', 'Menarik Diri'],
                ],
            ],
        ],
        'riwayat_pekerjaan' => [
            'title' => 'Riwayat Pekerjaan',
            'type' => 'nested_radio_with_detail',
            'fields' => [
                'zat_bahaya' => [
                    'label' => 'Apakah pekerjaan pasien berhubungan dengan zat berbahaya<br>(misal: kimia, gas, dll)',
                    'options' => ['Tidak', 'Ya'],
                    'detail_trigger' => 'Ya',
                    'detail_field' => 'riwayat_pekerjaan_bahaya',
                    'detail_placeholder' => 'Sebutkan zat berbahaya',
                ],
                'berpergian' => [
                    'label' => 'Riwayat bepergian dalam satu bulan terakhir',
                    'options' => ['Tidak', 'Ya'],
                    'detail_trigger' => 'Ya',
                    'detail_field' => 'riwayat_pekerjaan_berpergian',
                    'detail_placeholder' => 'Sebutkan riwayat bepergian',
                ],
            ],
        ],
        'riwayat_kesehatan' => [
            'title' => 'Riwayat Kesehatan',
            'type' => 'mixed',
            'fields' => [
                'alergi_obat' => [
                    'type' => 'radio_with_detail',
                    'label' => 'Riwayat Alergi Obat',
                    'options' => ['Tidak Ada', 'Ada'],
                    'detail_trigger' => 'Ada',
                    'detail_field' => 'riwayat_alergi_obat',
                    'detail_placeholder' => 'Sebutkan alergi obat',
                ],
                'alergi_makanan' => [
                    'type' => 'radio_with_detail',
                    'label' => 'Riwayat Alergi Makanan',
                    'options' => ['Tidak Ada', 'Ada'],
                    'detail_trigger' => 'Ada',
                    'detail_field' => 'riwayat_alergi_makanan',
                    'detail_placeholder' => 'Sebutkan alergi makanan',
                ],
                'penyakit_dahulu' => [
                    'type' => 'select_multiple',
                    'label' => 'Riwayat Penyakit Dahulu',
                    'data_source' => 'personaldiseasehistories',
                ],
                'penyakit_keluarga' => [
                    'type' => 'select_multiple',
                    'label' => 'Riwayat Penyakit Dalam Keluarga',
                    'data_source' => 'familydiseasehistories',
                ],
            ],
        ],
        'pola_kebiasaan' => [
            'title' => 'Pola Kebiasaan',
            'type' => 'nested_radio',
            'fields' => [
                'nutrisi' => [
                    'label' => 'Nutrisi',
                    'options' => ['Cukup makan sayur/buah', 'Kurang makan sayur/buah', 'Tidak makan sayur/buah'],
                ],
                'istirahat' => [
                    'label' => 'Istirahat Cukup',
                    'options' => ['Tidak ada kelainan', 'Insomnia'],
                ],
                'aktivitas' => [
                    'label' => 'Aktivitas',
                    'options' => ['30 menit/hari', '<30 menit/hari'],
                ],
                'rokok' => [
                    'label' => 'Faktor risiko asap rokok',
                    'options' => ['Ya', 'Tidak', 'Perokok aktif', 'Perokok pasif'],
                ],
                'alkohol' => [
                    'label' => 'Minum alkohol',
                    'options' => ['Ya', 'Tidak'],
                ],
            ],
        ],
    ];
@endphp

<div class="tab-pane" id="psikososial" role="tabpanel" aria-labelledby="all-tab" data-kt-timeline-widget-4-blockui="true">
    <div class="card">
        <div class="card-body">
            <form method="POST" class="form" action="{{ route('examination.psikososial') }}">
                @method('POST')
                @csrf

                <input type="hidden" name="examination_id" value="{{ $examination->id }}">
                <input type="hidden" name="user_id" value="{{ $user->id }}">

                {{-- Kebutuhan Khusus Section --}}
                @include('pages.klinik.examinations.partials.components.radio-with-other', [
                    'section' => $formSections['kebutuhan_khusus'],
                    'psikososial' => $psikososial,
                ])

                {{-- Data Psikologi Dan Sosial Section --}}
                @include('pages.klinik.examinations.partials.components.multiple-radio', [
                    'section' => $formSections['psikologi_sosial'],
                    'psikososial' => $psikososial,
                ])

                {{-- Riwayat Pekerjaan Section --}}
                @include('pages.klinik.examinations.partials.components.nested-radio-with-detail', [
                    'section' => $formSections['riwayat_pekerjaan'],
                    'psikososial' => $psikososial,
                ])

                {{-- Riwayat Kesehatan Section --}}
                @include('pages.klinik.examinations.partials.components.mixed-form-section', [
                    'section' => $formSections['riwayat_kesehatan'],
                    'psikososial' => $psikososial,
                    'personaldiseasehistories' => $personaldiseasehistories,
                    'familydiseasehistories' => $familydiseasehistories,
                ])

                {{-- Pola Kebiasaan Section --}}
                @include('pages.klinik.examinations.partials.components.nested-radio', [
                    'section' => $formSections['pola_kebiasaan'],
                    'psikososial' => $psikososial,
                ])

                {{-- Actions --}}
                <div class="d-flex justify-content-end">
                    <a href="{{ route('examinations.index') }}" class="btn btn-light me-3">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary" data-kt-examinations-modal-action="submit">
                        <span class="indicator-label"><i class="fas fa-save"></i> Submit</span>
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('customscript')
    @include('pages.klinik.examinations.partials.scripts.psikososial-form')
@endpush
