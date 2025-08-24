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
                                    <i class="fas fa-stethoscope text-primary me-2"></i>Sub Spesialis
                                </h3>
                            </div>
                            <div class="card-toolbar">
                                <!-- Search Input -->
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" id="searchKodeSpesialis" placeholder="Masukkan Kode Spesialis" aria-label="Kode Spesialis" style="width:200px">
                                    <button class="btn btn-primary" type="button" id="searchButton">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Loading indicator -->
                            <div id="loadingIndicator" class="text-center py-5 d-none">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2 text-gray-600">Mencari data sub spesialis...</p>
                            </div>

                            <!-- Table View -->
                            <div class="table-responsive">
                                <table class="table table-hover align-middle gs-4 gy-4 mb-0">
                                    <thead>
                                    <tr class="fw-bold text-muted bg-light">
                                        <th class="min-w-150px ps-4">Kode Sub Spesialis</th>
                                        <th class="min-w-250px">Nama Sub Spesialis</th>
                                        <th class="min-w-150px">Kode Spesialis</th>
                                        <th class="min-w-150px text-end pe-4">Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody id="subSpesialisBody">
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-5">
                                            <i class="fas fa-stethoscope fs-1 mb-3 d-block"></i>
                                            Masukkan kode spesialis untuk melihat data sub spesialis
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Empty state -->
                            <div id="emptyState" class="text-center py-5 d-none">
                                <i class="fas fa-stethoscope fs-1 text-muted mb-3"></i>
                                <p class="text-gray-600">Tidak ada data sub spesialis yang ditemukan</p>
                                <button class="btn btn-sm btn-light-primary mt-2" id="resetSearch">
                                    <i class="fas fa-redo me-1"></i> Reset Pencarian
                                </button>
                            </div>
                        </div>
                        <div class="card-footer">
                            <!-- Simplified Info Display -->
                            <div class="d-flex justify-content-between align-items-center flex-wrap py-2">
                                <span class="text-muted fs-7">Menampilkan data sub spesialis dari PCare BPJS</span>
                                <span class="badge badge-light-primary" id="resultCount">0 hasil</span>
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
                // Check if kodeSpesialis is in URL parameters
                const urlParams = new URLSearchParams(window.location.search);
                const kodeSpesialis = urlParams.get('kodeSpesialis');

                if (kodeSpesialis) {
                    // Set the value in the search input
                    $('#searchKodeSpesialis').val(kodeSpesialis);
                    // Trigger search
                    fetchSubSpesialis(kodeSpesialis);
                }

                // Search button click handler
                $('#searchButton').click(function() {
                    const kodeSpesialis = $('#searchKodeSpesialis').val().trim();
                    if (kodeSpesialis) {
                        fetchSubSpesialis(kodeSpesialis);
                    } else {
                        toastr.warning('Silakan masukkan kode spesialis terlebih dahulu');
                    }
                });

                // Enter key press in search input
                $('#searchKodeSpesialis').keypress(function(e) {
                    if (e.which === 13) {
                        $('#searchButton').click();
                    }
                });

                function fetchSubSpesialis(kodeSpesialis) {
                    // Show loading indicator
                    $('#loadingIndicator').removeClass('d-none');
                    $('#emptyState').addClass('d-none');

                    $.ajax({
                        url: '{{ route("pcare.get-subspesialis") }}',
                        method: 'GET',
                        data: {
                            keyword: kodeSpesialis
                        },
                        success: function (response) {
                            var tbody = $('#subSpesialisBody');
                            tbody.empty();

                            // Hide loading indicator
                            $('#loadingIndicator').addClass('d-none');

                            if (response.response && response.response.list && response.response.list.length > 0) {
                                // Update result count
                                $('#resultCount').text(response.response.list.length + ' hasil');

                                // Populate table view
                                response.response.list.forEach(function (item) {
                                    var row = '<tr>' +
                                        '<td class="ps-4"><span class="badge badge-light-primary fw-bold">' + item.kdSubSpesialis + '</span></td>' +
                                        '<td><span class="text-dark fw-semibold">' + item.nmSubSpesialis + '</span></td>' +
                                        '<td><span class="badge badge-light-info fw-bold">' + item.kdPoliRujuk + '</span></td>' +
                                        '<td class="text-end pe-4">' +
                                        '<div class="btn-group">' +
                                        '<button type="button" class="btn btn-sm btn-icon btn-light-primary copy-subspesialis" data-bs-toggle="tooltip" title="Salin Data Sub Spesialis" data-kode="' + item.kdSubSpesialis + '" data-nama="' + item.nmSubSpesialis + '" data-kode-spesialis="' + item.kdPoliRujuk + '">' +
                                        '<i class="fas fa-copy"></i>' +
                                        '</button>' +
                                        '<button type="button" class="btn btn-sm btn-icon btn-light-success select-subspesialis" data-bs-toggle="tooltip" title="Pilih Sub Spesialis" data-kode="' + item.kdSubSpesialis + '" data-nama="' + item.nmSubSpesialis + '" data-kode-spesialis="' + item.kdPoliRujuk + '">' +
                                        '<i class="fas fa-check"></i>' +
                                        '</button>' +
                                        '</div>' +
                                        '</td>' +
                                        '</tr>';
                                    tbody.append(row);
                                });

                                // Initialize tooltips
                                $('[data-bs-toggle="tooltip"]').tooltip();
                            } else {
                                // Show empty state
                                $('#emptyState').removeClass('d-none');
                            }
                        },
                        error: function (xhr, status, error) {
                            // Hide loading indicator
                            $('#loadingIndicator').addClass('d-none');

                            // Show error message
                            toastr.error('Terjadi kesalahan saat mengambil data sub spesialis. Silakan coba lagi.');
                            console.error(xhr.responseText);

                            // Show empty state with error message
                            $('#subSpesialisBody').html('<tr><td colspan="4" class="text-center text-danger py-5"><i class="fas fa-exclamation-triangle fs-1 mb-3 d-block"></i>Gagal memuat data. Silakan coba lagi.</td></tr>');
                        }
                    });
                }

                // Handle copy sub spesialis
                $(document).on('click', '.copy-subspesialis', function () {
                    var kode = $(this).data('kode');
                    var nama = $(this).data('nama');
                    var kodeSpesialis = $(this).data('kode-spesialis');
                    var subSpesialisText = kode + ' - ' + nama + ' (Spesialis: ' + kodeSpesialis + ')';

                    // Create temporary textarea to copy text
                    var $temp = $("<textarea>");
                    $("body").append($temp);
                    $temp.val(subSpesialisText).select();
                    document.execCommand("copy");
                    $temp.remove();

                    // Show success message
                    toastr.success('Data sub spesialis berhasil disalin: ' + subSpesialisText);
                });

                // Handle select sub spesialis
                $(document).on('click', '.select-subspesialis', function () {
                    var kode = $(this).data('kode');
                    var nama = $(this).data('nama');
                    var kodeSpesialis = $(this).data('kode-spesialis');

                    // Show success message
                    toastr.success('Sub Spesialis berhasil dipilih: ' + kode + ' - ' + nama);

                    // Or if you want to pass the data back to a parent window/opener (if opened in a modal/popup)
                    if (window.opener && !window.opener.closed) {
                        window.opener.setSelectedSubSpesialis(kode, nama, kodeSpesialis);
                        window.close();
                    }
                });

                // Reset search handler
                $('#resetSearch').click(function() {
                    $('#searchKodeSpesialis').val('');
                    $('#subSpesialisBody').html('<tr><td colspan="4" class="text-center text-muted py-5"><i class="fas fa-stethoscope fs-1 mb-3 d-block"></i>Masukkan kode spesialis untuk melihat data sub spesialis</td></tr>');
                    $('#resultCount').text('0 hasil');
                    $('#emptyState').addClass('d-none');
                });
            });
        </script>
    @endpush
</x-base-layout>
