@php use Carbon\Carbon; @endphp
<div class="card card-xxl-stretch mb-5 mb-xl-8">
    <!--begin::Card body-->
    <!--begin::Card header-->
    <div class="card-header position-relative py-0 border-bottom-1">
        <!--begin::Card title-->
        <h3 class="card-title text-gray-800 fw-bold">
            Examination {{ $examination->examination_code }}
        </h3>
        <!--end::Card title-->
        <!--begin::Tabs-->
        <ul class="nav nav-stretch nav-pills nav-pills-custom d-flex mt-4">
            <!--begin::Nav item-->
            <li class="nav-item p-0 ms-0">
                <a class="nav-link btn btn-color-gray-400 flex-center px-3" data-kt-timeline-widget-4="tab"
                    data-bs-toggle="tab" href="#user">
                    <!--begin::Title-->
                    <span class="nav-text fw-semibold fs-4 mb-3">Patient Profile</span>
                    <!--end::Title-->
                    <!--begin::Bullet-->
                    <span
                        class="bullet-custom position-absolute z-index-2 w-100 h-1px top-100 bottom-n100 bg-primary rounded"></span>
                    <!--end::Bullet-->
                </a>
            </li>

            <!--begin::Nav item SBAR-->
            <li class="nav-item p-0 ms-0">
                <a class="nav-link btn btn-color-gray-400 flex-center px-3" data-kt-timeline-widget-4="tab"
                    data-bs-toggle="tab" href="#sbar">
                    <!--begin::Title-->
                    <span class="nav-text fw-semibold fs-4 mb-3">SBAR</span>
                    <!--end::Title-->
                    <!--begin::Bullet-->
                    <span
                        class="bullet-custom position-absolute z-index-2 w-100 h-1px top-100 bottom-n100 bg-primary rounded"></span>
                    <!--end::Bullet-->
                </a>
            </li>
            <!--end::Nav item-->

            <li class="nav-item p-0 ms-0">
                <a class="nav-link btn btn-color-gray-400 flex-center px-3" data-kt-timeline-widget-4="tab"
                    data-bs-toggle="tab" href="#medicalrecord">
                    <!--begin::Title-->
                    <span class="nav-text fw-semibold fs-4 mb-3">Medical Record</span>
                    <!--end::Title-->
                    <!--begin::Bullet-->
                    <span
                        class="bullet-custom position-absolute z-index-2 w-100 h-1px top-100 bottom-n100 bg-primary rounded"></span>
                    <!--end::Bullet-->
                </a>
            </li>
            <!--end::Nav item-->

            @if ($examination->is_lab)
                <li class="nav-item p-0 ms-0">
                    <a class="nav-link btn btn-color-gray-400 flex-center px-3" data-kt-timeline-widget-4="tab"
                        data-bs-toggle="tab" href="#lab">
                        <!--begin::Title-->
                        <span class="nav-text fw-semibold fs-4 mb-3">Hasil Lab</span>
                        <!--end::Title-->
                        <!--begin::Bullet-->
                        <span
                            class="bullet-custom position-absolute z-index-2 w-100 h-1px top-100 bottom-n100 bg-primary rounded"></span>
                        <!--end::Bullet-->
                    </a>
                </li>
                <!--end::Nav item-->
            @endif

            <!--begin::Nav item-->
            <li class="nav-item p-0 ms-0">
                <a class="nav-link btn btn-color-gray-400 flex-center px-3" data-kt-timeline-widget-4="tab"
                    data-bs-toggle="tab" href="#psikososial">
                    <!--begin::Title-->
                    <span class="nav-text fw-semibold fs-4 mb-3">Pengkajian Awal</span>
                    <!--end::Title-->
                    <!--begin::Bullet-->
                    <span
                        class="bullet-custom position-absolute z-index-2 w-100 h-1px top-100 bottom-n100 bg-primary rounded"></span>
                    <!--end::Bullet-->
                </a>
            </li>
            <!--end::Nav item-->

            <!--begin::Nav item-->
            <li class="nav-item p-0 ms-0">
                <a class="nav-link btn btn-color-gray-400 flex-center px-3 active" data-kt-timeline-widget-4="tab"
                    data-bs-toggle="tab" href="#examination">
                    <!--begin::Title-->
                    <span class="nav-text fw-semibold fs-4 mb-3">Examination</span>
                    <!--end::Title-->
                    <!--begin::Bullet-->
                    <span
                        class="bullet-custom position-absolute z-index-2 w-100 h-1px top-100 bottom-n100 bg-primary rounded"></span>
                    <!--end::Bullet-->
                </a>
            </li>
            <!--end::Nav item-->
            <!--begin::Nav item-->
            <li class="nav-item p-0 ms-0">
                <a class="nav-link btn btn-color-gray-400 flex-center px-3" data-kt-timeline-widget-4="tab"
                    data-bs-toggle="tab" href="#suratketerangan">
                    <!--begin::Title-->
                    <span class="nav-text fw-semibold fs-4 mb-3">Surat Keterangan</span>
                    <!--end::Title-->
                    <!--begin::Bullet-->
                    <span
                        class="bullet-custom position-absolute z-index-2 w-100 h-1px top-100 bottom-n100 bg-primary rounded"></span>
                    <!--end::Bullet-->
                </a>
            </li>
            <!--end::Nav item-->

            <!--begin::Nav item-->
            <li class="nav-item p-0 ms-0" style="display: none">
                <a class="nav-link btn btn-color-gray-400 flex-center px-3" data-kt-timeline-widget-4="tab"
                    data-bs-toggle="tab" href="#other">
                    <!--begin::Title-->
                    <span class="nav-text fw-semibold fs-4 mb-3">Other</span>
                    <!--end::Title-->
                    <!--begin::Bullet-->
                    <span
                        class="bullet-custom position-absolute z-index-2 w-100 h-1px top-100 bottom-n100 bg-primary rounded"></span>
                    <!--end::Bullet-->
                </a>
            </li>
            <!--end::Nav item-->
        </ul>
        <!--end::Tabs-->
    </div>

    <div class="card-body pb-0">
        <!--begin::Tab content-->
        <div class="tab-content">
            <!--begin::Tab pane-->
            @include('pages.klinik.examinations.partials._profile')
            @include('pages.klinik.examinations.partials._sbar')
            @include('pages.klinik.examinations.partials._medicalrecord')
            @include('pages.klinik.examinations.partials._lab')
            @include('pages.klinik.examinations.partials._psikososial')

            <div class="tab-pane" id="other" role="tabpanel" aria-labelledby="all-tab"
                data-kt-timeline-widget-4-blockui="true">
                <!-- PDF Upload Section -->
                <div class="pdf-upload">
                    <input type="file" id="pdfFile" accept="application/pdf" class="form-control" />
                </div>

                <!-- PDF Display Section -->
                <div id="pdfDisplay" class="mt-3">
                    @if (!empty($pdfPath))
                        <a href="{{ asset('storage/' . $pdfPath) }}" target="_blank" class="btn btn-primary">Open
                            PDF</a>
                    @endif
                </div>

                <!-- Success Message Section -->
                <div id="successMessage" class="alert alert-success mt-3" style="display: none;"></div>
            </div>

            <script>
                document.getElementById('pdfFile').addEventListener('change', function(event) {
                    var file = event.target.files[0];
                    if (file && file.type === "application/pdf") {
                        var fileURL = URL.createObjectURL(file);
                        var pdfDisplay = document.getElementById('pdfDisplay');

                        pdfDisplay.innerHTML = '';

                        var pdfLink = document.createElement('a');
                        pdfLink.href = fileURL;
                        pdfLink.textContent = "Open PDF";
                        pdfLink.target = "_blank";
                        pdfLink.classList.add('btn', 'btn-primary');
                        pdfDisplay.appendChild(pdfLink);

                        var saveButton = document.createElement('button');
                        saveButton.textContent = "Save PDF";
                        saveButton.classList.add('btn', 'btn-success', 'ms-2');
                        saveButton.addEventListener('click', function() {
                            var formData = new FormData();
                            formData.append('pdfFile', file);
                            formData.append('_token', document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'));

                            fetch('/upload-pdf/{{ $user->patient->patient_code }}', {
                                    method: 'POST',
                                    body: formData
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        pdfLink.href = data.filePath;

                                        var successMessage = document.getElementById('successMessage');
                                        successMessage.style.display = 'block';
                                        successMessage.textContent = 'PDF saved successfully!';
                                    } else {
                                        alert('Failed to save the PDF. Please try again.');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                });
                        });

                        pdfDisplay.appendChild(saveButton);
                    } else {
                        alert('Please upload a valid PDF file.');
                    }
                });
            </script>

            <style>
                .pdf-upload input {
                    margin-bottom: 10px;
                }

                #pdfDisplay a,
                #pdfDisplay button {
                    display: inline-block;
                    margin-top: 10px;
                }

                #successMessage {
                    display: none;
                }

                #pdfDisplay {
                    position: relative;
                    z-index: 1000;
                }
            </style>

            @include('pages.klinik.examinations.partials._examination')

            <div class="tab-pane" id="suratketerangan" role="tabpanel" aria-labelledby="all-tab"
                data-kt-timeline-widget-4-blockui="true">
                <div class="d-flex flex-column flex-md-row rounded border p-10">
                    <ul
                        class="nav nav-tabs nav-pills flex-row border-0 flex-md-column me-5 mb-3 mb-md-0 fs-6 min-w-lg-200px">
                        <li class="nav-item w-100 me-0 mb-md-2">
                            <a class="nav-link active w-100 active btn btn-flex btn-active-light-success"
                                data-bs-toggle="tab" href="#suratsehat">
                                <span class="d-flex flex-column align-items-start">
                                    <span class="fs-7 fw-bold">Surat Keterangan Sehat</span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item w-100 me-0 mb-md-2">
                            <a class="nav-link w-100 btn btn-flex btn-active-light-info" data-bs-toggle="tab"
                                href="#suratsakit">
                                <span class="d-flex flex-column align-items-start">
                                    <span class="fs-7 fw-bold">Surat Keterangan Sakit</span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item w-100 me-0 mb-md-2">
                            <a class="nav-link w-100 btn btn-flex btn-active-light-info" data-bs-toggle="tab"
                                href="#hakkewajiban">
                                <span class="d-flex flex-column align-items-start" style="text-align:left">
                                    <span class="fs-7 fw-bold">Bukti Penyampaian Hak dan Kewajiban</span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item w-100 me-0 mb-md-2">
                            <a class="nav-link w-100 btn btn-flex btn-active-light-info" data-bs-toggle="tab"
                                href="#persetujuan">
                                <span class="d-flex flex-column align-items-start" style="text-align:left">
                                    <span class="fs-7 fw-bold">Persetujuan Tindakan Medis</span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item w-100 me-0 mb-md-2">
                            <a class="nav-link w-100 btn btn-flex btn-active-light-info" data-bs-toggle="tab"
                                href="#penandaanoperasi">
                                <span class="d-flex flex-column align-items-start" style="text-align:left">
                                    <span class="fs-7 fw-bold">Penandaan Lokasi Operasi</span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item w-100 me-0 mb-md-2">
                            <a class="nav-link w-100 btn btn-flex btn-active-light-info" data-bs-toggle="tab"
                                href="#surgicalsafetychecklist">
                                <span class="d-flex flex-column align-items-start" style="text-align:left">
                                    <span class="fs-7 fw-bold">Surgical Safety Checklist</span>
                                </span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content w-100 container" id="myTabContent">
                        <div class="tab-pane fade" id="penandaanoperasi" role="tabpanel">
                            @if ($info->gender->name == 'Pria')
                                <img id="penandaan_operasi"
                                    src="{{ asset('assets/media/penandaan_operasi_pria.png') }}">
                            @else
                                <img id="penandaan_operasi"
                                    src="{{ asset('assets/media/penandaan_operasi_wanita.png') }}">
                            @endif
                            <div id="point"></div>
                            <form method="post" action="{{ route('suket.operasi', $examination->id) }}">
                                @csrf
                                <input type="hidden" name="coordinate_x" id="coordinate_x">
                                <input type="hidden" name="coordinate_y" id="coordinate_y">

                                <table class="table" style="width:100%">
                                    <tbody>
                                        <tr>
                                            <td>Ruangan</td>
                                            <td class="d-flex">:&nbsp;<input type="text" name="ruangan"
                                                    class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                    placeholder="Ruangan">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Jenis Operasi</td>
                                            <td class="d-flex">:&nbsp;<input type="text" name="operasi"
                                                    class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                    placeholder="Jenis Operasi">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal</td>
                                            <td class="d-flex">:&nbsp;<input type="date" name="tanggal"
                                                    class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                    placeholder="Tanggal">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Waktu</td>
                                            <td class="d-flex">:&nbsp;<input type="time" name="jam"
                                                    class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                    placeholder="Waktu">
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                                <button type="submit" class="btn btn-bg-dark text-white">Download PDF</button>
                            </form>
                        </div>
                        @include('pages.klinik.examinations.partials.components.surat._sehat')
                        @include('pages.klinik.examinations.partials.components.surat._sakit')


                        <div class="tab-pane fade" id="persetujuan" role="tabpanel">
                            <h3 class="fs-3 fw-bold">Persetujuan Tindakan Medis</h3>
                            <div class="table-responsive">
                                <form method="post" action="{{ route('suket.persetujuan', $examination->id) }}">
                                    <table class="table" style="width:100%">
                                        <tbody>
                                            <tr>
                                                <td>Dokter Pelaksana Tindakan</td>
                                                <td>:
                                                    {{ $examination->health_profesional->user->name }}{{ isset($examination->health_profesional->user->info) && !in_array($examination->health_profesional->user->info->title_prefix, ['', '-']) ? ', ' . $examination->health_profesional->user->info->title_prefix . '.' : '' }}{{ isset($examination->health_profesional->user->info) && !in_array($examination->health_profesional->user->info->title_suffix, ['', '-']) ? ', ' . $examination->health_profesional->user->info->title_suffix : '' }}</b>
                                                    <br>
                                                    <b>{{ $examination->health_profesional->sip_number ? 'SIP.' . $examination->health_profesional->sip_number : '' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Nama</td>
                                                <td class="d-flex">:&nbsp;<input type="text" name="nama_pasien"
                                                        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                        placeholder="Nama ">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Tempat,Tanggal Lahir</td>
                                                <td class="d-flex">:&nbsp;<input type="text" name="tempat_tgl"
                                                        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                        placeholder="Tempat, Tanggal Lahir">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Jenis kelamin</td>
                                                <td class="d-flex">:&nbsp;<input type="text" name="jenis_kel"
                                                        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                        placeholder="Jenis kelamin">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Alamat</td>
                                                <td class="d-flex">:&nbsp;<input type="text" name="alamat_pas"
                                                        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                        placeholder="Alamat">
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Tindakan Terhadap</td>
                                                <td class="d-flex">:&nbsp;
                                                    <div
                                                        class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                        <input type="text" value="Saya" name="terhadap"
                                                            class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                            placeholder="Saya">
                                                        <!-- <input type="text" name="jenis_tindakan" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Jenis Tindakan"> -->
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Nama</td>
                                                <td>:
                                                    {{ (!in_array($user->info->title_prefix, ['', '-']) ? $user->info->title_prefix . '. ' : '') . $user->name . (!in_array($user->info->title_suffix, ['', '-']) ? ', ' . $user->info->title_suffix : '') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Tempat,Tanggal Lahir</td>
                                                <td>: {{ $info->place_of_birth . ', ' . $info->date_of_birth }}</td>
                                            </tr>
                                            <tr>
                                                <td>Jenis Kelamin</td>
                                                <td>: {{ isset($info->gender) ? $info->gender->name : '' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Alamat</td>
                                                <td>:
                                                    {{ $info->address }}{{ isset($info->subdistrict) ? ', ' . $info->subdistrict->name : '' }}{{ isset($info->district) ? ', ' . $info->district->name : '' }}{{ isset($info->city) ? ', ' . $info->city->name : '' }}{{ isset($info->province) ? ', ' . $info->province->name : '' }}{{ isset($info->country) ? ', ' . $info->country->name : '' }}{{ $info->postal_code != '' ? $info->postal_code : (isset($info->subdistrict) ? ' - ' . $info->subdistrict->postal_code : '') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Diagnosis (WD & DD)</td>
                                                <td class="d-flex">:&nbsp;
                                                    <div
                                                        class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                        <input type="text" name="diagnosis"
                                                            class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                            placeholder="Isi Informasi">
                                                        <!-- <label class="form-check form-switch form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" name="diagnosis_check" value="1"/>
                                                        <span class="form-check-label fw-semibold text-muted">
                                                            Check
                                                        </span>
                                                    </label> -->
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Dasar Diagnosis</td>
                                                <td class="d-flex">:&nbsp;
                                                    <div
                                                        class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                        <input type="text" name="dasar_diagnosis"
                                                            class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                            placeholder="Isi Informasi">
                                                        <!-- <label class="form-check form-switch form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" name="dasar_diagnosis_check" value="1"/>
                                                        <span class="form-check-label fw-semibold text-muted">
                                                            Check
                                                        </span>
                                                    </label> -->
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Tindakan Kedokteran</td>
                                                <td class="d-flex">:&nbsp;
                                                    <div
                                                        class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                        <input type="text" name="tindakan"
                                                            class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                            placeholder="Isi Informasi">
                                                        <!-- <label class="form-check form-switch form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" name="tindakan_check" value="1"/>
                                                        <span class="form-check-label fw-semibold text-muted">
                                                            Check
                                                        </span>
                                                    </label> -->
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Tata Cara</td>
                                                <td class="d-flex">:&nbsp;
                                                    <div
                                                        class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                        <input type="text" name="tatacara"
                                                            class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                            placeholder="Isi Informasi">
                                                        <!-- <label class="form-check form-switch form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" name="tatacara_check" value="1"/>
                                                        <span class="form-check-label fw-semibold text-muted">
                                                            Check
                                                        </span>
                                                    </label> -->
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Tujuan</td>
                                                <td class="d-flex">:&nbsp;
                                                    <div
                                                        class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                        <input type="text" name="tujuan"
                                                            class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                            placeholder="Isi Informasi">
                                                        <!-- <label class="form-check form-switch form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" name="tujuan_check" value="1"/>
                                                        <span class="form-check-label fw-semibold text-muted">
                                                            Check
                                                        </span>
                                                    </label> -->
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Alternatif dan Resiko</td>
                                                <td class="d-flex">:&nbsp;
                                                    <div
                                                        class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                        <input type="text" name="resiko"
                                                            class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                            placeholder="Isi Informasi">
                                                        <!-- <label class="form-check form-switch form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" name="resiko_check" value="1"/>
                                                        <span class="form-check-label fw-semibold text-muted">
                                                            Check
                                                        </span>
                                                    </label> -->
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Resiko dan Komplikasi</td>
                                                <td class="d-flex">:&nbsp;
                                                    <div
                                                        class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                        <input type="text" name="komplikasi"
                                                            class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                            placeholder="Isi Informasi">
                                                        <!-- <label class="form-check form-switch form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" name="komplikasi_check" value="1"/>
                                                        <span class="form-check-label fw-semibold text-muted">
                                                            Check
                                                        </span>
                                                    </label> -->
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Prognosis</td>
                                                <td class="d-flex">:&nbsp;
                                                    <div
                                                        class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                        <input type="text" name="prognosis"
                                                            class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                            placeholder="Isi Informasi">
                                                        <!-- <label class="form-check form-switch form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" name="prognosis_check" value="1"/>
                                                        <span class="form-check-label fw-semibold text-muted">
                                                            Check
                                                        </span>
                                                    </label> -->
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- <tr>
                                            <td>Yang Bertandatangan</td>
                                            <td class="d-flex">:&nbsp;
                                                <div class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                    <input type="text" value="{{ (!in_array($user->info->title_prefix, ['', '-']) ? $user->info->title_prefix . '. ' : '') . $user->name . (!in_array($user->info->title_suffix, ['', '-']) ? ', ' . $user->info->title_suffix : '') }}" name="nama" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Nama">
                                                    <input type="text" name="umur" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Umur">
                                                    <input type="text" name="jenis_kelamin" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Jenis Kelamin">
                                                    <input type="text" name="alamat" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Alamat">
                                                </div>
                                            </td>
                                        </tr> -->

                                            <tr>
                                                <td style="width:20%;">Tanda Tangan:</td>
                                                <td class="d-flex">:&nbsp;
                                                    <div class="d-flex gap-3 flex-column w-100">
                                                        <canvas id="signature-pad_1" name="signature"
                                                            style="border:1px solid #000; width: 100%; max-width: 300px; height: auto; max-height: 100px;"></canvas>
                                                        <input type="hidden" name="signature" id="signature-data1">
                                                        <div class="d-flex justify-content-between mt-2">
                                                            <button id="clear1" class="btn btn-secondary"
                                                                type="button">Clear</button>
                                                            <button id="save1" class="btn btn-primary"
                                                                type="submit">Save</button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>


                                        </tbody>
                                    </table>
                            </div>

                            @csrf
                            <div class="row">
                                <div class="form-check form-check-custom form-check-solid mb-3">
                                    <input class="form-check-input" type="radio" id="Setuju" name="persetujuan"
                                        value="setuju" onchange="toggleAlasan()" />
                                    <label class="form-check-label fw-semibold text-black" for="Setuju">
                                        Setuju dengan Tindakan yang telah dijelaskan
                                    </label>
                                </div>
                                <div class="form-check form-check-custom form-check-solid mb-3">
                                    <input class="form-check-input" type="radio" id="Tidak Setuju"
                                        name="persetujuan" value="Tidak Setuju" onchange="toggleAlasan()" />
                                    <label class="form-check-label fw-semibold text-black" for="Tidak Setuju">
                                        Tidak Setuju dengan Tindakan yang telah dijelaskan
                                    </label>
                                </div>
                                <div id="alasanContainer" style="display: none;" class="mb-10">
                                    <label for="exampleFormControlInput1" class="form-label">Alasan :</label>
                                    <textarea rows="3" class="form-control form-control-solid" placeholder="Alasan" name="description"></textarea>
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

                                <button type="submit" class="btn btn-bg-dark text-white">Download PDF</button>
                            </div>
                            </form>
                        </div>
                        @include('pages.klinik.examinations.partials.components.surat._hakkewajiban')

                        <div class="tab-pane fade" id="surgicalsafetychecklist" role="tabpanel">
                            <h3 class="fs-3 fw-bold"> SURGICAL SAFETY CHECKLIST </h3>
                            <div class="table-responsive">
                                <form method="post"
                                    action="{{ route('suket.surgicalsafetychecklist', $examination->id) }}">
                                    @csrf <!-- CSRF Token to prevent 419 error -->
                                    <table class="table" style="width:100%">
                                        <tbody>

                                            <tr>
                                                <td>Nama</td>
                                                <td>:
                                                    {{ (!in_array($user->info->title_prefix, ['', '-']) ? $user->info->title_prefix . '. ' : '') . $user->name . (!in_array($user->info->title_suffix, ['', '-']) ? ', ' . $user->info->title_suffix : '') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Tempat,Tanggal Lahir</td>
                                                <td>: {{ $info->place_of_birth . ', ' . $info->date_of_birth }}</td>
                                            </tr>
                                            <tr>
                                                <td>Nomor RM</td>
                                                <td>: {{ $user->mr->medical_record_code }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <h3 class="fs-3 fw-bold">SIGN IN ( Sebelum induksi anestesi )</h3>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong> VERIFIKASI</strong></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <input type="checkbox" name="identitas_pasien"
                                                        style="margin-right: 10px;" checked>
                                                    <span style="font-size: 1em;">Identitas pasien (nama lengkap dan
                                                        tanggal lahir) dan gelang pasien</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <input type="checkbox" name="inform_consnet"
                                                        style="margin-right: 10px;" checked>
                                                    <span style="font-size: 1em;">Inform Consent</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Dokter Pelaksana Tindakan</td>
                                                <td>:
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
                                                        : '-' }}</b>
                                                    <br>
                                                    <b>{{ $examination->health_profesional && $examination->health_profesional->sip_number
                                                        ? 'SIP.' . $examination->health_profesional->sip_number
                                                        : '' }}</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <!-- <td> Identitas pasien (nama lengkap dan tanggal lahir) dan gelang pasien</td>
                                                <td class="d-flex">:&nbsp;
                                                    <div class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100"> -->
                                                <!-- <input type="text" name="prognosis" class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0" placeholder="Isi Informasi"> -->
                                                <!-- <label class="form-check form-switch form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" name="prognosis_check" value="1"/>
                                                <span class="form-check-label fw-semibold text-muted">
                                                    Check
                                                </span>
                                            </label>
                                        </div>
                                    </td>
                                </tr> -->
                                                <td>Nama Operator</td>
                                                <td class="d-flex">:&nbsp;
                                                    <div
                                                        class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                                        <input type="text" name="nama_operator"
                                                            class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                            placeholder="Isi Informasi">
                                                        <!-- <label class="form-check form-switch form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" name="nama_operator_check" value="1"/>
                                                        <span class="form-check-label fw-semibold text-muted">
                                                            Check
                                                        </span>
                                                    </label> -->
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Nama Tindakan</td>
                                                <td class="d-flex">:&nbsp;<input type="text" name="nama_tindakan"
                                                        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                        placeholder="Nama Tindakan">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Diagnosa</td>
                                                <td class="d-flex">:&nbsp;<input type="text" name="diagnosa"
                                                        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                        placeholder="Diagnosa">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> Pemberian tanda di lokasi operasi</td>
                                                <td>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            id="perdarahanYa" name="perdarahan" value="Ya"
                                                            checked />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="perdarahanYa">Ya</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            id="perdarahanTidak" name="perdarahan"
                                                            value="Tidak perlu" />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="perdarahanTidak">Tidak perlu</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>PEMERIKSAAN KELENGKAPAN ANESTESI</strong></td>
                                                <td>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="mesinAnestesi" name="kelengkapan_anestesi_mesin"
                                                            value="Mesin Anestesi" />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="mesinAnestesi">Mesin Anestesi</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="obatObatan" name="kelengkapan_anestesi_obat"
                                                            value="Obat - obatan" checked />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="obatObatan">Obat - obatan</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="laboratorium" name="kelengkapan_anestesi_laboratorium"
                                                            value="Laboratorium" />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="laboratorium">Laboratorium</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="ivLine" name="kelengkapan_anestesi_ivline"
                                                            value="IV Line" />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="ivLine">IV Line</label>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td><strong>PEMERIKSAAN TANDA VITAL</strong></td>
                                            </tr>
                                            <tr>
                                                <td>Tekanan Darah</td>
                                                <td>: {{ $examination->vitality->blood_pressure ?? '-' }} mmHg</td>
                                            </tr>
                                            <tr>
                                                <td>Nadi</td>
                                                <td>: {{ $examination->vitality->heart_rate ?? '-' }} kali/menit</td>
                                            </tr>
                                            <tr>
                                                <td>Pernafasan</td>
                                                <td>: {{ $exam->vitality->respiratory_rate ?? '-' }} kali/menit</td>
                                            </tr>
                                            <tr>
                                                <td>Saturasi O2</td>
                                                <td>: {{ $exam->vitality->oxygen_saturation ?? '-' }} %</td>
                                            </tr>
                                            <tr>
                                                <td>Suhu</td>
                                                <td>: {{ $examination->vitality->temperature ?? '-' }} °C</td>
                                            </tr>
                                            <tr>
                                                <td><strong>RIWAYAT ALERGI</strong></td>
                                                <td>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio" id="alergiAda"
                                                            name="riwayat_alergi" value="Ada"
                                                            onchange="toggleKeterangan()" />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="alergiAda">Ada</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            id="alergiTidakAda" name="riwayat_alergi"
                                                            value="Tidak Ada" onchange="toggleKeterangan()" checked />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="alergiTidakAda">Tidak Ada</label>
                                                    </div>
                                                    <div id="keteranganContainer"
                                                        style="display: none; margin-left: 20px;" class="mb-10">
                                                        <label for="keteranganAlergi" class="form-label">Keterangan
                                                            :</label>
                                                        <textarea rows="3" class="form-control form-control-solid" placeholder="Masukkan keterangan"
                                                            name="keterangan_alergi" id="keteranganAlergi"></textarea>
                                                    </div>
                                                </td>
                                            </tr>

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


                                            <tr>
                                                <td><strong>RISIKO ASPIRASI ATAU GANGGUAN PERNAFASAN</strong></td>
                                                <td>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            id="aspirasiTidak" name="aspirasi" value="Tidak"
                                                            checked />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="aspirasiTidak">Tidak</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            id="aspirasiYa" name="aspirasi"
                                                            value="Ya, dengan alat bantu" />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="aspirasiYa">Ya, dengan alat bantu</label>
                                                    </div>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>RISIKO PERDARAHAN</strong></td>
                                                <td>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            id="perdarahanTidak" name="resiko_perdarahan"
                                                            value="Tidak" checked />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="perdarahanTidak">Tidak</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            id="perdarahanYa" name="resiko_perdarahan"
                                                            value="Ya, dengan dua IV line atau CVC" />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="perdarahanYa">Ya, dengan dua IV line atau CVC</label>
                                                    </div>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>RISIKO ANESTESI</strong></td>
                                                <td>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="umum" name="risiko_perdarahan_umum"
                                                            value="Umum" />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="umum">Umum</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="spinal" name="risiko_perdarahan_spinal"
                                                            value="Spinal" />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="spinal">Spinal</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="blok" name="risiko_perdarahan_blok"
                                                            value="Blok" />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="blok">Blok</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="lokal" name="risiko_perdarahan_lokal"
                                                            value="Lokal" checked />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="lokal">Lokal</label>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="2">
                                                    <h3 class="fs-3 fw-bold">TIME OUT ( Sebelum insisi kulit )</h3>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Dokter Pelaksana Tindakan</td>
                                                <td>:
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
                                                        : '-' }}</b>
                                                    <br>
                                                    <b>{{ $examination->health_profesional && $examination->health_profesional->sip_number
                                                        ? 'SIP.' . $examination->health_profesional->sip_number
                                                        : '' }}</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>KELENGKAPAN TIM DAN FASILITAS OPERASI</strong></td>
                                                <td>
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div
                                                            class="form-check form-check-custom form-check-solid me-3">
                                                            <input class="form-check-input" type="radio"
                                                                id="lengkap" name="kelengkapan_tim" value="Lengkap"
                                                                checked />
                                                            <label class="form-check-label fw-semibold text-black"
                                                                for="lengkap">Lengkap</label>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <div
                                                            class="form-check form-check-custom form-check-solid me-3">
                                                            <input class="form-check-input" type="radio"
                                                                id="tidakLengkap" name="kelengkapan_tim"
                                                                value="Tidak Lengkap" />
                                                            <label class="form-check-label fw-semibold text-black"
                                                                for="tidakLengkap">Tidak Lengkap</label>
                                                        </div>
                                                        <input type="text" name="alasan_tidak_lengkap"
                                                            class="form-control form-control-solid border border-gray-300"
                                                            placeholder="Alasan Tidak Lengkap">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>PERIKSA KELENGKAPAN PERALATAN OPERASI</strong></td>
                                                <td>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="alatInstrument" name="kelengkapan_alat_instrument1"
                                                            value="instrument" checked />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="alatInstrument">Instrument</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="alatKasa" name="kelengkapan_alat_kasa1"
                                                            value="kasa" checked />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="alatKasa">Kasa</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="alatJarum" name="kelengkapan_alat_jarum1"
                                                            value="jarum" checked />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="alatJarum">Jarum</label>
                                                    </div>
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div
                                                            class="form-check form-check-custom form-check-solid me-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="alatDll" name="kelengkapan_alat_dll"
                                                                value="dll" />
                                                            <label class="form-check-label fw-semibold text-black"
                                                                for="alatDll">DLL</label>
                                                        </div>
                                                        <input type="text" name="keterangan_dll"
                                                            class="form-control form-control-solid border border-gray-300"
                                                            placeholder="Keterangan">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Menyebutkan Nama dan Peran Tim Operasi</strong></td>
                                                <td>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="membacakan" name="peran_tim_membacakan"
                                                            value="Membacakan Secara Verbal" checked />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="membacakan">Membacakan Secara Verbal</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="tanggalTindakan" name="peran_tim_tanggal"
                                                            value="Tanggal Tindakan" checked />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="tanggalTindakan">Tanggal Tindakan</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="namaPasien" name="peran_tim_nama_pasien"
                                                            value="Nama Lengkap dan Tgl Lahir Pasien" checked />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="namaPasien">Nama Lengkap dan Tgl Lahir Pasien</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="diagnosa" name="peran_tim_diagnosa" value="Diagnosa"
                                                            checked />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="diagnosa">Diagnosa</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="namaTindakan" name="peran_tim_nama_tindakan"
                                                            value="Nama Tindakan" checked />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="namaTindakan">Nama Tindakan</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="prosedurTindakan" name="peran_tim_prosedur"
                                                            value="Prosedur Tindakan" checked />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="prosedurTindakan">Prosedur Tindakan</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="lokasiTindakan" name="peran_tim_lokasi"
                                                            value="Lokasi Tindakan" checked />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="lokasiTindakan">Lokasi Tindakan</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="informedConsent" name="peran_tim_consent"
                                                            value="Informed Consent" checked />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="informedConsent">Informed Consent</label>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td><strong>DOKTER BEDAH :</strong></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Apakah tindakan yang dilakukan berisiko tinggi?</strong>
                                                </td>
                                                <td>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            id="risikoTinggiYa" name="risiko_tinggi"
                                                            value="Ya" />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="risikoTinggiYa">Ya</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            id="risikoTinggiTidak" name="risiko_tinggi"
                                                            value="Tidak" checked />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="risikoTinggiTidak">Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Waktu Tindakan</td>
                                                <td class="d-flex">:&nbsp;<input type="text" name="waktu_tindakan"
                                                        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                        placeholder="Waktu yang dibutuhkan">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Apakah sudah diantisipasi perdarahan?</strong></td>
                                                <td>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            id="perdarahanAntisipasiYa" name="perdarahan_antisipasi"
                                                            value="Ya" checked />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="perdarahanAntisipasiYa">Ya</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            id="perdarahanAntisipasiTidak"
                                                            name="perdarahan_antisipasi" value="Tidak" />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="perdarahanAntisipasiTidak">Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>DOKTER ANESTESI : </strong></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Apakah ada perhatian / kekhawatiran pada pasien
                                                        ini?</strong>
                                                </td>
                                                <td>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            id="perhatianYa" name="perhatian" value="Ya" />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="perhatianYa">Ya</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            id="perhatianTidak" name="perhatian" value="Tidak"
                                                            checked />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="perhatianTidak">Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Jumlah Pasien ASA</td>
                                                <td class="d-flex">:&nbsp;<input type="text" name="jumlah_pasien"
                                                        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                        placeholder="Jumlah Pasien ASA">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Apakah ada peralatan yang perlu disediakan (darah)?</strong>
                                                </td>
                                                <td>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            id="peralatanYa" name="peralatan" value="Ya" />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="peralatanYa">Ya</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            id="peralatanTidak" name="peralatan" value="Tidak"
                                                            checked />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="peralatanTidak">Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>PERAWAT :</strong></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>Apakah sudah mengecek sterilisasi alat (melalui indikator
                                                        sterilisasi)?</strong>
                                                </td>
                                                <td>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            id="sterilisasiYa" name="sterilisasi" value="Ya"
                                                            checked />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="sterilisasiYa">Ya</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            id="sterilisasiTidak" name="sterilisasi"
                                                            value="Tidak" />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="sterilisasiTidak">Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Apakah ada kesiapan peralatan yang harus
                                                        diperhatikan?</strong>
                                                </td>
                                                <td>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            id="peralatanKesiapanYa" name="kesiapan_peralatan"
                                                            value="Ya" onchange="toggleKeterangan(this)" />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="peralatanKesiapanYa">Ya</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            id="peralatanKesiapanTidak" name="kesiapan_peralatan"
                                                            value="Tidak" onchange="toggleKeterangan(this)"
                                                            checked />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="peralatanKesiapanTidak">Tidak</label>
                                                    </div>
                                                    <div id="keteranganField" style="display:none; margin-top: 10px;">
                                                        <label for="keterangan"
                                                            class="form-label fw-semibold text-black">Keterangan:</label>
                                                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td><strong>ANTIBIOTIK PROPHYLAXIS</strong></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>Apakah sudah diberikan dalam waktu sekurangnya 60 menit
                                                        sebelum tindakan?</strong>
                                                </td>
                                                <td>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            id="antibiotikYa" name="antibiotik" value="Ya" />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="antibiotikYa">Ya</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            id="antibiotikTidak" name="antibiotik" value="Tidak"
                                                            checked />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="antibiotikTidak">Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Nama Obat</td>
                                                <td class="d-flex">:&nbsp;<input type="text" name="nama_obat"
                                                        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                        placeholder="Nama Obat">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Dosis Obat</td>
                                                <td class="d-flex">:&nbsp;<input type="text" name="dosis_obat"
                                                        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                        placeholder="Dosis Obat">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Jam diberikan</td>
                                                <td class="d-flex">:&nbsp;<input type="text" name="jam_diberikan"
                                                        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                        placeholder="Jam">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>FOTO PEMERIKSAAN RADIOLOGI YANG DIPERLUKAN</strong></td>
                                                <td>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            id="radiologiDipasan" name="radiologi"
                                                            value="Dipasang" />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="radiologiDipasan">Dipasang</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            id="radiologiTidakDipasan" name="radiologi"
                                                            value="Tidak dipasang" checked />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="radiologiTidakDipasan">Tidak dipasang</label>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="2">
                                                    <h3 class="fs-3 fw-bold"> SIGN OUT ( Sebelum pasien keluar kamar
                                                        tindakan )</h3>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Secara Verbal Perawat Memastikan : </strong></td>
                                            </tr>
                                            <tr>
                                                <td>Nama Tindakan</td>
                                                <td class="d-flex">:&nbsp;<input type="text" name="nama_tindakan"
                                                        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                        placeholder="Nama Tindakan">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Kelengkapan Alat :</strong></td>
                                                <td>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="alatInstrument" name="kelengkapan_alat_instrument"
                                                            value="instrument" checked />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="alatInstrument">Instrument</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="alatKasa" name="kelengkapan_alat_kasa"
                                                            value="kasa" checked />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="alatKasa">Kasa</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="alatJarum" name="kelengkapan_alat_jarum"
                                                            value="jarum" checked />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="alatJarum">Jarum</label>
                                                    </div>
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div
                                                            class="form-check form-check-custom form-check-solid me-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="alatDll1" name="kelengkapan_alat_dll1"
                                                                value="dll" />
                                                            <label class="form-check-label fw-semibold text-black"
                                                                for="alatDll1">DLL</label>
                                                        </div>
                                                        <input type="text" name="keterangan_dll1"
                                                            class="form-control form-control-solid border border-gray-300"
                                                            placeholder="Keterangan">
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td><strong>Pelabelan specimen</strong></td>
                                                <td>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            id="pelabelanSpecimenYa" name="pelabelan_specimen"
                                                            value="ya" onchange="toggleKeterangan(this)" />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="pelabelanSpecimenYa">Ya</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            id="pelabelanSpecimenTidak" name="pelabelan_specimen"
                                                            value="tidak" onchange="toggleKeterangan(this)"
                                                            checked />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="pelabelanSpecimenTidak">Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td><strong>JENIS SPECIMEN</strong></td>
                                                <td>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="pa" name="pemeriksaan_pa" value="PA" />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="pa">PA</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="kultur" name="pemeriksaan_kultur"
                                                            value="Kultur" />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="kultur">Kultur</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="sitologi" name="pemeriksaan_sitologi"
                                                            value="Sitologi" />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="sitologi">Sitologi</label>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <strong>Apakah ada masalah peralatan yang perlu disampaikan dari
                                                        dokter Bedah?</strong>
                                                </td>
                                                <td>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            id="masalahPeralatanYa" name="masalah_peralatan"
                                                            value="Ya" />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="masalahPeralatanYa">Ya</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            id="masalahPeralatanTidak" name="masalah_peralatan"
                                                            value="Tidak" checked />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="masalahPeralatanTidak">Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Formulir permintaan pemeriksaan</strong></td>
                                                <td>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            id="formulirPemeriksaanYa" name="formulir_pemeriksaan"
                                                            value="Ya" />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="formulirPemeriksaanYa">Ya</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            id="formulirPemeriksaanTidak" name="formulir_pemeriksaan"
                                                            value="Tidak" checked />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="formulirPemeriksaanTidak">Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Telah dilengkapi identitas pasien</strong></td>
                                                <td>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            id="identitasPasienYa" name="identitas_pasien"
                                                            value="Ya" checked />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="identitasPasienYa">Ya</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            id="identitasPasienTidak" name="identitas_pasien"
                                                            value="Tidak" />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="identitasPasienTidak">Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Penjelasan oleh operator kepada keluarga pasien</strong>
                                                </td>
                                                <td>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            id="penjelasanYa" name="penjelasan_operator"
                                                            value="Ya" checked />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="penjelasanYa">Ya</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            id="penjelasanTidak" name="penjelasan_operator"
                                                            value="Tidak" />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="penjelasanTidak">Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>OBAT - OBATAN YANG DIBERIKAN SELAMA OPERASI</strong></td>
                                                <td>
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div
                                                            class="form-check form-check-custom form-check-solid me-3">
                                                            <input class="form-check-input" type="radio"
                                                                id="obatDiberikan" name="obat_operasi"
                                                                value="Diberikan" />
                                                            <label class="form-check-label fw-semibold text-black"
                                                                for="obatDiberikan">Diberikan</label>
                                                        </div>
                                                        <input type="text" name="alasan_diberikan"
                                                            class="form-control form-control-solid border border-gray-300"
                                                            placeholder="Alasan Diberikan">
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <div
                                                            class="form-check form-check-custom form-check-solid me-3">
                                                            <input class="form-check-input" type="radio"
                                                                id="obatTidakDiberikan" name="obat_operasi"
                                                                value="Tidak diberikan" checked />
                                                            <label class="form-check-label fw-semibold text-black"
                                                                for="obatTidakDiberikan">Tidak Diberikan</label>
                                                        </div>
                                                        <input type="text" name="alasan_tidak_diberikan"
                                                            class="form-control form-control-solid border border-gray-300"
                                                            placeholder="Alasan Tidak Diberikan">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>PEMERIKSAAN TANDA VITAL </strong></td>
                                            </tr>
                                            <tr>
                                                <td>Kesadaran</td>
                                                <td class="d-flex">:&nbsp;<input type="text" name="kesadaran_1"
                                                        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                        placeholder="Kesadaran">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Tekanan Darah</td>
                                                <td class="d-flex">:&nbsp;<input type="text" name="tekanan_1"
                                                        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                        placeholder="Tekanan Darah (mmHg)">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Nadi</td>
                                                <td class="d-flex">:&nbsp;<input type="text" name="nadi_1"
                                                        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                        placeholder="Nadi (kali/menit)">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Saturasi O2</td>
                                                <td class="d-flex">:&nbsp;<input type="text" name="saturasi_1"
                                                        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                        placeholder="Saturasi O2 (%)">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Suhu</td>
                                                <td class="d-flex">:&nbsp;<input type="text" name="suhu_1"
                                                        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                        placeholder="Suhu (°C)">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Pernafasan</td>
                                                <td class="d-flex">:&nbsp;<input type="text"
                                                        name="pernafasan_1"
                                                        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                        placeholder="Pernafasan (kali/menit)">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Skala nyeri</td>
                                                <td class="d-flex">:&nbsp;<input type="text"
                                                        name="skala_nyeri_1"
                                                        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                        placeholder="Skala Nyeri (Visual Analog Scale-VAS)">
                                                    <!-- <small class="text-muted fst-italic">&nbsp;(Visual Analog Scale-VAS)</small> -->
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Periksa kembali luka operasi</strong></td>
                                                <td>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            id="lukaOperasiAdaRembesan" name="luka_operasi"
                                                            value="Ada rembesan" />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="lukaOperasiAdaRembesan">Ada rembesan</label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            id="lukaOperasiTidakAdaRembesan" name="luka_operasi"
                                                            value="Tidak ada rembesan" checked />
                                                        <label class="form-check-label fw-semibold text-black"
                                                            for="lukaOperasiTidakAdaRembesan">Tidak ada
                                                            rembesan</label>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="width:20%;">Tanda Tangan :</td>
                                                <td class="d-flex">:&nbsp;
                                                    <div class="d-flex gap-3 flex-column w-100">
                                                        <canvas id="signature-pad_2" name="signature2"
                                                            style="border:1px solid #000; width: 100%; max-width: 300px; height: auto; max-height: 100px;"></canvas>
                                                        <input type="hidden" name="signature2"
                                                            id="signature-data2">
                                                        <div class="d-flex justify-content-between mt-2">
                                                            <button id="clear2" class="btn btn-secondary"
                                                                type="button">Clear</button>
                                                            <button id="save2" class="btn btn-primary"
                                                                type="submit">Save</button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                            </div>

                            @csrf
                            <div class="row">
                                <button type="submit" class="btn btn-bg-dark text-white">Download PDF</button>
                            </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
<div id="resep" style="display: none">
    <div class="d-flex flex-row" id="inputFromRow">
        <select name="resep[obat][]" aria-label="{{ __('Pilih Obat') }}"
            data-placeholder="{{ __('Pilih Obat...') }}"
            class="mb-2 form-select form-select-solid form-select-lg fw-bold me-5">
            <option value="">{{ __('Pilih Obat...') }}</option>
            @foreach ($drugs as $drug)
                <option value="{{ $drug->id }}">{{ $drug->name }}</option>
            @endforeach
        </select>
        <input placeholder="Keterangan" name="resep[keterangan][]"
            class="w-200px me-5 form-control form-control-solid" type="text">
        <input placeholder="Qty" name="resep[qty][]" class="w-100px me-5 form-control form-control-solid"
            type="number" min="1">
        <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" id="remove-item">
            <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
            <span class="svg-icon svg-icon-3">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                        fill="currentColor" />
                    <path opacity="0.5"
                        d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                        fill="currentColor" />
                    <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                        fill="currentColor" />
                </svg>
            </span>
            <!--end::Svg Icon-->
        </button>
    </div>
</div>

@section('styles')
    <style>
        .timeline-label .timeline-label {
            width: 200px !important
        }

        .timeline-label:before {
            left: 201px !important;
        }

        #penandaanoperasi {
            position: relative;
        }

        #penandaan_operasi {
            position: relative;
            /* Needed for absolute positioning of the point */
        }

        #point {
            position: absolute;
            width: 15px;
            height: 15px;
            background-color: red;
            border-radius: 50%;
        }
    </style>
@endsection

@push('customscript')
    <script>
        $(function() {
            @if ($examination->bukti_penyampaian_informasi)
                $('#button_bukti_penyampaian').show();
                $('#signature_bukti_penyampaian').hide();
            @else
                $('#button_bukti_penyampaian').hide();
                $('#signature_bukti_penyampaian').show();
            @endif

            $(document).on('click', '#remove-item', function() {
                $(this).closest('#inputFromRow').remove();
            });

            setInterval(function() {
                $.ajax({
                    url: '{{ route('bukti_penyampaian', $examination->id) }}',
                    type: 'GET',
                    success: function(data) {
                        if (data.status == 'success') {
                            $('#button_bukti_penyampaian').show();
                            $('#signature_bukti_penyampaian').hide();
                        } else {
                            $('#button_bukti_penyampaian').hide();
                            $('#signature_bukti_penyampaian').show();
                        }
                    }
                });
            }, 5000);

            $("#penandaan_operasi").click(function(e) {
                e.preventDefault();
                var containerOffset = $(".container").offset();
                var imageOffset = $("#image").offset();

                // Calculate click position relative to container, not image
                var x = e.clientX - containerOffset.left;
                var y = e.clientY - containerOffset.top;

                // Subtract container padding to position point accurately
                var pointLeft = x - $(".container").css("padding-left").replace("px", "");
                var pointTop = y - $(".container").css("padding-top").replace("px", "");
                $("#coordinate_x").val(pointLeft);
                $("#coordinate_y").val(pointTop);
                $("#point").css({
                    left: pointLeft + "px",
                    top: pointTop + "px"
                });
            });
        })
    </script>

    <script>
        document.getElementById('add-column').addEventListener('click', function() {
            var container = document.getElementById('input-container');

            var row = document.createElement('div');
            row.className = 'row mb-5';

            var col1 = document.createElement('div');
            col1.className = 'col-lg-4';

            var label1 = document.createElement('label');
            label1.className = 'col-form-label fw-bold fs-6';

            var input1 = document.createElement('input');
            input1.type = 'text';
            input1.name = 'gambar[]';
            input1.className = 'form-control form-control-solid mb-3';
            input1.placeholder = 'Gambar';

            col1.appendChild(label1);
            col1.appendChild(input1);

            var col2 = document.createElement('div');
            col2.className = 'col-lg-4';

            var label2 = document.createElement('label');
            label2.className = 'col-form-label fw-bold fs-6';

            var inputGroup = document.createElement('div');
            inputGroup.className = 'input-group input-group-solid has-validation mb-3';

            var select = document.createElement('select');
            select.name = 'odontogram_symbol_id[]';
            select.ariaLabel = '{{ __('Odontogram Code') }}';
            select.dataset.control = 'select2';
            select.dataset.placeholder = '{{ __('Select an Odontogram Code...') }}';
            select.className = 'form-select form-select-solid form-select-lg';

            var option = document.createElement('option');
            option.value = '';
            option.textContent = '{{ __('Select an Odontogram Code...') }}';
            select.appendChild(option);

            @foreach ($odontogramsymbols as $odontogramsymbol)
                var option = document.createElement('option');
                option.value = '{{ $odontogramsymbol->id }}';
                option.textContent = '{{ $odontogramsymbol->code }}';
                select.appendChild(option);
            @endforeach

            inputGroup.appendChild(select);
            col2.appendChild(label2);
            col2.appendChild(inputGroup);

            var col3 = document.createElement('div');
            col3.className = 'col-lg-4';

            var label3 = document.createElement('label');
            label3.className = 'col-form-label fw-bold fs-6';

            var input3 = document.createElement('input');
            input3.type = 'text';
            input3.name = 'keterangan[]';
            input3.className = 'form-control form-control-solid mb-3';
            input3.placeholder = 'Keterangan';

            col3.appendChild(label3);
            col3.appendChild(input3);

            row.appendChild(col1);
            row.appendChild(col2);
            row.appendChild(col3);

            container.appendChild(row);
        });
    </script>

    <script>
        var canvas = document.getElementById('signature-pad');
        var ctx = canvas.getContext('2d');
        var drawing = false;

        function getMousePos(canvas, evt) {
            var rect = canvas.getBoundingClientRect();
            return {
                x: evt.clientX - rect.left,
                y: evt.clientY - rect.top
            };
        }

        function getTouchPos(canvas, touch) {
            var rect = canvas.getBoundingClientRect();
            return {
                x: touch.touches[0].clientX - rect.left,
                y: touch.touches[0].clientY - rect.top
            };
        }

        canvas.addEventListener('mousedown', function(e) {
            drawing = true;
            var pos = getMousePos(canvas, e);
            ctx.beginPath();
            ctx.moveTo(pos.x, pos.y);
        });

        canvas.addEventListener('mousemove', function(e) {
            if (drawing) {
                var pos = getMousePos(canvas, e);
                ctx.lineTo(pos.x, pos.y);
                ctx.stroke();
            }
        });

        canvas.addEventListener('mouseup', function() {
            drawing = false;
        });

        canvas.addEventListener('touchstart', function(e) {
            drawing = true;
            var pos = getTouchPos(canvas, e);
            ctx.beginPath();
            ctx.moveTo(pos.x, pos.y);
            e.preventDefault();
        });

        canvas.addEventListener('touchmove', function(e) {
            if (drawing) {
                var pos = getTouchPos(canvas, e);
                ctx.lineTo(pos.x, pos.y);
                ctx.stroke();
            }
            e.preventDefault();
        });

        canvas.addEventListener('touchend', function() {
            drawing = false;
        });

        document.getElementById('clear').addEventListener('click', function() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        });

        document.getElementById('save').addEventListener('click', function() {
            var dataURL = canvas.toDataURL();
            document.getElementById('signature-data').value = dataURL;
            console.log("Tanda tangan disimpan sebagai data URL:", dataURL);
        });
    </script>

    <script>
        function initializeSignaturePad(canvasId, clearButtonId, saveButtonId, hiddenInputId) {
            var canvas = document.getElementById(canvasId);
            var ctx = canvas.getContext('2d');
            var drawing = false;

            function getMousePos(canvas, evt) {
                var rect = canvas.getBoundingClientRect();
                return {
                    x: evt.clientX - rect.left,
                    y: evt.clientY - rect.top
                };
            }

            function getTouchPos(canvas, touch) {
                var rect = canvas.getBoundingClientRect();
                return {
                    x: touch.touches[0].clientX - rect.left,
                    y: touch.touches[0].clientY - rect.top
                };
            }

            canvas.addEventListener('mousedown', function(e) {
                drawing = true;
                var pos = getMousePos(canvas, e);
                ctx.beginPath();
                ctx.moveTo(pos.x, pos.y);
            });

            canvas.addEventListener('mousemove', function(e) {
                if (drawing) {
                    var pos = getMousePos(canvas, e);
                    ctx.lineTo(pos.x, pos.y);
                    ctx.stroke();
                }
            });

            canvas.addEventListener('mouseup', function() {
                drawing = false;
            });

            canvas.addEventListener('touchstart', function(e) {
                drawing = true;
                var pos = getTouchPos(canvas, e);
                ctx.beginPath();
                ctx.moveTo(pos.x, pos.y);
                e.preventDefault();
            });

            canvas.addEventListener('touchmove', function(e) {
                if (drawing) {
                    var pos = getTouchPos(canvas, e);
                    ctx.lineTo(pos.x, pos.y);
                    ctx.stroke();
                }
                e.preventDefault();
            });

            canvas.addEventListener('touchend', function() {
                drawing = false;
            });

            document.getElementById(clearButtonId).addEventListener('click', function() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
            });

            document.getElementById(saveButtonId).addEventListener('click', function() {
                var dataURL = canvas.toDataURL();
                document.getElementById(hiddenInputId).value = dataURL;
                console.log("Tanda tangan disimpan sebagai data URL:", dataURL);
            });
        }

        initializeSignaturePad('signature-pad_1', 'clear1', 'save1', 'signature-data1');
        initializeSignaturePad('signature-pad_2', 'clear2', 'save2', 'signature-data2');
    </script>


    <style>
        .custom-img {
            max-width: 100%;
            height: auto;
            max-height: 400px;
        }
    </style>

    <script>
        function tampilkanPeranTim() {
            let checkboxes = document.querySelectorAll('input[name="peran_tim[]"]:checked');
            let hasil = [];

            checkboxes.forEach((checkbox) => {
                hasil.push(checkbox.value);
            });

            sessionStorage.setItem('peranTim', JSON.stringify(hasil));
        }

        document.querySelectorAll('input[name="peran_tim[]"]').forEach((checkbox) => {
            checkbox.addEventListener('change', tampilkanPeranTim);
        });
    </script>

    <script>
        var selectedDiagnoses = [];

        $(document).ready(function() {
            $('#icdtens').select2({
                ajax: {
                    url: '{{ route('icdten.search') }}', // Make sure to create this route
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function(data, params) {
                        params.page = params.page || 1;

                        return {
                            results: data.items,
                            pagination: {
                                more: (params.page * 30) < data.total_count
                            }
                        };
                    },
                    cache: true
                },
                placeholder: '{{ __('Select a Diagnosa...') }}',
                minimumInputLength: 1,
                templateResult: formatRepo,
                templateSelection: formatRepoSelection
            });

            function formatRepo(repo) {
                if (repo.loading) {
                    return repo.text;
                }

                var $container = $(
                    "<div class='select2-result-repository clearfix'>" +
                    "<div class='select2-result-repository__title'></div>" +
                    "</div>"
                );

                $container.find(".select2-result-repository__title").text(repo.code + ' - ' + repo.text);

                return $container;
            }

            function formatRepoSelection(repo) {
                return repo.code + ' - ' + repo.text || repo.code + ' - ' + repo.text;
            }
        });

        // Inisialisasi selectedDiagnoses dari nilai awal textarea
        var initialAssessment = $("#assessment").val();
        if (initialAssessment) {
            selectedDiagnoses = initialAssessment.split(' | ').map(function(item) {
                var parts = item.split(' - ');
                return {
                    code: parts[0],
                    text: parts.slice(1).join(' - ')
                };
            });
        }

        // Modified event handler for change event
        $("#icdtens").on('select2:select', function(e) {
            var data = e.params.data;
            if (!selectedDiagnoses.some(d => d.code === data.code)) {
                selectedDiagnoses.push(data);
                updateAssessment();
            }
        });

        $("#icdtens").on('select2:unselect', function(e) {
            var data = e.params.data;
            selectedDiagnoses = selectedDiagnoses.filter(function(diagnosis) {
                return diagnosis.id !== data.id;
            });
            updateAssessment();
        });

        function updateAssessment() {
            var currentText = $("#assessment").val();
            var newDiagnosis = selectedDiagnoses[selectedDiagnoses.length - 1];
            var newText = newDiagnosis.code + ' - ' + newDiagnosis.text;

            if (currentText) {
                $("#assessment").val(currentText + ' | ' + newText);
            } else {
                $("#assessment").val(newText);
            }
        }

        // Handle manual changes to #assessment
        $("#assessment").on('input', function() {
            var currentText = $(this).val();
            selectedDiagnoses = currentText.split(' | ').map(function(item) {
                var parts = item.split(' - ');
                return {
                    code: parts[0],
                    text: parts[1]
                };
            }).filter(function(item) {
                return item.code && item.text;
            });
        });
    </script>
@endpush
