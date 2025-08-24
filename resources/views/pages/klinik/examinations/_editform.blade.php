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
                        @include('pages.klinik.examinations.partials.components.surat._sehat')
                        @include('pages.klinik.examinations.partials.components.surat._sakit')
                        @include('pages.klinik.examinations.partials.components.surat._hakkewajiban')
                        @include('pages.klinik.examinations.partials.components.surat._persetujuan')
                        @include('pages.klinik.examinations.partials.components.penandaan-operasi')

                        @include('pages.klinik.examinations.partials.components.surgical-safety-checklist')

                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
<div id="resep" style="display: none">
    <div class="d-flex flex-row" id="inputFromRow">
        <select name="resep[obat][]" aria-label="{{ __('Pilih Obat') }}" data-placeholder="{{ __('Pilih Obat...') }}"
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
