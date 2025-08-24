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
                                    <i class="fas fa-hospital text-primary me-2"></i>Provider / Fasilitas Kesehatan
                                </h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Loading indicator -->
                            <div id="loadingIndicator" class="text-center py-5 d-none">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2 text-gray-600">Mencari data provider/fasilitas kesehatan...</p>
                            </div>

                            <!-- Table View -->
                            <div class="table-responsive">
                                <table class="table table-hover align-middle gs-4 gy-4 mb-0">
                                    <thead>
                                    <tr class="fw-bold text-muted bg-light">
                                        <th class="min-w-150px ps-4">Kode Provider</th>
                                        <th class="min-w-250px">Nama Provider</th>
                                        <th class="min-w-150px text-end pe-4">Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody id="providerBody">
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-5">
                                            <i class="fas fa-hospital fs-1 mb-3 d-block"></i>
                                            Memuat data provider/fasilitas kesehatan...
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Empty state -->
                            <div id="emptyState" class="text-center py-5 d-none">
                                <i class="fas fa-hospital fs-1 text-muted mb-3"></i>
                                <p class="text-gray-600">Tidak ada data provider/fasilitas kesehatan yang ditemukan</p>
                                <button class="btn btn-sm btn-light-primary mt-2" id="resetSearch">
                                    <i class="fas fa-redo me-1"></i> Reset Pencarian
                                </button>
                            </div>
                        </div>
                        <div class="card-footer">
                            <!-- Simplified Pagination -->
                            <div id="paginationContainer" class="d-flex justify-content-between align-items-center flex-wrap py-2">
                                <div class="d-flex align-items-center">
                                    <span class="text-muted fs-7 me-2">Menampilkan data provider dari PCare BPJS</span>
                                    <select id="pageSizeSelect" class="form-select form-select-sm form-select-solid me-2" style="width: 75px !important">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
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

                fetchProvider(0, pageSize); // Initial fetch

                // Handle page size change
                $('#pageSizeSelect').change(function () {
                    pageSize = parseInt($(this).val());
                    currentPage = 1;
                    fetchProvider(0, pageSize);
                });

                // Handle search button click
                $('#searchButton').click(function() {
                    currentPage = 1;
                    fetchProvider(0, pageSize);
                });

                // Handle enter key on search input
                $('#searchProvider').keypress(function(e) {
                    if(e.which === 13) {
                        currentPage = 1;
                        fetchProvider(0, pageSize);
                    }
                });

                function fetchProvider(start, limit) {
                    // Show loading indicator
                    $('#loadingIndicator').removeClass('d-none');
                    $('#emptyState').addClass('d-none');

                    $.ajax({
                        url: '{{ route("pcare.provider") }}',
                        method: 'GET',
                        data: {
                            start: start,
                            limit: limit
                        },
                        success: function (response) {
                            console.log(response);
                            var tbody = $('#providerBody');
                            tbody.empty();

                            // Hide loading indicator
                            $('#loadingIndicator').addClass('d-none');

                            if (response.response && response.response.list && response.response.list.length > 0) {
                                // Update result count
                                $('#resultCount').text(response.response.list.length + ' hasil');
                                $('#totalItems').text(response.response.total || response.response.list.length);

                                // Populate table view
                                response.response.list.forEach(function (item) {
                                    var row = '<tr>' +
                                        '<td class="ps-4"><span class="badge badge-light-primary fw-bold">' + item.kdProvider + '</span></td>' +
                                        '<td><span class="text-dark fw-semibold">' + item.nmProvider + '</span></td>' +
                                        '<td class="text-end pe-4">' +
                                        '<div class="btn-group">' +
                                        '<button type="button" class="btn btn-sm btn-icon btn-light-primary copy-provider" data-bs-toggle="tooltip" title="Salin Data Provider" data-kode="' + item.kdProvider + '" data-nama="' + item.nmProvider + '">' +
                                        '<i class="fas fa-copy"></i>' +
                                        '</button>' +
                                        '<button type="button" class="btn btn-sm btn-icon btn-light-success select-provider" data-bs-toggle="tooltip" title="Pilih Provider" data-kode="' + item.kdProvider + '" data-nama="' + item.nmProvider + '">' +
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
                                totalPages = Math.ceil((response.response.total || response.response.list.length) / pageSize);

                                // Render pagination
                                renderPagination();
                            } else {
                                // Show empty state
                                $('#emptyState').removeClass('d-none');
                                //tbody.html('<tr><td colspan="3" class="text-center text-muted py-5">Tidak ada data provider/fasilitas kesehatan yang ditemukan</td></tr>');
                            }
                        },
                        error: function (xhr, status, error) {
                            // Hide loading indicator
                            $('#loadingIndicator').addClass('d-none');

                            // Show error message
                            toastr.error('Terjadi kesalahan saat mengambil data provider. Silakan coba lagi.');
                            console.error(xhr.responseText);

                            // Show empty state with error message
                            $('#providerBody').html('<tr><td colspan="3" class="text-center text-danger py-5"><i class="fas fa-exclamation-triangle fs-1 mb-3 d-block"></i>Gagal memuat data. Silakan coba lagi.</td></tr>');
                        }
                    });
                }

                // Handle copy provider
                $(document).on('click', '.copy-provider', function () {
                    var kode = $(this).data('kode');
                    var nama = $(this).data('nama');
                    var providerText = kode + ' - ' + nama;

                    // Create temporary textarea to copy text
                    var $temp = $("<textarea>");
                    $("body").append($temp);
                    $temp.val(providerText).select();
                    document.execCommand("copy");
                    $temp.remove();

                    // Show success message
                    toastr.success('Data provider berhasil disalin: ' + providerText);
                });

                // Handle select provider
                $(document).on('click', '.select-provider', function () {
                    var kode = $(this).data('kode');
                    var nama = $(this).data('nama');

                    // Show success message
                    toastr.success('Provider berhasil dipilih: ' + kode + ' - ' + nama);

                    // Or if you want to pass the data back to a parent window/opener (if opened in a modal/popup)
                    if (window.opener && !window.opener.closed) {
                        window.opener.setSelectedProvider(kode, nama);
                        window.close();
                    }
                });

                // Render pagination function
                function renderPagination() {
                    // Clear existing pagination
                    $('.pagination').remove();

                    if (totalPages <= 1) {
                        return;
                    }

                    // Add pagination controls if needed
                    var paginationHtml = '<div class="d-flex justify-content-center mt-3">' +
                        '<ul class="pagination pagination-circle">';

                    // Previous button
                    // Previous button
                    paginationHtml += '<li class="page-item ' + (currentPage === 1 ? 'disabled' : '') + '">' +
                        '<a class="page-link" href="#" data-page="prev">' +
                        '<i class="fas fa-angle-left"></i>' +
                        '</a>' +
                        '</li>';

                    // Page numbers
                    var startPage = Math.max(1, currentPage - 2);
                    var endPage = Math.min(totalPages, startPage + 4);

                    if (startPage > 1) {
                        paginationHtml += '<li class="page-item"><a class="page-link" href="#" data-page="1">1</a></li>';
                        if (startPage > 2) {
                            paginationHtml += '<li class="page-item disabled"><span class="page-link">...</span></li>';
                        }
                    }

                    for (var i = startPage; i <= endPage; i++) {
                        paginationHtml += '<li class="page-item ' + (i === currentPage ? 'active' : '') + '">' +
                            '<a class="page-link" href="#" data-page="' + i + '">' + i + '</a>' +
                            '</li>';
                    }

                    if (endPage < totalPages) {
                        if (endPage < totalPages - 1) {
                            paginationHtml += '<li class="page-item disabled"><span class="page-link">...</span></li>';
                        }
                        paginationHtml += '<li class="page-item"><a class="page-link" href="#" data-page="' + totalPages + '">' + totalPages + '</a></li>';
                    }

                    // Next button
                    paginationHtml += '<li class="page-item ' + (currentPage === totalPages ? 'disabled' : '') + '">' +
                        '<a class="page-link" href="#" data-page="next">' +
                        '<i class="fas fa-angle-right"></i>' +
                        '</a>' +
                        '</li>';

                    paginationHtml += '</ul></div>';

                    $('#paginationContainer').append(paginationHtml);

                    // Add click event for pagination
                    $('.pagination .page-link').click(function (e) {
                        e.preventDefault();
                        var page = $(this).data('page');

                        if (page === 'prev') {
                            if (currentPage > 1) {
                                currentPage--;
                            }
                        } else if (page === 'next') {
                            if (currentPage < totalPages) {
                                currentPage++;
                            }
                        } else {
                            currentPage = parseInt(page);
                        }

                        // Calculate start index
                        var start = (currentPage - 1) * pageSize;

                        // Fetch data for the new page
                        fetchProvider(start, pageSize);
                    });
                }

                // Reset search handler
                $('#resetSearch').click(function() {
                    $('#searchProvider').val('');
                    searchTerm = '';
                    currentPage = 1;
                    fetchProvider(0, pageSize);
                });
            });
        </script>
    @endpush
</x-base-layout>
