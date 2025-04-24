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
                                    <i class="fas fa-stethoscope text-primary me-2"></i>Service Diagnosa
                                </h3>
                            </div>
                            <div class="card-toolbar">
                                <div class="input-group input-group-solid" style="width: 350px;">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                    <input type="text" class="form-control form-control-solid" id="searchDiagnosa"
                                           placeholder="Cari berdasarkan kode atau nama diagnosa...">
                                    <button class="btn btn-primary" type="button" id="searchButton">
                                        Cari
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
                                <p class="mt-2 text-gray-600">Mencari data diagnosa...</p>
                            </div>

                            <!-- Table View -->
                            <div class="table-responsive">
                                <table class="table table-hover align-middle gs-4 gy-4 mb-0">
                                    <thead>
                                    <tr class="fw-bold text-muted bg-light">
                                        <th class="min-w-150px ps-4">Kode Diagnosa</th>
                                        <th class="min-w-250px">Diagnosa</th>
                                        <th class="min-w-150px">Non Spesialis</th>
                                        <th class="min-w-150px text-end pe-4">Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody id="diagnosaBody">
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-5">
                                            <i class="fas fa-search fs-1 mb-3 d-block"></i>
                                            Silakan masukkan kata kunci untuk mencari diagnosa
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Empty state -->
                            <div id="emptyState" class="text-center py-5 d-none">
                                <i class="fas fa-file-medical-alt fs-1 text-muted mb-3"></i>
                                <p class="text-gray-600">Tidak ada data diagnosa yang ditemukan</p>
                                <button class="btn btn-sm btn-light-primary mt-2" id="resetSearch">
                                    <i class="fas fa-redo me-1"></i> Reset Pencarian
                                </button>
                            </div>
                        </div>
                        <div class="card-footer">
                            <!-- Simplified Pagination -->
                            <div id="paginationContainer" class="d-flex justify-content-between align-items-center flex-wrap py-2 d-none">
                                <div class="d-flex align-items-center">
                                    <span class="text-muted fs-7 me-2">Menampilkan data diagnosa dari PCare BPJS</span>
                                    <select id="pageSizeSelect" class="form-select form-select-sm form-select-solid me-2" style="width: 75px !important">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                    <span class="text-muted fs-7">dari <span id="totalItems">0</span> data</span>
                                </div>
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
                let currentPage = 1;
                let pageSize = 10;
                let totalPages = 1;
                let currentKeyword = '';

                // Search when button is clicked
                $('#searchButton').click(function () {
                    var diagnosa = $('#searchDiagnosa').val();
                    if (diagnosa.trim() === '') {
                        toastr.warning('Silakan masukkan kata kunci pencarian terlebih dahulu');
                        return;
                    }
                    currentKeyword = diagnosa;
                    currentPage = 1;
                    fetchDiagnosa(diagnosa, 0, pageSize);
                });

                // Search when Enter key is pressed
                $('#searchDiagnosa').keypress(function (e) {
                    if (e.which === 13) {
                        $('#searchButton').click();
                    }
                });

                // Reset search
                $('#resetSearch').click(function () {
                    $('#searchDiagnosa').val('');
                    $('#diagnosaBody').html('<tr><td colspan="4" class="text-center text-muted py-5"><i class="fas fa-search fs-1 mb-3 d-block"></i>Silakan masukkan kata kunci untuk mencari diagnosa</td></tr>');
                    $('#emptyState').addClass('d-none');
                    $('#paginationContainer').addClass('d-none');
                    $('#resultCount').text('0 hasil');
                    currentKeyword = '';
                });

                // Handle page size change
                $('#pageSizeSelect').change(function () {
                    pageSize = parseInt($(this).val());
                    currentPage = 1;
                    fetchDiagnosa(currentKeyword, 0, pageSize);
                });

                function fetchDiagnosa(diagnosa, start, limit) {
                    // Show loading indicator
                    $('#loadingIndicator').removeClass('d-none');
                    $('#emptyState').addClass('d-none');
                    $('#paginationContainer').addClass('d-none');

                    $.ajax({
                        url: '{{ route("pcare.get-diagnosa") }}',
                        method: 'GET',
                        data: {
                            keyword: diagnosa,
                            start: start,
                            limit: limit
                        },
                        success: function (response) {
                            console.log(response);
                            var tbody = $('#diagnosaBody');
                            tbody.empty();

                            // Hide loading indicator
                            $('#loadingIndicator').addClass('d-none');

                            if (response.response && response.response.list && response.response.list.length > 0) {
                                // Update result count
                                $('#resultCount').text(response.response.list.length + ' hasil');
                                $('#totalItems').text(response.pagination?.total || response.response.list.length);

                                // Show pagination container
                                $('#paginationContainer').removeClass('d-none');

                                // Populate table view
                                response.response.list.forEach(function (item) {
                                    var nonSpesialis = item.nonSpesialis === 'true' ?
                                        '<span class="badge badge-light-success">Ya</span>' :
                                        '<span class="badge badge-light-danger">Tidak</span>';

                                    var row = '<tr>' +
                                        '<td class="ps-4"><span class="badge badge-light-primary fw-bold">' + item.kdDiag + '</span></td>' +
                                        '<td><span class="text-dark fw-semibold">' + item.nmDiag + '</span></td>' +
                                        '<td>' + nonSpesialis + '</td>' +
                                        '<td class="text-end pe-4">' +
                                        '<div class="btn-group">' +
                                        '<button type="button" class="btn btn-sm btn-icon btn-light-primary copy-diagnosa" data-bs-toggle="tooltip" title="Salin Diagnosa" data-kode="' + item.kdDiag + '" data-nama="' + item.nmDiag + '">' +
                                        '<i class="fas fa-copy"></i>' +
                                        '</button>' +
                                        '<button type="button" class="btn btn-sm btn-icon btn-light-success select-diagnosa" data-bs-toggle="tooltip" title="Pilih Diagnosa" data-kode="' + item.kdDiag + '" data-nama="' + item.nmDiag + '">' +
                                        '<i class="fas fa-check"></i>' +
                                        '</button>' +
                                        '</div>' +
                                        '</td>' +
                                        '</tr>';
                                    tbody.append(row);
                                });

                                // Initialize tooltips
                                $('[data-bs-toggle="tooltip"]').tooltip();
                                // Calculate total pages
                                totalPages = Math.ceil((response.pagination?.total || response.response.list.length) / pageSize);
                            } else {
                                // Show empty state
                                $('#emptyState').removeClass('d-none');
                                tbody.html('<tr><td colspan="4" class="text-center text-muted py-5">Tidak ada data diagnosa yang ditemukan</td></tr>');
                            }
                        },
                        error: function (xhr, status, error) {
                            // Hide loading indicator
                            $('#loadingIndicator').addClass('d-none');

                            // Show error message
                            toastr.error('Terjadi kesalahan saat mengambil data diagnosa. Silakan coba lagi.');
                            console.error(xhr.responseText);

                            // Show empty state with error message
                            $('#diagnosaBody').html('<tr><td colspan="4" class="text-center text-danger py-5"><i class="fas fa-exclamation-triangle fs-1 mb-3 d-block"></i>Gagal memuat data. Silakan coba lagi.</td></tr>');
                        }
                    });
                }

                // Handle copy diagnosa
                $(document).on('click', '.copy-diagnosa', function () {
                    var kode = $(this).data('kode');
                    var nama = $(this).data('nama');
                    var diagnosaText = kode + ' - ' + nama;

                    // Create temporary textarea to copy text
                    var $temp = $("<textarea>");
                    $("body").append($temp);
                    $temp.val(diagnosaText).select();
                    document.execCommand("copy");
                    $temp.remove();

                    // Show success message
                    toastr.success('Diagnosa berhasil disalin: ' + diagnosaText);
                });

                // Handle select diagnosa
                $(document).on('click', '.select-diagnosa', function () {
                    var kode = $(this).data('kode');
                    var nama = $(this).data('nama');

                    // Show success message
                    toastr.success('Diagnosa berhasil dipilih: ' + kode + ' - ' + nama);


                    // Or if you want to pass the data back to a parent window/opener (if opened in a modal/popup)
                    if (window.opener && !window.opener.closed) {
                        window.opener.setSelectedDiagnosa(kode, nama);
                        window.close();
                    }
                });

                // Add pagination navigation
                function renderPagination() {
                    var paginationHtml = '<div class="d-flex justify-content-center align-items-center mt-3">';

                    // Previous button
                    paginationHtml += '<button class="btn btn-icon btn-light me-2 ' + (currentPage === 1 ? 'disabled' : '') + '" ' +
                        'id="prevPage" ' + (currentPage === 1 ? 'disabled' : '') + '>' +
                        '<i class="fas fa-chevron-left"></i></button>';

                    // Page indicator
                    paginationHtml += '<span class="text-muted mx-2">Halaman ' + currentPage + ' dari ' + totalPages + '</span>';

                    // Next button
                    paginationHtml += '<button class="btn btn-icon btn-light ms-2 ' + (currentPage === totalPages ? 'disabled' : '') + '" ' +
                        'id="nextPage" ' + (currentPage === totalPages ? 'disabled' : '') + '>' +
                        '<i class="fas fa-chevron-right"></i></button>';

                    paginationHtml += '</div>';

                    // Append pagination to container
                    $('#paginationContainer').append(paginationHtml);

                    // Add event listeners for pagination buttons
                    $('#prevPage').click(function () {
                        if (currentPage > 1) {
                            currentPage--;
                            var start = (currentPage - 1) * pageSize;
                            fetchDiagnosa(currentKeyword, start, pageSize);
                        }
                    });

                    $('#nextPage').click(function () {
                        if (currentPage < totalPages) {
                            currentPage++;
                            var start = (currentPage - 1) * pageSize;
                            fetchDiagnosa(currentKeyword, start, pageSize);
                        }
                    });
                }

                // Function to set selected diagnosa (to be called from parent window)
                window.setSelectedDiagnosa = function (kode, nama) {
                    // Implementation depends on how you want to use the selected diagnosa
                    console.log('Selected diagnosa:', kode, nama);
                };
            });
        </script>
    @endpush
</x-base-layout>
