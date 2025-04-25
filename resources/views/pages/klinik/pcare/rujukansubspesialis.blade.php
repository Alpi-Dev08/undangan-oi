<x-base-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('PCare Integration') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row">
                <div class="col-md-12">
                    <!-- Main Card -->
                    <div class="card card-custom shadow-sm mb-5">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">
                                    <i class="fas fa-hospital-user text-primary me-2"></i> Rujukan Subspesialis
                                </h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Form Section -->
                            <form id="rujukanForm">
                                <div class="row g-3 mb-5">
                                    <!-- Spesialis Selection -->
                                    <div class="col-md-6">
                                        <label for="spesialisSelect" class="form-label fw-bold">Spesialis</label>
                                        <div class="input-group">
                                            <select id="spesialisSelect" class="form-select form-select-solid" required>
                                                <option value="" selected disabled>Pilih Spesialis</option>
                                                <!-- Options will be loaded dynamically -->
                                            </select>
                                            <button type="button" id="refreshSpesialis" class="btn btn-icon btn-light">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Subspesialis Selection -->
                                    <div class="col-md-6">
                                        <label for="subspesialisSelect" class="form-label fw-bold">Subspesialis</label>
                                        <div class="input-group">
                                            <select id="subspesialisSelect" class="form-select form-select-solid" required disabled>
                                                <option value="" selected disabled>Pilih Subspesialis</option>
                                                <!-- Options will be loaded dynamically -->
                                            </select>
                                            <button type="button" id="refreshSubspesialis" class="btn btn-icon btn-light" disabled>
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </div>
                                        <div class="form-text text-muted">Pilih spesialis terlebih dahulu</div>
                                    </div>

                                    <!-- Sarana Selection -->
                                    <div class="col-md-6">
                                        <label for="saranaSelect" class="form-label fw-bold">Sarana</label>
                                        <div class="input-group">
                                            <select id="saranaSelect" class="form-select form-select-solid" required>
                                                <option value="" selected disabled>Pilih Sarana</option>
                                                <!-- Options will be loaded dynamically -->
                                            </select>
                                            <button type="button" id="refreshSarana" class="btn btn-icon btn-light">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Tanggal Rujukan -->
                                    <div class="col-md-6">
                                        <label for="tanggalRujukan" class="form-label fw-bold">Tanggal Rujukan</label>
                                        <input type="date" id="tanggalRujukan" class="form-control form-control-solid" required>
                                    </div>
                                    <!-- Submit Button -->
                                    <div class="col-md-12 mt-5">
                                        <div class="d-flex justify-content-end">
                                            <button type="button" id="resetForm" class="btn btn-light me-3">
                                                <i class="fas fa-redo me-2"></i>Reset
                                            </button>
                                            <button type="button" id="filterRujukan" class="btn btn-primary">
                                                <i class="fas fa-search me-2"></i>Lihat Rujukan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <!-- Divider -->
                            <div class="separator separator-dashed my-8"></div>

                            <!-- Preview Section -->
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="mb-4 fw-bold">Preview Rujukan Subspesialis</h4>
                                    <div class="border rounded p-6 bg-light-primary">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="d-flex flex-column">
                                                    <span class="text-muted fs-7">Spesialis</span>
                                                    <span class="fs-6 fw-bold" id="previewSpesialis">-</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex flex-column">
                                                    <span class="text-muted fs-7">Subspesialis</span>
                                                    <span class="fs-6 fw-bold" id="previewSubspesialis">-</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex flex-column">
                                                    <span class="text-muted fs-7">Sarana</span>
                                                    <span class="fs-6 fw-bold" id="previewSarana">-</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex flex-column">
                                                    <span class="text-muted fs-7">Tanggal Rujukan</span>
                                                    <span class="fs-6 fw-bold" id="previewTanggal">-</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- Divider -->
                            <div class="separator separator-dashed my-8"></div>

                            <!-- Results Table Section -->
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <h4 class="mb-4 fw-bold">Hasil Rujukan Subspesialis</h4>
                                    <div id="rujukanTableWrapper" class="d-none">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-row-bordered gy-5 gs-7">
                                                <thead>
                                                <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
                                                    <th>No.</th>
                                                    <th>Kode PPK</th>
                                                    <th>Nama PPK</th>
                                                    <th>Alamat</th>
                                                    <th>Telepon</th>
                                                    <th>Kelas</th>
                                                    <th>Jadwal</th>
                                                </tr>
                                                </thead>
                                                <tbody id="rujukanTableBody">
                                                <!-- Data will be populated dynamically -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div id="noDataMessage" class="alert alert-info d-flex align-items-center p-5">
                                        <i class="fas fa-info-circle fs-2x text-info me-4"></i>
                                        <div class="d-flex flex-column">
                                            <h4 class="mb-1 text-info">Belum Ada Data</h4>
                                            <span>Silakan gunakan filter di atas untuk melihat data rujukan subspesialis</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('customscript')
        <script>
            $(document).ready(function () {
                // Set default date to today
                var today = new Date().toISOString().split('T')[0];
                $('#tanggalRujukan').val(today);

                // Load initial data
                loadSpesialis();
                loadSarana();

                // Refresh buttons
                $('#refreshSpesialis').on('click', function() {
                    loadSpesialis();
                });

                $('#refreshSubspesialis').on('click', function() {
                    if ($('#spesialisSelect').val()) {
                        loadSubspesialis($('#spesialisSelect').val());
                    }
                });

                $('#refreshSarana').on('click', function() {
                    loadSarana();
                });

                // Handle spesialis change
                $('#spesialisSelect').on('change', function() {
                    var spesialisKode = $(this).val();
                    if (spesialisKode) {
                        loadSubspesialis(spesialisKode);
                        updatePreview();
                    } else {
                        // Reset subspesialis dropdown
                        $('#subspesialisSelect').empty().append('<option value="" selected disabled>Pilih Subspesialis</option>').prop('disabled', true);
                        $('#refreshSubspesialis').prop('disabled', true);
                    }
                });

                // Handle subspesialis change
                $('#subspesialisSelect').on('change', function() {
                    updatePreview();
                });

                // Handle sarana change
                $('#saranaSelect').on('change', function() {
                    updatePreview();
                });

                // Handle tanggal change
                $('#tanggalRujukan').on('change', function() {
                    updatePreview();
                });

                // Reset form
                $('#resetForm').on('click', function() {
                    $('#rujukanForm')[0].reset();
                    $('#tanggalRujukan').val(today);
                    $('#subspesialisSelect').empty().append('<option value="" selected disabled>Pilih Subspesialis</option>').prop('disabled', true);
                    $('#refreshSubspesialis').prop('disabled', true);

                    // Reset preview
                    $('#previewSpesialis').text('-');
                    $('#previewSubspesialis').text('-');
                    $('#previewSarana').text('-');
                    $('#previewTanggal').text('-');

                    // Hide table and show no data message
                    $('#rujukanTableWrapper').addClass('d-none');
                    $('#noDataMessage').removeClass('d-none');
                });

                // Filter button click
                $('#filterRujukan').on('click', function() {
                    // Validate form
                    if (!validateForm()) {
                        return false;
                    }

                    // Show loading state
                    $(this).prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...');

                    // Prepare form data
                    var formData = {
                        kodeSarana: $('#saranaSelect').val(),
                        kodeSubSpesialis: $('#subspesialisSelect').val(),
                        tanggalRujuk: $('#tanggalRujukan').val()
                    };

                    // Send AJAX request
                    $.ajax({
                        url: '{{ route("pcare.filter-rujukan-subspesialis") }}',
                        method: 'POST',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            // Reset loading state
                            $('#filterRujukan').prop('disabled', false).html('<i class="fas fa-search me-2"></i>Lihat Rujukan');
                            console.log(response);
                            if (response.response && response.response.list && response.response.list.length > 0) {
                                // Update preview with current selections
                                updatePreview();

                                // Clear existing table data
                                $('#rujukanTableBody').empty();

                                // Check if we have data to display
                                if (response.response && response.response.list && response.response.list.length > 0) {
                                    // Populate table with data
                                    $.each(response.response.list, function(index, item) {
                                        var row = '<tr>' +
                                            '<td>' + (index + 1) + '</td>' +
                                            '<td>' + (item.kdppk || '-') + '</td>' +
                                            '<td>' + (item.nmppk || '-') + '</td>' +
                                            '<td>' + (item.alamatPpk || '-') + '- '+ (item.nmkc || '-') +'</td>' +
                                            '<td>' + (item.telpPpk || '-') + '</td>' +
                                            '<td>' + (item.kelas || '-') + '</td>' +
                                            '<td>' + (item.jadwal || '-') + '</td>' +
                                            '</tr>';
                                        $('#rujukanTableBody').append(row);
                                    });

                                    // Show table and hide no data message
                                    $('#rujukanTableWrapper').removeClass('d-none');
                                    $('#noDataMessage').addClass('d-none');

                                    // Show success message
                                    toastr.success('Data rujukan subspesialis berhasil ditampilkan');
                                } else {
                                    // Hide table and show no data message
                                    $('#rujukanTableWrapper').addClass('d-none');
                                    $('#noDataMessage').removeClass('d-none');

                                    // Show info message
                                    toastr.info('Tidak ada data rujukan subspesialis yang tersedia untuk kriteria yang dipilih');
                                }

                                // Log the response data for debugging
                                console.log('Rujukan Subspesialis Data:', response.data);
                            } else {
                                // Hide table and show no data message
                                $('#rujukanTableWrapper').addClass('d-none');
                                $('#noDataMessage').removeClass('d-none');

                                toastr.error(response.message || 'Terjadi kesalahan saat memfilter data rujukan subspesialis');
                            }
                        },
                        error: function(xhr, status, error) {
                            // Reset loading state
                            $('#filterRujukan').prop('disabled', false).html('<i class="fas fa-search me-2"></i>Lihat Rujukan');

                            // Hide table and show no data message
                            $('#rujukanTableWrapper').addClass('d-none');
                            $('#noDataMessage').removeClass('d-none');

                            // Parse error response
                            var errorMessage = 'Terjadi kesalahan saat memfilter data rujukan subspesialis';
                            try {
                                var errorResponse = JSON.parse(xhr.responseText);
                                errorMessage = errorResponse.message || errorMessage;
                            } catch (e) {
                                console.error('Error parsing error response:', e);
                            }

                            toastr.error(errorMessage);
                            console.error('AJAX Error:', xhr.responseText);
                        }
                    });
                });

                // Function to format distance
                function formatDistance(distance) {
                    if (distance === undefined || distance === null) return '-';
                    return parseFloat(distance).toFixed(2) + ' km';
                }

                // Function to format jadwal
                function formatJadwal(jadwal) {
                    if (!jadwal) return '-';

                    // Replace semicolons with line breaks for better readability
                    return jadwal.replace(/;/g, '<br>');
                }

                // Function to load spesialis data
                function loadSpesialis() {
                    // Show loading state
                    $('#spesialisSelect').prop('disabled', true);
                    $('#refreshSpesialis').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

                    $.ajax({
                        url: '{{ route("pcare.get-spesialis") }}',
                        method: 'GET',
                        success: function(response) {
                            // Reset loading state
                            $('#spesialisSelect').prop('disabled', false);
                            $('#refreshSpesialis').prop('disabled', false).html('<i class="fas fa-sync-alt"></i>');

                            var select = $('#spesialisSelect');
                            select.empty();
                            select.append('<option value="" selected disabled>Pilih Spesialis</option>');

                            if (response.response && response.response.list && response.response.list.length > 0) {
                                response.response.list.forEach(function(item) {
                                    select.append('<option value="' + item.kdSpesialis + '">' + item.nmSpesialis + ' (' + item.kdSpesialis + ')</option>');
                                });
                            } else {
                                select.append('<option value="" disabled>Tidak ada data spesialis</option>');
                                toastr.warning('Tidak ada data spesialis yang tersedia');
                            }
                        },
                        error: function(xhr, status, error) {
                            // Reset loading state
                            $('#spesialisSelect').prop('disabled', false);
                            $('#refreshSpesialis').prop('disabled', false).html('<i class="fas fa-sync-alt"></i>');

                            toastr.error('Gagal memuat data spesialis. Silakan coba lagi.');
                            console.error(xhr.responseText);
                        }
                    });
                }

                // Function to load subspesialis data
                function loadSubspesialis(kdSpesialis) {
                    // Show loading state
                    $('#subspesialisSelect').prop('disabled', true);
                    $('#refreshSubspesialis').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

                    $.ajax({
                        url: '{{ route("pcare.get-subspesialis") }}',
                        method: 'GET',
                        data: {
                            keyword: kdSpesialis
                        },
                        success: function(response) {
                            // Reset loading state
                            $('#subspesialisSelect').prop('disabled', false);
                            $('#refreshSubspesialis').prop('disabled', false).html('<i class="fas fa-sync-alt"></i>');

                            var select = $('#subspesialisSelect');
                            select.empty();
                            select.append('<option value="" selected disabled>Pilih Subspesialis</option>');

                            if (response.response && response.response.list && response.response.list.length > 0) {
                                response.response.list.forEach(function(item) {
                                    select.append('<option value="' + item.kdSubSpesialis + '">' + item.nmSubSpesialis + ' (' + item.kdSubSpesialis + ')</option>');
                                });
                            } else {
                                select.append('<option value="" disabled>Tidak ada data subspesialis</option>');
                                toastr.warning('Tidak ada data subspesialis untuk spesialis yang dipilih');
                            }
                        },
                        error: function(xhr, status, error) {
                            // Reset loading state
                            $('#subspesialisSelect').prop('disabled', false);
                            $('#refreshSubspesialis').prop('disabled', false).html('<i class="fas fa-sync-alt"></i>');

                            toastr.error('Gagal memuat data subspesialis. Silakan coba lagi.');
                            console.error(xhr.responseText);
                        }
                    });
                }

                // Function to load sarana data
                function loadSarana() {
                    // Show loading state
                    $('#saranaSelect').prop('disabled', true);
                    $('#refreshSarana').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

                    $.ajax({
                        url: '{{ route("pcare.get-sarana") }}',
                        method: 'GET',
                        success: function(response) {
                            // Reset loading state
                            $('#saranaSelect').prop('disabled', false);
                            $('#refreshSarana').prop('disabled', false).html('<i class="fas fa-sync-alt"></i>');

                            var select = $('#saranaSelect');
                            select.empty();
                            select.append('<option value="" selected disabled>Pilih Sarana</option>');

                            if (response.response && response.response.list && response.response.list.length > 0) {
                                response.response.list.forEach(function(item) {
                                    select.append('<option value="' + item.kdSarana + '">' + item.nmSarana + ' (' + item.kdSarana + ')</option>');
                                });
                            } else {
                                select.append('<option value="" disabled>Tidak ada data sarana</option>');
                                toastr.warning('Tidak ada data sarana yang tersedia');
                            }
                        },
                        error: function(xhr, status, error) {
                            // Reset loading state
                            $('#saranaSelect').prop('disabled', false);
                            $('#refreshSarana').prop('disabled', false).html('<i class="fas fa-sync-alt"></i>');

                            toastr.error('Gagal memuat data sarana. Silakan coba lagi.');
                            console.error(xhr.responseText);
                        }
                    });
                }

            // Function to update preview
                // Function to update preview
                function updatePreview() {
                    // Get selected values
                    var spesialisText = $('#spesialisSelect option:selected').text() || '-';
                    var subspesialisText = $('#subspesialisSelect option:selected').text() || '-';
                    var saranaText = $('#saranaSelect option:selected').text() || '-';
                    var tanggalText = $('#tanggalRujukan').val() || '-';

                    // Update preview
                    $('#previewSpesialis').text(spesialisText !== '-' ? spesialisText : '-');
                    $('#previewSubspesialis').text(subspesialisText !== '-' ? subspesialisText : '-');
                    $('#previewSarana').text(saranaText !== '-' ? saranaText : '-');
                    $('#previewTanggal').text(tanggalText !== '-' ? formatDate(tanggalText) : '-');
                }

                // Function to format date
                function formatDate(dateString) {
                    var options = { year: 'numeric', month: 'long', day: 'numeric' };
                    return new Date(dateString).toLocaleDateString('id-ID', options);
                }

                // Function to validate form
                function validateForm() {
                    var isValid = true;
                    var errorMessage = '';

                    // Check if spesialis is selected
                    if (!$('#spesialisSelect').val()) {
                        isValid = false;
                        errorMessage = 'Silakan pilih Spesialis';
                    }
                    // Check if subspesialis is selected
                    else if (!$('#subspesialisSelect').val()) {
                        isValid = false;
                        errorMessage = 'Silakan pilih Subspesialis';
                    }
                    // Check if sarana is selected
                    else if (!$('#saranaSelect').val()) {
                        isValid = false;
                        errorMessage = 'Silakan pilih Sarana';
                    }
                    // Check if tanggal is selected
                    else if (!$('#tanggalRujukan').val()) {
                        isValid = false;
                        errorMessage = 'Silakan pilih Tanggal Rujukan';
                    }

                    // Show error message if validation fails
                    if (!isValid) {
                        toastr.error(errorMessage);
                    }

                    return isValid;
                }
            });
        </script>
@endpush
</x-base-layout>
