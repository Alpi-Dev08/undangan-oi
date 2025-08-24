<x-base-layout>
    <!-- Main Card -->
        <div class="card card-custom shadow-sm mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">
                        <i class="fas fa-hospital-user text-primary me-2"></i> Skrining Examination
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <!-- Form Section -->
                <form id="filterForm">
                    <div class="row g-3 mb-5">
                        <div class="col-md-6">
                            <label for="locationSelect" class="form-label fw-bold">Examination Location</label>
                            <select id="locationSelect" class="form-select form-select-solid">
                                <option value="">-- Semua Lokasi --</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="tanggalExamination" class="form-label fw-bold">Examination Date</label>
                            <input type="date" id="tanggalExamination" class="form-control form-control-solid">
                        </div>

                        <div class="col-md-12 mt-5">
                            <div class="d-flex justify-content-end">
                                <button type="button" id="resetForm" class="btn btn-light me-3">
                                    <i class="fas fa-redo me-2"></i>Reset
                                </button>
                                <button type="button" id="filterExamination" class="btn btn-primary">
                                    <i class="fas fa-search me-2"></i>Lihat Skrining
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Divider -->
                <div class="separator separator-dashed my-8"></div>    
            </div>
        </div>

        <!--begin::Card-->
        <div class="card card-xxl-stretch mb-5 mb-xl-8">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <div class="d-flex align-items-center position-relative my-1">
                <span class="svg-icon svg-icon-1 position-absolute ms-6">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="17.0365" y="15.1223"
                                    width="8.15546" height="2" rx="1"
                                    transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
                                <path
                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 
                                    19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 
                                    5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 
                                    17 11 17C14.4667 17 17 14.4667 17 
                                    11C17 7.53333 14.4667 5 11 5Z"
                                    fill="currentColor"></path>
                            </svg>
                        </span>
                        <input type="text" id="searchbox"
                            class="form-control form-control-solid border border-gray-300 w-250px ps-15"
                            placeholder="Search Skrining Examination">
                    </div>
                </h3>

                <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title=""
                data-bs-original-title="Actions">
                    @if(Auth::user()->can('klinik.read')) 
                        <button type="button" id="exportBtn" class="btn btn-success" style="margin-right: 8px;" data-export-url="{{ route('skriningexaminations.export') }}">
                            <!--begin::Svg Icon | path: icons/duotune/files/fil003.svg-->
                            <span class="svg-icon svg-icon-muted svg-icon-2hx">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3"
                                        d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22Z"
                                        fill="currentColor"/>
                                    <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor"/>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            Export Excel
                        </button>
                    @endif

                    @if(Auth::user()->can('klinik.create'))
                        <a href="{{ route('skriningexaminations.create') }}" class="btn btn-sm btn-light-primary">
                            <span class="svg-icon svg-icon-muted svg-icon-2hx">
                                <svg width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3"
                                        d="M11 13H7C6.4 13 6 12.6 6 12C6 11.4 6.4 11 7 11H11V13ZM17 
                                            11H13V13H17C17.6 13 18 12.6 18 
                                            12C18 11.4 17.6 11 17 11Z"
                                        fill="currentColor"/>
                                    <path
                                        d="M22 12C22 17.5 17.5 
                                            22 12 22C6.5 22 2 
                                            17.5 2 12C2 6.5 6.5 2 
                                            12 2C17.5 2 22 6.5 22 
                                            12ZM17 11H13V7C13 6.4 
                                            12.6 6 12 6C11.4 6 11 
                                            6.4 11 7V11H7C6.4 11 6 
                                            11.4 6 12C6 12.6 6.4 
                                            13 7 13H11V17C11 17.6 
                                            11.4 18 12 18C12.6 18 
                                            13 17.6 13 
                                            17V13H17C17.6 13 18 
                                            12.6 18 12C18 11.4 
                                            17.6 11 17 11Z"
                                        fill="currentColor"/>
                                </svg>
                            </span>
                            New Skrining Examination
                        </a>
                    @endif
                </div>
            </div>

            <!--begin::Card body-->
            <div class="card-body pt-6">
                @include('pages.klinik.skriningexaminations._table')
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
        
        @push('customscript')
        <script>
        $(document).ready(function() {
            // Kosongkan tanggal di awal
            $('#tanggalExamination').val('');

            // Tombol filter
            $('#filterExamination').on('click', function() {
                let locationId = $('#locationSelect').val();
                let examinationDate = $('#tanggalExamination').val();

                $(this).prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Memproses...');

                $.ajax({
                    url: '{{ route("skriningexaminations.filter") }}',
                    method: 'POST',
                    data: {
                        location_id: locationId,
                        examination_date: examinationDate,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        $('#filterExamination').prop('disabled', false).html('<i class="fas fa-search me-2"></i>Lihat Skrining');

                        if (res.success && res.data.length > 0) {
                            let tbody = '';
                            $.each(res.data, function(i, item) {
                                tbody += `<tr>
                                    <td>${i + 1}</td>
                                    <td>${item.first_name} ${item.last_name}</td>
                                    <td>${item.gender?.name || '-'}</td>
                                    <td>${item.location?.name || '-'}</td>
                                    <td>${item.examination_date}</td>
                                </tr>`;
                            });
                            $('#skriningTableBody').html(tbody);
                            $('#skriningTableWrapper').removeClass('d-none');
                        } else {
                            $('#skriningTableBody').html('');
                            $('#skriningTableWrapper').addClass('d-none');
                            toastr.info('Tidak ada data untuk filter tersebut.');
                        }
                    },
                    error: function(xhr) {
                        $('#filterExamination').prop('disabled', false).html('<i class="fas fa-search me-2"></i>Lihat Skrining');
                        toastr.error('Gagal memfilter data.');
                        console.error(xhr.responseText);
                    }
                });
            });

            // Reset form
            $('#resetForm').on('click', function() {
                $('#locationSelect').val('');
                $('#tanggalExamination').val('');
                $('#skriningTableBody').html('');
                $('#skriningTableWrapper').addClass('d-none');
            });

            // Export
            $('#exportBtn').on('click', function(e) {
                e.preventDefault();

                let location = $('#locationSelect').val() || '';
                let date     = $('#tanggalExamination').val() || '';

                let url = '{{ route("skriningexaminations.export") }}'
                    + '?location=' + encodeURIComponent(location)
                    + '&date=' + encodeURIComponent(date);

                window.location.href = url;
            });
        });
        </script>
        @endpush
</x-base-layout>
