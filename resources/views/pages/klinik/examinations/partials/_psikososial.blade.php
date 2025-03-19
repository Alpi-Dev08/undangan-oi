<div class="tab-pane" id="psikososial" role="tabpanel" aria-labelledby="all-tab" data-kt-timeline-widget-4-blockui="true">
    <div class="card">
        <div class="card-body">
            <form method="POST" class="form" action="{{ route('examination.psikososial') }}">
                @method('POST')
                @csrf
                @php
                    $psikososial = isset($examination->psikososial) ? json_decode($examination->psikososial) : null;
                @endphp

                <input type="hidden" name="examination_id" value="{{ $examination->id }}">
                <input type="hidden" name="user_id" value="{{ $user->id }}">

                <!--begin::Kebutuhan Khusus-->
                <div class="card card-custom gutter-b shadow-sm mb-5">
                    <div class="card-header bg-light">
                        <h3 class="card-title">Kebutuhan Khusus</h3>
                    </div>
                    <div class="card-body">
                        <div class="row g-5">
                            @php
                                $kebutuhanKhusus = ['Alat bantu Dengar', 'Kacamata', 'Tongkat', 'Kursi Roda', 'Disabilitas', 'Tidak Ada', 'Lainnya'];
                            @endphp

                            @foreach($kebutuhanKhusus as $index => $kebutuhan)
                                <div class="col-md-3">
                                    <label class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="radio" name="khusus" value="{{ $kebutuhan }}"
                                            {{ isset($psikososial->khusus) && $psikososial->khusus == $kebutuhan ? 'checked' : '' }}>
                                        <span class="form-check-label">{{ $kebutuhan }}</span>
                                    </label>
                                </div>
                            @endforeach

                            <div class="col-md-6" id="lainnya-text" style="display: {{ isset($psikososial->khusus) && $psikososial->khusus == 'Lainnya' ? 'block' : 'none' }}">
                                <div class="input-group">
                                    <span class="input-group-text">Lainnya:</span>
                                    <input type="text" class="form-control" name="lainnya"
                                        value="{{ isset($psikososial->khusus) && $psikososial->khusus == 'Lainnya' ? $psikososial->lainnya : '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Kebutuhan Khusus-->

                <!--begin::Data Psikologi Dan Sosial-->
                <div class="card card-custom gutter-b shadow-sm mb-5">
                    <div class="card-header bg-light">
                        <h3 class="card-title">Data Psikologi Dan Sosial</h3>
                    </div>
                    <div class="card-body">
                        @php
                            $psikososialData = [
                                'bicara' => ['label' => 'Bicara', 'options' => ['Jelas', 'Tidak Dimengerti']],
                                'komunikasi' => ['label' => 'Komunikasi', 'options' => ['Verbal', 'Non Verbal']],
                                'emosional' => ['label' => 'Status Emosional', 'options' => ['Stabil/Tenang', 'Marah', 'Cemas', 'Takut', 'Sedih']],
                                'nyeri' => ['label' => 'Nyeri Dada', 'options' => ['Tidak ada', 'Ada (Tingkat Sedang)', 'Nyeri dada kiri tembus punggung']],
                                'sosiologi' => ['label' => 'Sosiologi', 'options' => ['Komunikatif', 'Komunikatif Tidak Efek', 'Menarik Diri']]
                            ];
                        @endphp

                        @foreach($psikososialData as $key => $data)
                            <div class="row mb-5">
                                <label class="col-md-3 col-form-label">{{ $data['label'] }}</label>
                                <div class="col-md-9">
                                    <div class="row g-5">
                                        @foreach($data['options'] as $index => $option)
                                            <div class="col-md-4">
                                                <label class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="radio" name="{{ $key }}"
                                                        id="{{ $key }}_{{ $index }}" value="{{ $option }}"
                                                        {{ isset($psikososial->$key) && $psikososial->$key == $option ? 'checked' : '' }}>
                                                    <span class="form-check-label">{{ $option }}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!--end::Data Psikologi Dan Sosial-->

                

                <!--begin::Actions-->
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
                <!--end::Actions-->
            </form>
        </div>
    </div>
</div>

@push('customscript')
    <script>
        $(function() {
            // Fungsi untuk menampilkan/menyembunyikan input detail
            function toggleDetailInput(radioName, detailId) {
                const radios = document.getElementsByName(radioName);
                const detailInput = document.getElementById(detailId);

                radios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        if (this.value === 'Ya' && this.checked) {
                            detailInput.style.display = '';
                        } else if (this.value === 'Ada' && this.checked) {
                            detailInput.style.display = '';
                        } else if (this.value === 'Lainnya' && this.checked) {
                            detailInput.style.display = '';
                        } else {
                            detailInput.style.display = 'none';
                        }
                    });
                });
            }

            // Panggil fungsi untuk kedua set radio button
            toggleDetailInput('riwayat_pekerjaan[zat_bahaya]', 'zat_bahaya_detail');
            toggleDetailInput('riwayat_pekerjaan[berpergian]', 'bepergian_detail');
            toggleDetailInput('riwayat_kesehatan[alergi_obat]', 'alergi_obat_detail');
            toggleDetailInput('riwayat_kesehatan[alergi_makanan]', 'alergi_makanan_detail');
            toggleDetailInput('khusus', 'lainnya-text');
        });
    </script>
@endpush
