<x-base-layout>
    @if(Auth::user()->hasRole(['admin','administrator']))
        <div class="row g-5">
            <div class="col-xl-8">
                <div class="card card-flush h-xl-100">
                    <div class="card-header pt-7">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-dark">Formulir Skala Get Up and Go Test</span>
                            <span class="text-muted mt-1 fw-semibold fs-7">Evaluasi risiko jatuh pasien</span>
                        </h3>
                    </div>
                    <div class="card-body pt-5">
                        <form id="gotest" method="POST" class="form" action="{{ route('patients.pretest') }}">
                            @csrf
                            <div class="mb-10">
                                <label class="form-label fw-semibold">1. Keseimbangan Pasien:</label>
                                <div class="d-flex align-items-center mb-3">
                                    <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Apakah pasien tampak tidak seimbang atau menggunakan alat bantu?</span>
                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input h-20px w-30px" type="checkbox" value="ya" name="kriteria_satu" id="kriteria_satu"/>
                                        <label class="form-check-label" for="kriteria_satu">Ya</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-10">
                                <label class="form-label fw-semibold">2. Penggunaan Bantuan:</label>
                                <div class="d-flex align-items-center">
                                    <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Apakah pasien memegang benda untuk bantuan saat berjalan?</span>
                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input h-20px w-30px" type="checkbox" value="ya" name="kriteria_dua" id="kriteria_dua"/>
                                        <label class="form-check-label" for="kriteria_dua">Ya</label>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="interpretasi" id="_interpretasi">
                            <input type="hidden" name="tindakan" id="_tindakan">

                            <div id="keterangan" class="border border-dashed border-gray-300 p-6 rounded mb-5">
                                <h4 class="fw-bold mb-3">Hasil Evaluasi:</h4>
                                <p class="mb-2">Interpretasi: <span id="interpretasi" class="fw-bold"></span></p>
                                <p>Tindakan: <span id="tindakan" class="fw-bold"></span></p>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary" id="kt_assessment_submit">
                                    <span class="indicator-label">Simpan Hasil</span>
                                    <span class="indicator-progress">Mohon tunggu...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card card-flush h-xl-100">
                    <div class="card-body d-flex flex-column p-10">
                        <div class="mb-5">
                            <img src="{{ asset('assets/media/illustrations/satusehat.png') }}" class="mw-100 mh-200px" alt="Satu Sehat Logo">
                        </div>
                        <h3 class="text-dark mb-5">Verifikasi Satu Sehat Mobile</h3>
                        <div class="fs-6 text-gray-600 mb-5">Klik tombol di bawah untuk memverifikasi akun Satu Sehat Mobile Anda.</div>
                        @if(isset($kyc_iframe))
                            <a href="{{ route('kycurl') }}" class="btn btn-primary" target="_blank">
                                <i class="fas fa-check-circle me-2"></i>Verifikasi Sekarang
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @push('customscript')
            <script>
                $(function () {
                    const interpretasiEl = $("#interpretasi");
                    const tindakanEl = $("#tindakan");
                    const _interpretasiEl = $("#_interpretasi");
                    const _tindakanEl = $("#_tindakan");

                    function updateAssessment() {
                        const kriteriaSatu = $('#kriteria_satu').is(':checked');
                        const kriteriaDua = $('#kriteria_dua').is(':checked');

                        if (kriteriaSatu && kriteriaDua) {
                            setAssessment('Berisiko Tinggi', 'pemberian gelang kuning, edukasi, pendampingan dan pemberian fasilitas (kursi roda, tripod)', 'danger');
                        } else if (kriteriaSatu || kriteriaDua) {
                            setAssessment('Berisiko Rendah', 'edukasi pasien dan / atau keluarga', 'warning');
                        } else {
                            setAssessment('Tidak Beresiko Jatuh', '-', 'success');
                        }
                    }

                    function setAssessment(interpretasi, tindakan, severity) {
                        interpretasiEl.text(interpretasi).removeClass('text-success text-warning text-danger').addClass(`text-${severity}`);
                        tindakanEl.text(tindakan).removeClass('text-success text-warning text-danger').addClass(`text-${severity}`);
                        _interpretasiEl.val(interpretasi);
                        _tindakanEl.val(tindakan);
                    }

                    $("#kriteria_satu, #kriteria_dua").change(updateAssessment);

                    updateAssessment(); // Initial assessment

                    // Form submission with loading indicator
                    const form = document.getElementById('gotest');
                    const submitButton = document.getElementById('kt_assessment_submit');
                    form.addEventListener('submit', function (e) {
                        e.preventDefault();
                        submitButton.setAttribute('data-kt-indicator', 'on');
                        submitButton.disabled = true;

                        setTimeout(function () {
                            form.submit();
                        }, 2000);
                    });
                });
            </script>
        @endpush

        @if(session('error'))
            @push('customscript')
                <script>
                    toastr.error("{{ session('error') }}", "Error");
                </script>
            @endpush
        @endif

    @endif
</x-base-layout>
