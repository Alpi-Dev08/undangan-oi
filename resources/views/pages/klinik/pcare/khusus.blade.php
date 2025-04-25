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
                                    <i class="fas fa-notes-medical text-primary me-2"></i> Referensi Khusus
                                </h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Loading indicator -->
                            <div id="loadingIndicator" class="text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2 text-gray-600">Memuat data khusus...</p>
                            </div>

                            <!-- Table View -->
                            <div class="table-responsive">
                                <table class="table table-hover align-middle gs-4 gy-4 mb-0">
                                    <thead>
                                    <tr class="fw-bold text-muted bg-light">
                                        <th class="min-w-150px ps-4">Kode Khusus</th>
                                        <th class="min-w-250px">Nama Khusus</th>
                                        <th class="min-w-150px text-end pe-4">Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody id="khususBody">
                                    <!-- Data will be populated here -->
                                    </tbody>
                                </table>
                            </div>

                            <!-- Empty state -->
                            <div id="emptyState" class="text-center py-5 d-none">
                                <i class="fas fa-notes-medical fs-1 text-muted mb-3"></i>
                                <p class="text-gray-600">Tidak ada data khusus yang ditemukan</p>
                            </div>
                        </div>
                        <div class="card-footer">
                            <!-- Simplified Info Display -->
                            <div class="d-flex justify-content-between align-items-center flex-wrap py-2">
                                <span class="text-muted fs-7">Menampilkan data khusus dari PCare BPJS</span>
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
                // Load khusus data on page load
                fetchKhusus();

                function fetchKhusus() {
                    // Show loading indicator
                    $('#loadingIndicator').removeClass('d-none');
                    $('#emptyState').addClass('d-none');

                    $.ajax({
                        url: '{{ route("pcare.get-khusus") }}',
                        method: 'GET',
                        success: function (response) {
                            console.log(response);
                            var tbody = $('#khususBody');
                            tbody.empty();

                            // Hide loading indicator
                            $('#loadingIndicator').addClass('d-none');

                            if (response.response && response.response.list && response.response.list.length > 0) {
                                // Update result count
                                $('#resultCount').text(response.response.list.length + ' hasil');

                                // Populate table view
                                response.response.list.forEach(function (item) {
                                    var row = '<tr>' +
                                        '<td class="ps-4"><span class="badge badge-light-primary fw-bold">' + item.kdKhusus + '</span></td>' +
                                        '<td><span class="text-dark fw-semibold">' + item.nmKhusus + '</span></td>' +
                                        '<td class="text-end pe-4">' +
                                        '<div class="btn-group">' +
                                        '<button type="button" class="btn btn-sm btn-icon btn-light-primary copy-khusus" data-bs-toggle="tooltip" title="Salin Data Khusus" data-kode="' + item.kdKhusus + '" data-nama="' + item.nmKhusus + '">' +
                                        '<i class="fas fa-copy"></i>' +
                                        '</button>' +
                                        '<button type="button" class="btn btn-sm btn-icon btn-light-success select-khusus" data-bs-toggle="tooltip" title="Pilih Khusus" data-kode="' + item.kdKhusus + '" data-nama="' + item.nmKhusus + '">' +
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
                                $('#resultCount').text('0 hasil');
                            }
                        },
                        error: function (xhr, status, error) {
                            // Hide loading indicator
                            $('#loadingIndicator').addClass('d-none');

                            // Show error message
                            toastr.error('Terjadi kesalahan saat mengambil data khusus. Silakan coba lagi.');
                            console.error(xhr.responseText);

                            // Show empty state with error message
                            $('#khususBody').html('<tr><td colspan="3" class="text-center text-danger py-5"><i class="fas fa-exclamation-triangle fs-1 mb-3 d-block"></i>Gagal memuat data. Silakan coba lagi.</td></tr>');
                        }
                    });
                }

                // Handle copy khusus
                $(document).on('click', '.copy-khusus', function () {
                    var kode = $(this).data('kode');
                    var nama = $(this).data('nama');
                    var khususText = kode + ' - ' + nama;

                    // Create temporary textarea to copy text
                    var $temp = $("<textarea>");
                    $("body").append($temp);
                    $temp.val(khususText).select();
                    document.execCommand("copy");
                    $temp.remove();

                    // Show success message
                    toastr.success('Data khusus berhasil disalin: ' + khususText);
                });

                // Handle select khusus
                $(document).on('click', '.select-khusus', function () {
                    var kode = $(this).data('kode');
                    var nama = $(this).data('nama');

                    // Show success message
                    toastr.success('Khusus berhasil dipilih: ' + kode + ' - ' + nama);

                    // Or if you want to pass the data back to a parent window/opener (if opened in a modal/popup)
                    if (window.opener && !window.opener.closed) {
                        window.opener.setSelectedKhusus(kode, nama);
                        window.close();
                    }
                });
            });
        </script>
    @endpush
</x-base-layout>
