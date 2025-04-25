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
                                    <i class="fas fa-user-md text-primary me-2"></i>Spesialis
                                </h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Loading indicator -->
                            <div id="loadingIndicator" class="text-center py-5 d-none">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2 text-gray-600">Mencari data spesialis...</p>
                            </div>

                            <!-- Table View -->
                            <div class="table-responsive">
                                <table class="table table-hover align-middle gs-4 gy-4 mb-0">
                                    <thead>
                                    <tr class="fw-bold text-muted bg-light">
                                        <th class="min-w-150px ps-4">Kode Spesialis</th>
                                        <th class="min-w-250px">Nama Spesialis</th>
                                        <th class="min-w-100px text-center">Sub Spesialis</th>
                                        <th class="min-w-150px text-end pe-4">Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody id="spesialisBody">
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-5">
                                            <i class="fas fa-user-md fs-1 mb-3 d-block"></i>
                                            Memuat data spesialis...
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Empty state -->
                            <div id="emptyState" class="text-center py-5 d-none">
                                <i class="fas fa-user-md fs-1 text-muted mb-3"></i>
                                <p class="text-gray-600">Tidak ada data spesialis yang ditemukan</p>
                                <button class="btn btn-sm btn-light-primary mt-2" id="resetSearch">
                                    <i class="fas fa-redo me-1"></i> Reset Pencarian
                                </button>
                            </div>
                        </div>
                        <div class="card-footer">
                            <!-- Simplified Info Display -->
                            <div class="d-flex justify-content-between align-items-center flex-wrap py-2">
                                <span class="text-muted fs-7">Menampilkan data spesialis dari PCare BPJS</span>
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
                fetchSpesialis(0, 100); // Initial fetch with fixed limit of 100

                function fetchSpesialis(start, limit) {
                    // Show loading indicator
                    $('#loadingIndicator').removeClass('d-none');
                    $('#emptyState').addClass('d-none');

                    $.ajax({
                        url: '{{ route("pcare.get-spesialis") }}',
                        method: 'GET',
                        data: {
                            start: start,
                            limit: limit
                        },
                        success: function (response) {
                            var tbody = $('#spesialisBody');
                            tbody.empty();

                            // Hide loading indicator
                            $('#loadingIndicator').addClass('d-none');

                            if (response.response && response.response.list && response.response.list.length > 0) {
                                // Update result count
                                $('#resultCount').text(response.response.list.length + ' hasil');

                                // Populate table view
                                response.response.list.forEach(function (item) {
                                    var row = '<tr>' +
                                        '<td class="ps-4"><span class="badge badge-light-primary fw-bold">' + item.kdSpesialis + '</span></td>' +
                                        '<td><span class="text-dark fw-semibold">' + item.nmSpesialis + '</span></td>' +
                                        '<td class="text-center">' +
                                        '<a href="{{ route("pcare.subspesialis") }}?kodeSpesialis=' + item.kdSpesialis + '" class="btn btn-sm btn-icon btn-light-info" data-bs-toggle="tooltip" title="Lihat Sub Spesialis">' +
                                        '<i class="fas fa-list-ul"></i>' +
                                        '</a>' +
                                        '</td>' +
                                        '<td class="text-end pe-4">' +
                                        '<div class="btn-group">' +
                                        '<button type="button" class="btn btn-sm btn-icon btn-light-primary copy-spesialis" data-bs-toggle="tooltip" title="Salin Data Spesialis" data-kode="' + item.kdSpesialis + '" data-nama="' + item.nmSpesialis + '">' +
                                        '<i class="fas fa-copy"></i>' +
                                        '</button>' +
                                        '<button type="button" class="btn btn-sm btn-icon btn-light-success select-spesialis" data-bs-toggle="tooltip" title="Pilih Spesialis" data-kode="' + item.kdSpesialis + '" data-nama="' + item.nmSpesialis + '">' +
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
                            toastr.error('Terjadi kesalahan saat mengambil data spesialis. Silakan coba lagi.');
                            console.error(xhr.responseText);

                            // Show empty state with error message
                            $('#spesialisBody').html('<tr><td colspan="3" class="text-center text-danger py-5"><i class="fas fa-exclamation-triangle fs-1 mb-3 d-block"></i>Gagal memuat data. Silakan coba lagi.</td></tr>');
                        }
                    });
                }

                // Handle copy spesialis
                $(document).on('click', '.copy-spesialis', function () {
                    var kode = $(this).data('kode');
                    var nama = $(this).data('nama');
                    var spesialisText = kode + ' - ' + nama;

                    // Create temporary textarea to copy text
                    var $temp = $("<textarea>");
                    $("body").append($temp);
                    $temp.val(spesialisText).select();
                    document.execCommand("copy");
                    $temp.remove();

                    // Show success message
                    toastr.success('Data spesialis berhasil disalin: ' + spesialisText);
                });

                // Handle select spesialis
                $(document).on('click', '.select-spesialis', function () {
                    var kode = $(this).data('kode');
                    var nama = $(this).data('nama');

                    // Show success message
                    toastr.success('Spesialis berhasil dipilih: ' + kode + ' - ' + nama);

                    // Or if you want to pass the data back to a parent window/opener (if opened in a modal/popup)
                    if (window.opener && !window.opener.closed) {
                        window.opener.setSelectedSpesialis(kode, nama);
                        window.close();
                    }
                });

                // Reset search handler
                $('#resetSearch').click(function() {
                    $('#searchSpesialis').val('');
                    fetchSpesialis(0, 100);
                });
            });
        </script>
    @endpush
</x-base-layout>
