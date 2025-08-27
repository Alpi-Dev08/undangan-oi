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

                                    <!-- Catatan Rujukan -->
                                    <div class="col-md-12 mt-4">
                                        <label for="catatanRujukan" class="form-label fw-bold">Catatan Rujukan</label>
                                        <textarea id="catatanRujukan" class="form-control form-control-solid" rows="3" placeholder="Masukkan catatan rujukan"></textarea>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="col-md-12 mt-5">
                                        <div class="d-flex justify-content-end">
                                            <button type="button" id="resetForm" class="btn btn-light me-3">
                                                <i class="fas fa-redo me-2"></i>Reset
                                            </button>
                                            <button type="submit" id="submitRujukan" class="btn btn-primary">
                                                <i class="fas fa-paper-plane me-2"></i>Kirim Rujukan
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
                                    <h4 class="mb-4 fw-bold">Preview Rujukan</h4>
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
                                            <div class="col-md-12 mt-3">
                                                <div class="d-flex flex-column">
                                                    <span class="text-muted fs-7">Catatan</span>
                                                    <span class="fs-6" id="previewCatatan">-</span>
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

                // Handle catatan change
                $('#catatanRujukan').on('input', function() {
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
                    $('#previewCatatan').text('-');
                });

                // Submit form
                $('#rujukanForm').on('submit', function(e) {
                    e.preventDefault();

                    // Validate form
                    if (!validateForm()) {
                        return false;
                    }

                    // Prepare data
                    var formData = {
                        kdSpesialis: $('#spesialisSelect').val(),
                        kdSubSpesialis: $('#subspesialisSelect').val(),
                        kdSarana: $('#saranaSelect').val(),
                        tglEstRujuk: $('#tanggalRujukan').val(),
                        catatan: $('#catatanRujukan').val() || '-'
                    };

                    // Show loading state
                    $('#submitRujukan').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Mengirim...');

                    // Send AJAX request
                    $.ajax({
                        url: '{{ route("pcare.submit-rujukan-subspesialis") }}',
                        method: 'POST',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            // Reset loading state
                            $('#submitRujukan').prop('disabled', false).html('<i class="fas fa-paper-plane me-2"></i>Kirim Rujukan');

                            if (response.status) {
                                // Show success message
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'Rujukan subspesialis berhasil dikirim',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    // Reset form after success
                                    $('#resetForm').click();
                                });
                            } else {
                                // Show error message
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: response.message || 'Terjadi kesalahan saat mengirim rujukan',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            // Reset loading state
                            $('#submitRujukan').prop('disabled', false).html('<i class="fas fa-paper-plane me-2"></i>Kirim Rujukan');

                            // Parse error message
                            let errorMessage = 'Terjadi kesalahan saat mengirim rujukan';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }

                            // Show error message
                            Swal.fire({
                                title: 'Gagal!',
                                text: errorMessage,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });

                            console.error(xhr.responseText);
                        }
                    });
                });

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
                function updatePreview() {
                    // Get selected values
                    var spesialisText = $('#spesialisSelect option:selected').text() || '-';
                    var subspesialisText = $('#subspesialisSelect option:selected').text() || '-';
                    var saranaText = $('#saranaSelect option:selected').text() || '-';
                    var tanggalText = $('#tanggalRujukan').val() ? formatDate($('#tanggalRujukan').val()) : '-';
                    var catatanText = $('#catatanRujukan').val() || '-';

                    // Update preview elements
                    $('#previewSpesialis').text(spesialisText !== '-' ? spesialisText : '-');
                    $('#previewSubspesialis').text(subspesialisText !== '-' ? subspesialisText : '-');
                    $('#previewSarana').text(saranaText !== '-' ? saranaText : '-');
                    $('#previewTanggal').text(tanggalText);
                    $('#previewCatatan').text(catatanText);
                }

                // Function to format date
                function formatDate(dateString) {
                    var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                    var date = new Date(dateString);
                    return date.toLocaleDateString('id-ID', options);
                }

                // Function to validate form
                function validateForm() {
                    var isValid = true;
                    var errorMessage = '';

                    // Check required fields
                    if (!$('#spesialisSelect').val()) {
                        errorMessage = 'Silakan pilih spesialis terlebih dahulu';
                        isValid = false;
                    } else if (!$('#subspesialisSelect').val()) {
                        errorMessage = 'Silakan pilih subspesialis terlebih dahulu';
                        isValid = false;
                    } else if (!$('#saranaSelect').val()) {
                        errorMessage = 'Silakan pilih sarana terlebih dahulu';
                        isValid = false;
                    } else if (!$('#tanggalRujukan').val()) {
                        errorMessage = 'Silakan pilih tanggal rujukan terlebih dahulu';
                        isValid = false;
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
