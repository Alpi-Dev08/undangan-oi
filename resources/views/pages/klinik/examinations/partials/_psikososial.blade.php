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
                                $kebutuhanKhusus = [
                                    'Alat bantu Dengar',
                                    'Kacamata',
                                    'Tongkat',
                                    'Kursi Roda',
                                    'Disabilitas',
                                    'Tidak Ada',
                                    'Lainnya',
                                ];
                            @endphp

                            @foreach ($kebutuhanKhusus as $index => $kebutuhan)
                                <div class="col-md-3">
                                    <label class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="radio" name="khusus"
                                            value="{{ $kebutuhan }}"
                                            {{ isset($psikososial->khusus) && $psikososial->khusus == $kebutuhan ? 'checked' : '' }}>
                                        <span class="form-check-label">{{ $kebutuhan }}</span>
                                    </label>
                                </div>
                            @endforeach

                            <div class="col-md-6" id="lainnya-text"
                                style="display: {{ isset($psikososial->khusus) && $psikososial->khusus == 'Lainnya' ? 'block' : 'none' }}">
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
                                'emosional' => [
                                    'label' => 'Status Emosional',
                                    'options' => ['Stabil/Tenang', 'Marah', 'Cemas', 'Takut', 'Sedih'],
                                ],
                                'nyeri' => [
                                    'label' => 'Nyeri Dada',
                                    'options' => [
                                        'Tidak ada',
                                        'Ada (Tingkat Sedang)',
                                        'Nyeri dada kiri tembus punggung',
                                    ],
                                ],
                                'sosiologi' => [
                                    'label' => 'Sosiologi',
                                    'options' => ['Komunikatif', 'Komunikatif Tidak Efek', 'Menarik Diri'],
                                ],
                            ];
                        @endphp

                        @foreach ($psikososialData as $key => $data)
                            <div class="row mb-5">
                                <label class="col-md-3 col-form-label">{{ $data['label'] }}</label>
                                <div class="col-md-9">
                                    <div class="row g-5">
                                        @foreach ($data['options'] as $index => $option)
                                            <div class="col-md-4">
                                                <label class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="radio"
                                                        name="{{ $key }}"
                                                        id="{{ $key }}_{{ $index }}"
                                                        value="{{ $option }}"
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

                <!--begin::Riwayat Pekerjaan-->
                <div class="card card-custom gutter-b shadow-sm mb-5">
                    <div class="card-header bg-light">
                        <h3 class="card-title">Riwayat Pekerjaan</h3>
                    </div>
                    <div class="card-body">
                        <!--begin::Zat Berbahaya-->
                        <div class="row mb-5">
                            <label class="col-md-3 col-form-label">Apakah pekerjaan pasien berhubungan dengan zat
                                berbahaya<br>(misal: kimia, gas, dll)</label>
                            <div class="col-md-9">
                                <div class="row g-5">
                                    <div class="col-md-4">
                                        <label class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="radio"
                                                name="riwayat_pekerjaan[zat_bahaya]" id="riwayat_pekerjaan_tidak"
                                                value="Tidak"
                                                {{ isset($psikososial->riwayat_pekerjaan) && $psikososial->riwayat_pekerjaan->zat_bahaya == 'Tidak' ? 'checked' : '' }}>
                                            <span class="form-check-label">Tidak</span>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="radio"
                                                name="riwayat_pekerjaan[zat_bahaya]" id="riwayat_pekerjaan_ya"
                                                value="Ya"
                                                {{ isset($psikososial->riwayat_pekerjaan) && $psikososial->riwayat_pekerjaan->zat_bahaya == 'Ya' ? 'checked' : '' }}>
                                            <span class="form-check-label">Ya</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="mt-2" id="zat_bahaya_detail"
                                    style="{{ isset($psikososial->riwayat_pekerjaan) && $psikososial->riwayat_pekerjaan->zat_bahaya == 'Ya' ? '' : 'display: none;' }}">
                                    <input type="text" class="form-control" name="riwayat_pekerjaan_bahaya"
                                        placeholder="Sebutkan zat berbahaya"
                                        value="{{ isset($psikososial->riwayat_pekerjaan) && $psikososial->riwayat_pekerjaan->zat_bahaya == 'Ya' ? $psikososial->riwayat_pekerjaan_bahaya : '' }}">
                                </div>
                            </div>
                        </div>
                        <!--end::Zat Berbahaya-->

                        <!--begin::Riwayat Bepergian-->
                        <div class="row mb-5">
                            <label class="col-md-3 col-form-label">Riwayat bepergian dalam satu bulan terakhir</label>
                            <div class="col-md-9">
                                <div class="row g-5">
                                    <div class="col-md-4">
                                        <label class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="radio"
                                                name="riwayat_pekerjaan[berpergian]" id="riwayat_bepergian_tidak"
                                                value="Tidak"
                                                {{ isset($psikososial->riwayat_pekerjaan) && $psikososial->riwayat_pekerjaan->berpergian == 'Tidak' ? 'checked' : '' }}>
                                            <span class="form-check-label">Tidak</span>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="radio"
                                                name="riwayat_pekerjaan[berpergian]" id="riwayat_bepergian_ya"
                                                value="Ya"
                                                {{ isset($psikososial->riwayat_pekerjaan) && $psikososial->riwayat_pekerjaan->berpergian == 'Ya' ? 'checked' : '' }}>
                                            <span class="form-check-label">Ya</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="mt-2" id="bepergian_detail"
                                    style="{{ isset($psikososial->riwayat_pekerjaan) && $psikososial->riwayat_pekerjaan->berpergian == 'Ya' ? '' : 'display: none;' }}">
                                    <input type="text" class="form-control" name="riwayat_pekerjaan_berpergian"
                                        placeholder="Sebutkan riwayat bepergian"
                                        value="{{ isset($psikososial->riwayat_pekerjaan) && $psikososial->riwayat_pekerjaan->berpergian == 'Ya' ? $psikososial->riwayat_pekerjaan_berpergian : '' }}">
                                </div>
                            </div>
                        </div>
                        <!--end::Riwayat Bepergian-->
                    </div>
                </div>
                <!--end::Riwayat Pekerjaan-->

                <!--begin::Riwayat Kesehatan-->
                <div class="card card-custom gutter-b shadow-sm mb-5">
                    <div class="card-header bg-light">
                        <h3 class="card-title">Riwayat Kesehatan</h3>
                    </div>
                    <div class="card-body">
                        <!--begin::Riwayat Alergi Obat-->
                        <div class="row mb-5">
                            <label class="col-md-3 col-form-label">Riwayat Alergi Obat</label>
                            <div class="col-md-9">
                                <div class="row g-5">
                                    <div class="col-md-4">
                                        <label class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="radio"
                                                name="riwayat_kesehatan[alergi_obat]" id="riwayat_kesehatan_satu"
                                                value="Tidak Ada"
                                                {{ isset($psikososial->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->alergi_obat == 'Tidak Ada' ? 'checked' : '' }}>
                                            <span class="form-check-label">Tidak Ada</span>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="radio"
                                                name="riwayat_kesehatan[alergi_obat]" id="riwayat_kesehatan_dua"
                                                value="Ada"
                                                {{ isset($psikososial->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->alergi_obat == 'Ada' ? 'checked' : '' }}>
                                            <span class="form-check-label">Ada</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="mt-2" id="alergi_obat_detail"
                                    style="{{ isset($psikososial->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->alergi_obat == 'Ada' ? '' : 'display: none;' }}">
                                    <input type="text" class="form-control" name="riwayat_alergi_obat"
                                        placeholder="Sebutkan alergi obat"
                                        value="{{ isset($psikososial->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->alergi_obat == 'Ada' ? $psikososial->riwayat_alergi_obat : '' }}">
                                </div>
                            </div>
                        </div>
                        <!--end::Riwayat Alergi Obat-->

                        <!--begin::Riwayat Alergi Makanan-->
                        <div class="row mb-5">
                            <label class="col-md-3 col-form-label">Riwayat Alergi Makanan</label>
                            <div class="col-md-9">
                                <div class="row g-5">
                                    <div class="col-md-4">
                                        <label class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="radio"
                                                name="riwayat_kesehatan[alergi_makanan]" id="riwayat_kesehatan_tiga"
                                                value="Tidak Ada"
                                                {{ isset($psikososial->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->alergi_makanan == 'Tidak Ada' ? 'checked' : '' }}>
                                            <span class="form-check-label">Tidak Ada</span>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="radio"
                                                name="riwayat_kesehatan[alergi_makanan]" id="riwayat_kesehatan_empat"
                                                value="Ada"
                                                {{ isset($psikososial->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->alergi_makanan == 'Ada' ? 'checked' : '' }}>
                                            <span class="form-check-label">Ada</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="mt-2" id="alergi_makanan_detail"
                                    style="{{ isset($psikososial->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->alergi_makanan == 'Ada' ? '' : 'display: none;' }}">
                                    <input type="text" class="form-control" name="riwayat_alergi_makanan"
                                        placeholder="Sebutkan alergi makanan"
                                        value="{{ isset($psikososial->riwayat_kesehatan) && $psikososial->riwayat_kesehatan->alergi_makanan == 'Ada' ? $psikososial->riwayat_alergi_makanan : '' }}">
                                </div>
                            </div>
                        </div>
                        <!--end::Riwayat Alergi Makanan-->

                        <!--begin::Riwayat Penyakit Dahulu-->
                        <div class="row mb-5">
                            <label class="col-md-3 col-form-label">Riwayat Penyakit Dahulu</label>
                            <div class="col-md-9">
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-placeholder="Pilih Riwayat Penyakit" data-allow-clear="true"
                                    multiple="multiple" name="riwayat_kesehatan[penyakit_dahulu][]"
                                    id="previous_disease">
                                    <option></option>
                                    @foreach ($personaldiseasehistories as $disease)
                                        <option value="{{ $disease->code }}"
                                            {{ (is_array($psikososial->riwayat_kesehatan->penyakit_dahulu ?? null) &&
                                                in_array($disease->code, $psikososial->riwayat_kesehatan->penyakit_dahulu)) ||
                                            ($psikososial->riwayat_kesehatan->penyakit_dahulu ?? '') == $disease->code
                                                ? 'selected'
                                                : '' }}>
                                            {{ $disease->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!--end::Riwayat Penyakit Dahulu-->

                        <!--begin::Riwayat Penyakit Dalam Keluarga-->
                        <div class="row mb-5">
                            <label class="col-md-3 col-form-label">Riwayat Penyakit Dalam Keluarga</label>
                            <div class="col-md-9">
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-placeholder="Pilih Riwayat Penyakit Keluarga" data-allow-clear="true"
                                    multiple="multiple" name="riwayat_kesehatan[penyakit_keluarga][]">
                                    <option></option>
                                    @foreach ($familydiseasehistories as $disease)
                                        <option value="{{ $disease->code }}"
                                            {{ (is_array($psikososial->riwayat_kesehatan->penyakit_keluarga ?? null) &&
                                                in_array($disease->code, $psikososial->riwayat_kesehatan->penyakit_keluarga)) ||
                                            ($psikososial->riwayat_kesehatan->penyakit_keluarga ?? '') == $disease->code
                                                ? 'selected'
                                                : '' }}>
                                            {{ $disease->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!--end::Riwayat Penyakit Dalam Keluarga-->
                    </div>
                </div>
                <!--end::Riwayat Kesehatan-->

                <!--begin::Pola Kebiasaan-->
                <div class="card card-custom gutter-b shadow-sm mb-5">
                    <div class="card-header bg-light">
                        <h3 class="card-title">
                            Pola Kebiasaan
                        </h3>
                    </div>
                    <div class="card-body">
                        <!--begin::Nutrisi-->
                        <div class="row mb-5">
                            <label class="col-md-3 col-form-label">Nutrisi</label>
                            <div class="col-md-9">
                                <div class="row g-5">
                                    <div class="col-md-4">
                                        <label class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="radio"
                                                name="pola_kebiasaan[nutrisi]" id="nutrisi_satu"
                                                value="Cukup makan sayur/buah"
                                                {{ isset($psikososial->pola_kebiasaan) && isset($psikososial->pola_kebiasaan->nutrisi) && $psikososial->pola_kebiasaan->nutrisi == 'Cukup makan sayur/buah' ? 'checked' : '' }}>
                                            <span class="form-check-label">Cukup makan sayur/buah</span>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="radio"
                                                name="pola_kebiasaan[nutrisi]" id="nutrisi_dua"
                                                value="Kurang makan sayur/buah"
                                                {{ isset($psikososial->pola_kebiasaan) && isset($psikososial->pola_kebiasaan->nutrisi) && $psikososial->pola_kebiasaan->nutrisi == 'Kurang makan sayur/buah' ? 'checked' : '' }}>
                                            <span class="form-check-label">Kurang makan sayur/buah</span>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="radio"
                                                name="pola_kebiasaan[nutrisi]" id="nutrisi_tiga"
                                                value="Tidak makan sayur/buah"
                                                {{ isset($psikososial->pola_kebiasaan) && isset($psikososial->pola_kebiasaan->nutrisi) && $psikososial->pola_kebiasaan->nutrisi == 'Tidak makan sayur/buah' ? 'checked' : '' }}>
                                            <span class="form-check-label">Tidak makan sayur/buah</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Nutrisi-->

                        <!--begin::Istirahat Cukup-->
                        <div class="row mb-5">
                            <label class="col-md-3 col-form-label">Istirahat Cukup</label>
                            <div class="col-md-9">
                                <div class="row g-5">
                                    <div class="col-md-4">
                                        <label class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="radio"
                                                name="pola_kebiasaan[istirahat]" id="istirahat_satu"
                                                value="Tidak ada kelainan"
                                                {{ isset($psikososial->pola_kebiasaan) && isset($psikososial->pola_kebiasaan->istirahat) && $psikososial->pola_kebiasaan->istirahat == 'Tidak ada kelainan' ? 'checked' : '' }}>
                                            <span class="form-check-label">Tidak ada kelainan</span>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="radio"
                                                name="pola_kebiasaan[istirahat]" id="istirahat_dua" value="Insomnia"
                                                {{ isset($psikososial->pola_kebiasaan) && isset($psikososial->pola_kebiasaan->istirahat) && $psikososial->pola_kebiasaan->istirahat == 'Insomnia' ? 'checked' : '' }}>
                                            <span class="form-check-label">Insomnia</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Istirahat Cukup-->

                        <!--begin::Aktivitas-->
                        <div class="row mb-5">
                            <label class="col-md-3 col-form-label">Aktivitas</label>
                            <div class="col-md-9">
                                <div class="row g-5">
                                    <div class="col-md-4">
                                        <label class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="radio"
                                                name="pola_kebiasaan[aktivitas]" id="aktivitas_satu"
                                                value="30 menit/hari"
                                                {{ isset($psikososial->pola_kebiasaan) && isset($psikososial->pola_kebiasaan->aktivitas) && $psikososial->pola_kebiasaan->aktivitas == '30 menit/hari' ? 'checked' : '' }}>
                                            <span class="form-check-label">30 menit/hari</span>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="radio"
                                                name="pola_kebiasaan[aktivitas]" id="aktivitas_dua"
                                                value="<30 menit/hari"
                                                {{ isset($psikososial->pola_kebiasaan) && isset($psikososial->pola_kebiasaan->aktivitas) && $psikososial->pola_kebiasaan->aktivitas == '<30 menit/hari' ? 'checked' : '' }}>
                                            <span class="form-check-label">
                                                <30 menit/hari</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Aktivitas-->

                        <!--begin::Faktor risiko asap rokok-->
                        <div class="row mb-5">
                            <label class="col-md-3 col-form-label">Faktor risiko asap rokok</label>
                            <div class="col-md-9">
                                <div class="row g-5">
                                    @php
                                        $rokokOptions = ['Ya', 'Tidak', 'Perokok aktif', 'Perokok pasif'];
                                    @endphp
                                    @foreach ($rokokOptions as $option)
                                        <div class="col-md-4">
                                            <label class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio"
                                                    name="pola_kebiasaan[rokok]" value="{{ $option }}"
                                                    {{ isset($psikososial->pola_kebiasaan) && isset($psikososial->pola_kebiasaan->rokok) && $psikososial->pola_kebiasaan->rokok == $option ? 'checked' : '' }}>
                                                <span class="form-check-label">{{ $option }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!--end::Faktor risiko asap rokok-->

                        <!--begin::Minum alkohol-->
                        <div class="row mb-5">
                            <label class="col-md-3 col-form-label">Minum alkohol</label>
                            <div class="col-md-9">
                                <div class="row g-5">
                                    @php
                                        $alkoholOptions = ['Ya', 'Tidak'];
                                    @endphp
                                    @foreach ($alkoholOptions as $option)
                                        <div class="col-md-4">
                                            <label class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio"
                                                    name="pola_kebiasaan[alkohol]" value="{{ $option }}"
                                                    {{ isset($psikososial->pola_kebiasaan) && isset($psikososial->pola_kebiasaan->alkohol) && $psikososial->pola_kebiasaan->alkohol == $option ? 'checked' : '' }}>
                                                <span class="form-check-label">{{ $option }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!--end::Minum alkohol-->
                    </div>
                </div>
                <!--end::Pola Kebiasaan-->


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
