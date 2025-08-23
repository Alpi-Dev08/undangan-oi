<div class="tab-pane fade" id="persetujuan" role="tabpanel">
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-light-success">
            <h3 class="d-flex align-items-center">Persetujuan Tindakan Medis</h3>
        </div>
        <div class="card-body p-4">
            <form method="post" action="{{ route('suket.persetujuan', $examination->id) }}" class="form">
                @csrf
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card card-bordered border-gray-300 mb-4">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-3">Informasi Dokter</h5>
                                <div class="d-flex flex-column">
                                    <div class="d-flex align-items-center mb-3">
                                        <span class="fw-bold text-gray-700 min-w-150px">Dokter Pelaksana Tindakan</span>
                                        <span class="text-gray-800">:
                                            {{ $examination->health_profesional?->user?->name }}{{ isset($examination->health_profesional->user->info) && !in_array($examination->health_profesional->user->info->title_prefix, ['', '-']) ? ', ' . $examination->health_profesional->user->info->title_prefix . '.' : '' }}{{ isset($examination->health_profesional->user->info) && !in_array($examination->health_profesional->user->info->title_suffix, ['', '-']) ? ', ' . $examination->health_profesional->user->info->title_suffix : '' }}</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="fw-bold text-gray-700 min-w-150px">Nomor SIP</span>
                                        <span class="text-gray-800">:
                                            {{ $examination->health_profesional?->sip_number ? 'SIP.' . $examination->health_profesional->sip_number : '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card card-bordered border-gray-300 mb-4">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-3">Data Pasien</h5>
                                <div class="row g-4">
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex flex-column">
                                            <label for="nama_pasien" class="form-label fw-bold mb-2">Nama</label>
                                            <input type="text" name="nama_pasien" id="nama_pasien"
                                                class="form-control form-control-solid" placeholder="Nama">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex flex-column">
                                            <label for="tempat_tgl" class="form-label fw-bold mb-2">Tempat, Tanggal
                                                Lahir</label>
                                            <input type="text" name="tempat_tgl" id="tempat_tgl"
                                                class="form-control form-control-solid"
                                                placeholder="Tempat, Tanggal Lahir">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex flex-column">
                                            <label for="jenis_kel" class="form-label fw-bold mb-2">Jenis Kelamin</label>
                                            <input type="text" name="jenis_kel" id="jenis_kel"
                                                class="form-control form-control-solid" placeholder="Jenis Kelamin">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex flex-column">
                                            <label for="alamat_pas" class="form-label fw-bold mb-2">Alamat</label>
                                            <input type="text" name="alamat_pas" id="alamat_pas"
                                                class="form-control form-control-solid" placeholder="Alamat">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex flex-column">
                                            <label for="terhadap" class="form-label fw-bold mb-2">Tindakan
                                                Terhadap</label>
                                            <input type="text" value="Saya" name="terhadap" id="terhadap"
                                                class="form-control form-control-solid" placeholder="Saya">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card card-bordered border-gray-300 mb-4">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-3">Data Pasien (Sistem)</h5>
                                <div class="d-flex flex-column">
                                    <div class="d-flex align-items-center mb-3">
                                        <span class="fw-bold text-gray-700 min-w-150px">Nama</span>
                                        <span class="text-gray-800">:
                                            {{ (!in_array($user->info->title_prefix, ['', '-']) ? $user->info->title_prefix . '. ' : '') . $user->name . (!in_array($user->info->title_suffix, ['', '-']) ? ', ' . $user->info->title_suffix : '') }}</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span class="fw-bold text-gray-700 min-w-150px">Tempat, Tanggal Lahir</span>
                                        <span class="text-gray-800">:
                                            {{ $info->place_of_birth . ', ' . $info->date_of_birth }}</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span class="fw-bold text-gray-700 min-w-150px">Jenis Kelamin</span>
                                        <span class="text-gray-800">:
                                            {{ isset($info->gender) ? $info->gender->name : '' }}</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="fw-bold text-gray-700 min-w-150px">Alamat</span>
                                        <span class="text-gray-800">:
                                            {{ $info->address }}{{ isset($info->subdistrict) ? ', ' . $info->subdistrict->name : '' }}{{ isset($info->district) ? ', ' . $info->district->name : '' }}{{ isset($info->city) ? ', ' . $info->city->name : '' }}{{ isset($info->province) ? ', ' . $info->province->name : '' }}{{ isset($info->country) ? ', ' . $info->country->name : '' }}{{ $info->postal_code != '' ? $info->postal_code : (isset($info->subdistrict) ? ' - ' . $info->subdistrict->postal_code : '') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <label for="diagnosis" class="form-label fw-bold mb-2">Diagnosis (WD & DD)</label>
                            <input type="text" name="diagnosis" id="diagnosis"
                                class="form-control form-control-solid" placeholder="Isi Informasi">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <label for="dasar_diagnosis" class="form-label fw-bold mb-2">Dasar Diagnosis</label>
                            <input type="text" name="dasar_diagnosis" id="dasar_diagnosis"
                                class="form-control form-control-solid" placeholder="Isi Informasi">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <label for="tindakan" class="form-label fw-bold mb-2">Tindakan Kedokteran</label>
                            <input type="text" name="tindakan" id="tindakan"
                                class="form-control form-control-solid" placeholder="Isi Informasi">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <label for="tatacara" class="form-label fw-bold mb-2">Tata Cara</label>
                            <input type="text" name="tatacara" id="tatacara"
                                class="form-control form-control-solid" placeholder="Isi Informasi">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <label for="tujuan" class="form-label fw-bold mb-2">Tujuan</label>
                            <input type="text" name="tujuan" id="tujuan"
                                class="form-control form-control-solid" placeholder="Isi Informasi">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <label for="resiko" class="form-label fw-bold mb-2">Alternatif dan Resiko</label>
                            <input type="text" name="resiko" id="resiko"
                                class="form-control form-control-solid" placeholder="Isi Informasi">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <label for="komplikasi" class="form-label fw-bold mb-2">Resiko dan Komplikasi</label>
                            <input type="text" name="komplikasi" id="komplikasi"
                                class="form-control form-control-solid" placeholder="Isi Informasi">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <label for="prognosis" class="form-label fw-bold mb-2">Prognosis</label>
                            <input type="text" name="prognosis" id="prognosis"
                                class="form-control form-control-solid" placeholder="Isi Informasi">
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <label class="form-label fw-bold mb-2">Tanda Tangan</label>
                            <div class="card card-bordered border-gray-300 p-3">
                                <canvas id="signature-pad_1" name="signature"
                                    style="border:1px solid #ddd; width: 100%; max-width: 300px; height: auto; max-height: 100px;"></canvas>
                                <input type="hidden" name="signature" id="signature-data1">
                                <div class="d-flex justify-content-between mt-3">
                                    <button id="clear1" class="btn btn-light-secondary"
                                        type="button">Clear</button>
                                    <button id="save1" class="btn btn-light-primary" type="button">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="separator separator-dashed my-5"></div>

                <div class="mb-5">
                    <h4 class="fw-bold fs-6 mb-3">Persetujuan Tindakan</h4>

                    <div class="card card-bordered border-gray-300 mb-3 hover-elevate-up shadow-sm">
                        <div class="card-body py-3">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" id="Setuju" name="persetujuan"
                                    value="setuju" onchange="toggleAlasan()" />
                                <label class="form-check-label fw-semibold text-black" for="Setuju">
                                    Setuju dengan Tindakan yang telah dijelaskan
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="card card-bordered border-gray-300 mb-3 hover-elevate-up shadow-sm">
                        <div class="card-body py-3">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" id="Tidak Setuju" name="persetujuan"
                                    value="Tidak Setuju" onchange="toggleAlasan()" />
                                <label class="form-check-label fw-semibold text-black" for="Tidak Setuju">
                                    Tidak Setuju dengan Tindakan yang telah dijelaskan
                                </label>
                            </div>
                        </div>
                    </div>

                    <div id="alasanContainer" style="display: none;" class="mb-5">
                        <label for="description" class="form-label fw-bold">Alasan :</label>
                        <textarea rows="3" class="form-control form-control-solid" placeholder="Alasan" name="description"></textarea>
                    </div>
                </div>

                <script>
                    function toggleAlasan() {
                        const tidakSetujuCheckbox = document.getElementById('Tidak Setuju');
                        const alasanContainer = document.getElementById('alasanContainer');

                        if (tidakSetujuCheckbox.checked) {
                            alasanContainer.style.display = 'block';
                        } else {
                            alasanContainer.style.display = 'none';
                        }
                    }
                </script>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-6">
                        <i class="fas fa-file-pdf me-2"></i>Download PDF
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
