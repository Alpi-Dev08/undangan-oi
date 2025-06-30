<div class="tab-pane fade" id="persetujuan" role="tabpanel">
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-light-success">
            <h3 class="d-flex align-items-center">Persetujuan Tindakan Medis</h3>
        </div>
        <div class="card-body p-4">
            <form method="post" action="{{ route('suket.persetujuan', $examination->id) }}" class="form">
                @csrf
                <div class="table-responsive mb-5">
                    <table class="table" style="width:100%">
                        <tbody>
                            <tr>
                                <td class="fw-bold text-gray-700 min-w-150px">Dokter Pelaksana Tindakan</td>
                                <td>:
                                    {{ $examination->health_profesional->user->name }}{{ isset($examination->health_profesional->user->info) && !in_array($examination->health_profesional->user->info->title_prefix, ['', '-']) ? ', ' . $examination->health_profesional->user->info->title_prefix . '.' : '' }}{{ isset($examination->health_profesional->user->info) && !in_array($examination->health_profesional->user->info->title_suffix, ['', '-']) ? ', ' . $examination->health_profesional->user->info->title_suffix : '' }}</b>
                                    <br>
                                    <b>{{ $examination->health_profesional->sip_number ? 'SIP.' . $examination->health_profesional->sip_number : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-gray-700">Nama</td>
                                <td class="d-flex">:&nbsp;<input type="text" name="nama_pasien"
                                        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                        placeholder="Nama ">
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-gray-700">Tempat,Tanggal Lahir</td>
                                <td class="d-flex">:&nbsp;<input type="text" name="tempat_tgl"
                                        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                        placeholder="Tempat, Tanggal Lahir">
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-gray-700">Jenis kelamin</td>
                                <td class="d-flex">:&nbsp;<input type="text" name="jenis_kel"
                                        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                        placeholder="Jenis kelamin">
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-gray-700">Alamat</td>
                                <td class="d-flex">:&nbsp;<input type="text" name="alamat_pas"
                                        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                        placeholder="Alamat">
                                </td>
                            </tr>

                            <tr>
                                <td class="fw-bold text-gray-700">Tindakan Terhadap</td>
                                <td class="d-flex">:&nbsp;
                                    <div class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                        <input type="text" value="Saya" name="terhadap"
                                            class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                            placeholder="Saya">
                                        <!-- <input type="text" name="jenis_tindakan" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Jenis Tindakan"> -->
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="fw-bold text-gray-700">Nama</td>
                                <td>:
                                    {{ (!in_array($user->info->title_prefix, ['', '-']) ? $user->info->title_prefix . '. ' : '') . $user->name . (!in_array($user->info->title_suffix, ['', '-']) ? ', ' . $user->info->title_suffix : '') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-gray-700">Tempat,Tanggal Lahir</td>
                                <td>: {{ $info->place_of_birth . ', ' . $info->date_of_birth }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-gray-700">Jenis Kelamin</td>
                                <td>: {{ isset($info->gender) ? $info->gender->name : '' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-gray-700">Alamat</td>
                                <td>:
                                    {{ $info->address }}{{ isset($info->subdistrict) ? ', ' . $info->subdistrict->name : '' }}{{ isset($info->district) ? ', ' . $info->district->name : '' }}{{ isset($info->city) ? ', ' . $info->city->name : '' }}{{ isset($info->province) ? ', ' . $info->province->name : '' }}{{ isset($info->country) ? ', ' . $info->country->name : '' }}{{ $info->postal_code != '' ? $info->postal_code : (isset($info->subdistrict) ? ' - ' . $info->subdistrict->postal_code : '') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-gray-700">Diagnosis (WD & DD)</td>
                                <td class="d-flex">:&nbsp;
                                    <div class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                        <input type="text" name="diagnosis"
                                            class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                            placeholder="Isi Informasi">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-gray-700">Dasar Diagnosis</td>
                                <td class="d-flex">:&nbsp;
                                    <div class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                        <input type="text" name="dasar_diagnosis"
                                            class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                            placeholder="Isi Informasi">
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="fw-bold text-gray-700">Tindakan Kedokteran</td>
                                <td class="d-flex">:&nbsp;
                                    <div class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                        <input type="text" name="tindakan"
                                            class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                            placeholder="Isi Informasi">
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="fw-bold text-gray-700">Tata Cara</td>
                                <td class="d-flex">:&nbsp;
                                    <div class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                        <input type="text" name="tatacara"
                                            class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                            placeholder="Isi Informasi">
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="fw-bold text-gray-700">Tujuan</td>
                                <td class="d-flex">:&nbsp;
                                    <div class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                        <input type="text" name="tujuan"
                                            class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                            placeholder="Isi Informasi">
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="fw-bold text-gray-700">Alternatif dan Resiko</td>
                                <td class="d-flex">:&nbsp;
                                    <div class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                        <input type="text" name="resiko"
                                            class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                            placeholder="Isi Informasi">
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="fw-bold text-gray-700">Resiko dan Komplikasi</td>
                                <td class="d-flex">:&nbsp;
                                    <div class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                        <input type="text" name="komplikasi"
                                            class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                            placeholder="Isi Informasi">
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="fw-bold text-gray-700">Prognosis</td>
                                <td class="d-flex">:&nbsp;
                                    <div class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                        <input type="text" name="prognosis"
                                            class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                            placeholder="Isi Informasi">
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="fw-bold text-gray-700" style="width:20%;">Tanda Tangan:</td>
                                <td class="d-flex">:&nbsp;
                                    <div class="d-flex gap-3 flex-column w-100">
                                        <canvas id="signature-pad_1" name="signature"
                                            style="border:1px solid #000; width: 100%; max-width: 300px; height: auto; max-height: 100px;"></canvas>
                                        <input type="hidden" name="signature" id="signature-data1">
                                        <div class="d-flex justify-content-between mt-2">
                                            <button id="clear1" class="btn btn-secondary"
                                                type="button">Clear</button>
                                            <button id="save1" class="btn btn-primary"
                                                type="button">Save</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="separator separator-dashed my-5"></div>

                <div class="mb-5">
                    <h4 class="fw-bold fs-6 mb-3">Persetujuan Tindakan</h4>

                    <div class="card card-bordered border-gray-300 mb-3">
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

                    <div class="card card-bordered border-gray-300 mb-3">
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
