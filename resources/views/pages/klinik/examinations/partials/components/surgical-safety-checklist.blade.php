<div class="tab-pane fade" id="surgicalsafetychecklist" role="tabpanel">
    <div class="card shadow-sm">
        <div class="card-header bg-primary">
            <h3 class="card-title text-white fs-3 fw-bold mb-0">SURGICAL SAFETY CHECKLIST</h3>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('suket.surgicalsafetychecklist', $examination->id) }}">
                @csrf <!-- CSRF Token to prevent 419 error -->
                <div class="row g-4">

                    <!-- Informasi Pasien -->
                    <div class="col-12">
                        <div class="card border border-gray-300">
                            <div class="card-body">
                                <h5 class="card-title text-primary mb-3">Informasi Pasien</h5>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Nama:</label>
                                        <p class="mb-0">
                                            {{ (!in_array($user->info->title_prefix, ['', '-']) ? $user->info->title_prefix . '. ' : '') . $user->name . (!in_array($user->info->title_suffix, ['', '-']) ? ', ' . $user->info->title_suffix : '') }}
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Tempat, Tanggal Lahir:</label>
                                        <p class="mb-0">{{ $info->place_of_birth . ', ' . $info->date_of_birth }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Nomor RM:</label>
                                        <p class="mb-0">{{ $user->mr->medical_record_code }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- SIGN IN Section -->
                    <div class="col-12">
                        <div class="separator separator-dashed my-4"></div>
                        <h4 class="text-primary fw-bold mb-4">SIGN IN (Sebelum induksi anestesi)</h4>
                    </div>
                    <!-- Verifikasi -->
                    <div class="col-12">
                        <div class="card border border-gray-300">
                            <div class="card-body">
                                <h5 class="card-title text-primary mb-3">VERIFIKASI</h5>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" name="identitas_pasien"
                                                id="identitas_pasien" checked>
                                            <label class="form-check-label fw-semibold" for="identitas_pasien">
                                                Identitas pasien (nama lengkap dan tanggal lahir) dan gelang pasien
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" name="inform_consnet"
                                                id="inform_consnet" checked>
                                            <label class="form-check-label fw-semibold" for="inform_consnet">
                                                Inform Consent
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Dokter Pelaksana Tindakan -->
                    <div class="col-12">
                        <div class="card border border-gray-300">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Dokter Pelaksana Tindakan:</label>
                                        <p class="mb-0">
                                            {{ $examination->health_profesional &&
                                            $examination->health_profesional->user &&
                                            $examination->health_profesional->user->info
                                                ? (!in_array($examination->health_profesional->user->info->title_prefix, ['', '-'])
                                                        ? $examination->health_profesional->user->info->title_prefix . '. '
                                                        : '') .
                                                    $examination->health_profesional->user->name .
                                                    (!in_array($examination->health_profesional->user->info->title_suffix, ['', '-'])
                                                        ? ', ' . $examination->health_profesional->user->info->title_suffix
                                                        : '')
                                                : '-' }}
                                            <br>
                                            <strong>{{ $examination->health_profesional && $examination->health_profesional->sip_number
                                                ? 'SIP.' . $examination->health_profesional->sip_number
                                                : '' }}</strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Form Input Data Operasi -->
                    <div class="col-12">
                        <div class="card border border-gray-300">
                            <div class="card-body">
                                <h5 class="card-title text-primary mb-3">Data Operasi</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Nama Operator</label>
                                        <input type="text" name="nama_operator"
                                            class="form-control form-control-solid border border-gray-300"
                                            placeholder="Masukkan nama operator">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Nama Tindakan</label>
                                        <input type="text" name="nama_tindakan"
                                            class="form-control form-control-solid border border-gray-300"
                                            placeholder="Masukkan nama tindakan">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-bold">Diagnosa</label>
                                        <input type="text" name="diagnosa"
                                            class="form-control form-control-solid border border-gray-300"
                                            placeholder="Masukkan diagnosa">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Pemberian Tanda di Lokasi Operasi -->
                    <div class="col-12">
                        <div class="card border border-gray-300">
                            <div class="card-body">
                                <h5 class="card-title text-primary mb-3">Pemberian Tanda di Lokasi Operasi</h5>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio" id="perdarahanYa"
                                                name="perdarahan" value="Ya" checked>
                                            <label class="form-check-label fw-semibold" for="perdarahanYa">Ya</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio" id="perdarahanTidak"
                                                name="perdarahan" value="Tidak perlu">
                                            <label class="form-check-label fw-semibold" for="perdarahanTidak">Tidak
                                                perlu</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Pemeriksaan Kelengkapan Anestesi -->
                    <div class="col-12">
                        <div class="card border border-gray-300">
                            <div class="card-body">
                                <h5 class="card-title text-primary mb-3">PEMERIKSAAN KELENGKAPAN ANESTESI</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="checkbox" id="mesinAnestesi"
                                                name="kelengkapan_anestesi_mesin" value="Mesin Anestesi" />
                                            <label class="form-check-label fw-semibold" for="mesinAnestesi">Mesin
                                                Anestesi</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="checkbox" id="obatObatan"
                                                name="kelengkapan_anestesi_obat" value="Obat - obatan" checked />
                                            <label class="form-check-label fw-semibold" for="obatObatan">Obat -
                                                obatan</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="checkbox" id="laboratorium"
                                                name="kelengkapan_anestesi_laboratorium" value="Laboratorium" />
                                            <label class="form-check-label fw-semibold"
                                                for="laboratorium">Laboratorium</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="checkbox" id="ivLine"
                                                name="kelengkapan_anestesi_ivline" value="IV Line" />
                                            <label class="form-check-label fw-semibold" for="ivLine">IV Line</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pemeriksaan Tanda Vital -->
                    <div class="col-12">
                        <div class="card border border-gray-300">
                            <div class="card-body">
                                <h5 class="card-title text-primary mb-3">PEMERIKSAAN TANDA VITAL</h5>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Tekanan Darah:</label>
                                        <p class="mb-0">{{ $examination->vitality->blood_pressure ?? '-' }} mmHg</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Nadi:</label>
                                        <p class="mb-0">{{ $examination->vitality->heart_rate ?? '-' }} kali/menit
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Pernafasan:</label>
                                        <p class="mb-0">{{ $examination->vitality->respiratory_rate ?? '-' }}
                                            kali/menit</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Saturasi O2:</label>
                                        <p class="mb-0">{{ $examination->vitality->oxygen_saturation ?? '-' }} %</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Suhu:</label>
                                        <p class="mb-0">{{ $examination->vitality->temperature ?? '-' }} °C</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Riwayat Alergi -->
                    <div class="col-12">
                        <div class="card border border-gray-300">
                            <div class="card-body">
                                <h5 class="card-title text-primary mb-3">RIWAYAT ALERGI</h5>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio" id="alergiAda"
                                                name="riwayat_alergi" value="Ada" onchange="toggleKeterangan()" />
                                            <label class="form-check-label fw-semibold" for="alergiAda">Ada</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio" id="alergiTidakAda"
                                                name="riwayat_alergi" value="Tidak Ada" onchange="toggleKeterangan()"
                                                checked />
                                            <label class="form-check-label fw-semibold" for="alergiTidakAda">Tidak
                                                Ada</label>
                                        </div>
                                        <div id="keteranganContainer" style="display: none;" class="mt-3">
                                            <label for="keteranganAlergi"
                                                class="form-label fw-bold">Keterangan:</label>
                                            <textarea rows="3" class="form-control form-control-solid border border-gray-300"
                                                placeholder="Masukkan keterangan" name="keterangan_alergi" id="keteranganAlergi"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        function toggleKeterangan() {
                            var alergiAda = document.getElementById('alergiAda').checked;
                            var keteranganContainer = document.getElementById('keteranganContainer');

                            if (alergiAda) {
                                keteranganContainer.style.display = 'block';
                            } else {
                                keteranganContainer.style.display = 'none';
                            }
                        }
                    </script>


                    <!-- Risiko Aspirasi atau Gangguan Pernafasan -->
                    <div class="col-12">
                        <div class="card border border-gray-300">
                            <div class="card-body">
                                <h5 class="card-title text-primary mb-3">RISIKO ASPIRASI ATAU GANGGUAN PERNAFASAN</h5>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio" id="aspirasiTidak"
                                                name="aspirasi" value="Tidak" checked />
                                            <label class="form-check-label fw-semibold"
                                                for="aspirasiTidak">Tidak</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio" id="aspirasiYa"
                                                name="aspirasi" value="Ya, dengan alat bantu" />
                                            <label class="form-check-label fw-semibold" for="aspirasiYa">Ya, dengan
                                                alat bantu</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Risiko Perdarahan -->
                    <div class="col-12">
                        <div class="card border border-gray-300">
                            <div class="card-body">
                                <h5 class="card-title text-primary mb-3">RISIKO PERDARAHAN</h5>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio" id="perdarahanTidak"
                                                name="resiko_perdarahan" value="Tidak" checked />
                                            <label class="form-check-label fw-semibold"
                                                for="perdarahanTidak">Tidak</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio" id="perdarahanYa"
                                                name="resiko_perdarahan" value="Ya, dengan dua IV line atau CVC" />
                                            <label class="form-check-label fw-semibold" for="perdarahanYa">Ya, dengan
                                                dua IV line atau CVC</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Risiko Anestesi -->
                    <div class="col-12">
                        <div class="card border border-gray-300">
                            <div class="card-body">
                                <h5 class="card-title text-primary mb-3">RISIKO ANESTESI</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="checkbox" id="umum"
                                                name="risiko_perdarahan_umum" value="Umum" />
                                            <label class="form-check-label fw-semibold" for="umum">Umum</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="checkbox" id="spinal"
                                                name="risiko_perdarahan_spinal" value="Spinal" />
                                            <label class="form-check-label fw-semibold" for="spinal">Spinal</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="checkbox" id="blok"
                                                name="risiko_perdarahan_blok" value="Blok" />
                                            <label class="form-check-label fw-semibold" for="blok">Blok</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="checkbox" id="lokal"
                                                name="risiko_perdarahan_lokal" value="Lokal" checked />
                                            <label class="form-check-label fw-semibold" for="lokal">Lokal</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TIME OUT Section -->
                    <div class="col-12">
                        <div class="separator separator-dashed my-4"></div>
                        <h4 class="text-primary fw-bold mb-4">TIME OUT (Sebelum insisi kulit)</h4>
                    </div>
                    <!-- Dokter Pelaksana Tindakan TIME OUT -->
                    <div class="col-12">
                        <div class="card border border-gray-300">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Dokter Pelaksana Tindakan:</label>
                                        <p class="mb-0">
                                            {{ $examination->health_profesional &&
                                            $examination->health_profesional->user &&
                                            $examination->health_profesional->user->info
                                                ? (!in_array($examination->health_profesional->user->info->title_prefix, ['', '-'])
                                                        ? $examination->health_profesional->user->info->title_prefix . '. '
                                                        : '') .
                                                    $examination->health_profesional->user->name .
                                                    (!in_array($examination->health_profesional->user->info->title_suffix, ['', '-'])
                                                        ? ', ' . $examination->health_profesional->user->info->title_suffix
                                                        : '')
                                                : '-' }}
                                            <br>
                                            <strong>{{ $examination->health_profesional && $examination->health_profesional->sip_number
                                                ? 'SIP.' . $examination->health_profesional->sip_number
                                                : '' }}</strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Kelengkapan Tim dan Fasilitas Operasi -->
                    <div class="col-12">
                        <div class="card border border-gray-300">
                            <div class="card-body">
                                <h5 class="card-title text-primary mb-3">KELENGKAPAN TIM DAN FASILITAS OPERASI</h5>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio" id="lengkap"
                                                name="kelengkapan_tim" value="Lengkap" checked />
                                            <label class="form-check-label fw-semibold" for="lengkap">Lengkap</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio" id="tidakLengkap"
                                                name="kelengkapan_tim" value="Tidak Lengkap" />
                                            <label class="form-check-label fw-semibold" for="tidakLengkap">Tidak
                                                Lengkap</label>
                                        </div>
                                        <div class="mt-3">
                                            <label class="form-label fw-bold">Alasan:</label>
                                            <input type="text" name="alasan_tidak_lengkap"
                                                class="form-control form-control-solid border border-gray-300"
                                                placeholder="Alasan Tidak Lengkap">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Periksa Kelengkapan Peralatan Operasi -->
                    <div class="col-12">
                        <div class="card border border-gray-300">
                            <div class="card-body">
                                <h5 class="card-title text-primary mb-3">PERIKSA KELENGKAPAN PERALATAN OPERASI</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="checkbox" id="alatInstrument"
                                                name="kelengkapan_alat_instrument1" value="instrument" checked />
                                            <label class="form-check-label fw-semibold"
                                                for="alatInstrument">Instrument</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="checkbox" id="alatKasa"
                                                name="kelengkapan_alat_kasa1" value="kasa" checked />
                                            <label class="form-check-label fw-semibold" for="alatKasa">Kasa</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="checkbox" id="alatJarum"
                                                name="kelengkapan_alat_jarum1" value="jarum" checked />
                                            <label class="form-check-label fw-semibold" for="alatJarum">Jarum</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="checkbox" id="alatDll"
                                                name="kelengkapan_alat_dll" value="dll" />
                                            <label class="form-check-label fw-semibold" for="alatDll">DLL</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-bold">Keterangan:</label>
                                        <input type="text" name="keterangan_dll"
                                            class="form-control form-control-solid border border-gray-300"
                                            placeholder="Keterangan">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Menyebutkan Nama dan Peran Tim Operasi -->
                    <div class="col-12">
                        <div class="card border border-gray-300">
                            <div class="card-body">
                                <h5 class="card-title text-primary mb-3">MENYEBUTKAN NAMA DAN PERAN TIM OPERASI</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="checkbox" id="membacakan"
                                                name="peran_tim_membacakan" value="Membacakan Secara Verbal"
                                                checked />
                                            <label class="form-check-label fw-semibold" for="membacakan">Membacakan
                                                Secara Verbal</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="checkbox" id="tanggalTindakan"
                                                name="peran_tim_tanggal" value="Tanggal Tindakan" checked />
                                            <label class="form-check-label fw-semibold" for="tanggalTindakan">Tanggal
                                                Tindakan</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="checkbox" id="namaPasien"
                                                name="peran_tim_nama_pasien" value="Nama Lengkap dan Tgl Lahir Pasien"
                                                checked />
                                            <label class="form-check-label fw-semibold" for="namaPasien">Nama Lengkap
                                                dan Tgl Lahir Pasien</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="checkbox" id="diagnosa"
                                                name="peran_tim_diagnosa" value="Diagnosa" checked />
                                            <label class="form-check-label fw-semibold"
                                                for="diagnosa">Diagnosa</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="checkbox" id="namaTindakan"
                                                name="peran_tim_nama_tindakan" value="Nama Tindakan" checked />
                                            <label class="form-check-label fw-semibold" for="namaTindakan">Nama
                                                Tindakan</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="checkbox" id="prosedurTindakan"
                                                name="peran_tim_prosedur" value="Prosedur Tindakan" checked />
                                            <label class="form-check-label fw-semibold"
                                                for="prosedurTindakan">Prosedur Tindakan</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="checkbox" id="lokasiTindakan"
                                                name="peran_tim_lokasi" value="Lokasi Tindakan" checked />
                                            <label class="form-check-label fw-semibold" for="lokasiTindakan">Lokasi
                                                Tindakan</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="checkbox" id="informedConsent"
                                                name="peran_tim_consent" value="Informed Consent" checked />
                                            <label class="form-check-label fw-semibold" for="informedConsent">Informed
                                                Consent</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dokter Bedah -->
                    <div class="col-12">
                        <div class="card border border-gray-300">
                            <div class="card-body">
                                <h5 class="card-title text-primary mb-3">DOKTER BEDAH</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Apakah tindakan yang dilakukan berisiko
                                            tinggi?</label>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio" id="risikoTinggiYa"
                                                name="risiko_tinggi" value="Ya" />
                                            <label class="form-check-label fw-semibold"
                                                for="risikoTinggiYa">Ya</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio" id="risikoTinggiTidak"
                                                name="risiko_tinggi" value="Tidak" checked />
                                            <label class="form-check-label fw-semibold"
                                                for="risikoTinggiTidak">Tidak</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Waktu Tindakan:</label>
                                        <input type="text" name="waktu_tindakan"
                                            class="form-control form-control-solid border border-gray-300"
                                            placeholder="Waktu yang dibutuhkan">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-bold">Apakah sudah diantisipasi perdarahan?</label>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio"
                                                id="perdarahanAntisipasiYa" name="perdarahan_antisipasi"
                                                value="Ya" checked />
                                            <label class="form-check-label fw-semibold"
                                                for="perdarahanAntisipasiYa">Ya</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio"
                                                id="perdarahanAntisipasiTidak" name="perdarahan_antisipasi"
                                                value="Tidak" />
                                            <label class="form-check-label fw-semibold"
                                                for="perdarahanAntisipasiTidak">Tidak</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Dokter Anestesi -->
                    <div class="col-12">
                        <div class="card border border-gray-300">
                            <div class="card-body">
                                <h5 class="card-title text-primary mb-3">DOKTER ANESTESI</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Apakah ada perhatian / kekhawatiran pada
                                            pasien ini?</label>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio" id="perhatianYa"
                                                name="perhatian" value="Ya" />
                                            <label class="form-check-label fw-semibold" for="perhatianYa">Ya</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio" id="perhatianTidak"
                                                name="perhatian" value="Tidak" checked />
                                            <label class="form-check-label fw-semibold"
                                                for="perhatianTidak">Tidak</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Jumlah Pasien ASA:</label>
                                        <input type="text" name="jumlah_pasien"
                                            class="form-control form-control-solid border border-gray-300"
                                            placeholder="Jumlah Pasien ASA">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-bold">Apakah ada peralatan yang perlu disediakan
                                            (darah)?</label>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio" id="peralatanYa"
                                                name="peralatan" value="Ya" />
                                            <label class="form-check-label fw-semibold" for="peralatanYa">Ya</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio" id="peralatanTidak"
                                                name="peralatan" value="Tidak" checked />
                                            <label class="form-check-label fw-semibold"
                                                for="peralatanTidak">Tidak</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PERAWAT -->
                    <div class="col-12">
                        <div class="card border border-gray-300">
                            <div class="card-body">
                                <h5 class="card-title text-primary mb-3">PERAWAT</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Apakah sudah mengecek
                                            sterilisasi
                                            alat (melalui indikator sterilisasi)?</label>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio" id="sterilisasiYa"
                                                name="sterilisasi" value="Ya" checked />
                                            <label class="form-check-label fw-semibold" for="sterilisasiYa">Ya</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio" id="sterilisasiTidak"
                                                name="sterilisasi" value="Tidak" />
                                            <label class="form-check-label fw-semibold"
                                                for="sterilisasiTidak">Tidak</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Apakah ada kesiapan peralatan
                                            yang
                                            harus diperhatikan?</label>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio" id="peralatanKesiapanYa"
                                                name="kesiapan_peralatan" value="Ya"
                                                onchange="toggleKeterangan(this)" />
                                            <label class="form-check-label fw-semibold"
                                                for="peralatanKesiapanYa">Ya</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio"
                                                id="peralatanKesiapanTidak" name="kesiapan_peralatan" value="Tidak"
                                                onchange="toggleKeterangan(this)" checked />
                                            <label class="form-check-label fw-semibold"
                                                for="peralatanKesiapanTidak">Tidak</label>
                                        </div>
                                        <div id="keteranganField" style="display:none; margin-top: 10px;">
                                            <label for="keterangan" class="form-label fw-semibold">Keterangan:</label>
                                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ANTIBIOTIK PROPHYLAXIS -->
                    <div class="col-12">
                        <div class="card border border-gray-300">
                            <div class="card-body">
                                <h5 class="card-title text-primary mb-3">ANTIBIOTIK PROPHYLAXIS</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Apakah sudah diberikan dalam waktu
                                            sekurangnya 60
                                            menit sebelum tindakan?</label>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio" id="antibiotikYa"
                                                name="antibiotik" value="Ya" />
                                            <label class="form-check-label fw-semibold" for="antibiotikYa">Ya</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio" id="antibiotikTidak"
                                                name="antibiotik" value="Tidak" checked />
                                            <label class="form-check-label fw-semibold"
                                                for="antibiotikTidak">Tidak</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label fw-bold">Nama Obat</label>
                                                <input type="text" name="nama_obat"
                                                    class="form-control form-control-solid border border-gray-300"
                                                    placeholder="Nama Obat">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label fw-bold">Dosis Obat</label>
                                                <input type="text" name="dosis_obat"
                                                    class="form-control form-control-solid border border-gray-300"
                                                    placeholder="Dosis Obat">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label fw-bold">Jam diberikan</label>
                                                <input type="text" name="jam_diberikan"
                                                    class="form-control form-control-solid border border-gray-300"
                                                    placeholder="Jam">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FOTO PEMERIKSAAN RADIOLOGI YANG DIPERLUKAN -->
                    <div class="col-12">
                        <div class="card border border-gray-300">
                            <div class="card-body">
                                <h5 class="card-title text-primary mb-3">FOTO PEMERIKSAAN RADIOLOGI YANG DIPERLUKAN
                                </h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio" id="radiologiDipasan"
                                                name="radiologi" value="Dipasang" />
                                            <label class="form-check-label fw-semibold"
                                                for="radiologiDipasan">Dipasang</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio" id="radiologiTidakDipasan"
                                                name="radiologi" value="Tidak dipasang" checked />
                                            <label class="form-check-label fw-semibold"
                                                for="radiologiTidakDipasan">Tidak
                                                dipasang</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- SIGN OUT -->
                    <div class="col-12">
                        <div class="card border border-gray-300">
                            <div class="card-body">
                                <h5 class="card-title text-primary mb-3">SIGN OUT (Sebelum pasien keluar kamar
                                    tindakan)
                                </h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <h6 class="fw-bold text-gray-800 mb-3">Secara Verbal Perawat Memastikan:</h6>
                                        <label class="form-label fw-bold">Nama Tindakan</label>
                                        <input type="text" name="nama_tindakan"
                                            class="form-control form-control-solid border border-gray-300"
                                            placeholder="Nama Tindakan">
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="fw-bold text-gray-800 mb-3">Kelengkapan Alat:</h6>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="checkbox" id="alatInstrument"
                                                name="kelengkapan_alat_instrument" value="instrument" checked />
                                            <label class="form-check-label fw-semibold"
                                                for="alatInstrument">Instrument</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="checkbox" id="alatKasa"
                                                name="kelengkapan_alat_kasa" value="kasa" checked />
                                            <label class="form-check-label fw-semibold" for="alatKasa">Kasa</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="checkbox" id="alatJarum"
                                                name="kelengkapan_alat_jarum" value="jarum" checked />
                                            <label class="form-check-label fw-semibold" for="alatJarum">Jarum</label>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="form-check form-check-custom form-check-solid me-3">
                                                <input class="form-check-input" type="checkbox" id="alatDll1"
                                                    name="kelengkapan_alat_dll1" value="dll" />
                                                <label class="form-check-label fw-semibold" for="alatDll1">DLL</label>
                                            </div>
                                            <input type="text" name="keterangan_dll1"
                                                class="form-control form-control-solid border border-gray-300"
                                                placeholder="Keterangan">
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Pelabelan specimen</label>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio" id="pelabelanSpecimenYa"
                                                name="pelabelan_specimen" value="ya"
                                                onchange="toggleKeterangan(this)" />
                                            <label class="form-check-label fw-semibold"
                                                for="pelabelanSpecimenYa">Ya</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio"
                                                id="pelabelanSpecimenTidak" name="pelabelan_specimen" value="tidak"
                                                onchange="toggleKeterangan(this)" checked />
                                            <label class="form-check-label fw-semibold"
                                                for="pelabelanSpecimenTidak">Tidak</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">JENIS SPECIMEN</label>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="checkbox" id="pa"
                                                name="pemeriksaan_pa" value="PA" />
                                            <label class="form-check-label fw-semibold" for="pa">PA</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="checkbox" id="kultur"
                                                name="pemeriksaan_kultur" value="Kultur" />
                                            <label class="form-check-label fw-semibold" for="kultur">Kultur</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="checkbox" id="sitologi"
                                                name="pemeriksaan_sitologi" value="Sitologi" />
                                            <label class="form-check-label fw-semibold"
                                                for="sitologi">Sitologi</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Apakah ada masalah peralatan yang perlu
                                            disampaikan dari dokter Bedah?</label>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio" id="masalahPeralatanYa"
                                                name="masalah_peralatan" value="Ya" />
                                            <label class="form-check-label fw-semibold"
                                                for="masalahPeralatanYa">Ya</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio" id="masalahPeralatanTidak"
                                                name="masalah_peralatan" value="Tidak" checked />
                                            <label class="form-check-label fw-semibold"
                                                for="masalahPeralatanTidak">Tidak</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Formulir permintaan pemeriksaan</label>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio" id="formulirPemeriksaanYa"
                                                name="formulir_pemeriksaan" value="Ya" />
                                            <label class="form-check-label fw-semibold"
                                                for="formulirPemeriksaanYa">Ya</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio"
                                                id="formulirPemeriksaanTidak" name="formulir_pemeriksaan"
                                                value="Tidak" checked />
                                            <label class="form-check-label fw-semibold"
                                                for="formulirPemeriksaanTidak">Tidak</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Telah dilengkapi identitas pasien</label>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio" id="identitasPasienYa"
                                                name="identitas_pasien" value="Ya" checked />
                                            <label class="form-check-label fw-semibold"
                                                for="identitasPasienYa">Ya</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio" id="identitasPasienTidak"
                                                name="identitas_pasien" value="Tidak" />
                                            <label class="form-check-label fw-semibold"
                                                for="identitasPasienTidak">Tidak</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Penjelasan oleh operator kepada keluarga
                                            pasien</label>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio" id="penjelasanYa"
                                                name="penjelasan_operator" value="Ya" checked />
                                            <label class="form-check-label fw-semibold" for="penjelasanYa">Ya</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio" id="penjelasanTidak"
                                                name="penjelasan_operator" value="Tidak" />
                                            <label class="form-check-label fw-semibold"
                                                for="penjelasanTidak">Tidak</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label fw-bold">OBAT - OBATAN YANG DIBERIKAN SELAMA
                                            OPERASI</label>
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="form-check form-check-custom form-check-solid me-3">
                                                <input class="form-check-input" type="radio" id="obatDiberikan"
                                                    name="obat_operasi" value="Diberikan" />
                                                <label class="form-check-label fw-semibold"
                                                    for="obatDiberikan">Diberikan</label>
                                            </div>
                                            <input type="text" name="alasan_diberikan"
                                                class="form-control form-control-solid border border-gray-300"
                                                placeholder="Alasan Diberikan">
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="form-check form-check-custom form-check-solid me-3">
                                                <input class="form-check-input" type="radio"
                                                    id="obatTidakDiberikan" name="obat_operasi"
                                                    value="Tidak diberikan" checked />
                                                <label class="form-check-label fw-semibold"
                                                    for="obatTidakDiberikan">Tidak
                                                    Diberikan</label>
                                            </div>
                                            <input type="text" name="alasan_tidak_diberikan"
                                                class="form-control form-control-solid border border-gray-300"
                                                placeholder="Alasan Tidak Diberikan">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- PEMERIKSAAN TANDA VITAL -->
                    <div class="col-12">
                        <div class="card border border-gray-300">
                            <div class="card-body">
                                <h5 class="card-title text-primary mb-3">PEMERIKSAAN TANDA VITAL</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Kesadaran</label>
                                        <input type="text" name="kesadaran_1"
                                            class="form-control form-control-solid border border-gray-300"
                                            placeholder="Kesadaran">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Tekanan Darah</label>
                                        <input type="text" name="tekanan_1"
                                            class="form-control form-control-solid border border-gray-300"
                                            placeholder="Tekanan Darah (mmHg)">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Nadi</label>
                                        <input type="text" name="nadi_1"
                                            class="form-control form-control-solid border border-gray-300"
                                            placeholder="Nadi (kali/menit)">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Saturasi O2</label>
                                        <input type="text" name="saturasi_1"
                                            class="form-control form-control-solid border border-gray-300"
                                            placeholder="Saturasi O2 (%)">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Suhu</label>
                                        <input type="text" name="suhu_1"
                                            class="form-control form-control-solid border border-gray-300"
                                            placeholder="Suhu (°C)">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Pernafasan</label>
                                        <input type="text" name="pernafasan_1"
                                            class="form-control form-control-solid border border-gray-300"
                                            placeholder="Pernafasan (kali/menit)">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-bold">Skala nyeri</label>
                                        <input type="text" name="skala_nyeri_1"
                                            class="form-control form-control-solid border border-gray-300"
                                            placeholder="Skala Nyeri (Visual Analog Scale-VAS)">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PERIKSA KEMBALI LUKA OPERASI -->
                    <div class="col-12">
                        <div class="card border border-gray-300">
                            <div class="card-body">
                                <h5 class="card-title text-primary mb-3">Periksa kembali luka operasi</h5>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio"
                                                id="lukaOperasiAdaRembesan" name="luka_operasi"
                                                value="Ada rembesan" />
                                            <label class="form-check-label fw-semibold"
                                                for="lukaOperasiAdaRembesan">Ada
                                                rembesan</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio"
                                                id="lukaOperasiTidakAdaRembesan" name="luka_operasi"
                                                value="Tidak ada rembesan" checked />
                                            <label class="form-check-label fw-semibold"
                                                for="lukaOperasiTidakAdaRembesan">Tidak ada rembesan</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TANDA TANGAN -->
                    <div class="col-12">
                        <div class="card border border-gray-300">
                            <div class="card-body">
                                <h5 class="card-title text-primary mb-3">Tanda Tangan</h5>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="d-flex gap-3 flex-column w-100">
                                            <canvas id="signature-pad_2" name="signature2"
                                                style="border:1px solid #000; width: 100%; max-width: 300px; height: auto; max-height: 100px;"></canvas>
                                            <input type="hidden" name="signature2" id="signature-data2">
                                            <div class="d-flex justify-content-between mt-2">
                                                <button id="clear2" class="btn btn-secondary"
                                                    type="button">Clear</button>
                                                <button id="save2" class="btn btn-primary"
                                                    type="submit">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @csrf
                <div class="row mt-4">
                    <div class="col-12">
                        <button type="submit" class="btn btn-bg-dark text-white">Download PDF</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
