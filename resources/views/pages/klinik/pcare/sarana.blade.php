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
                                    <i class="fas fa-hospital-alt text-primary me-2"></i>Sarana
                                </h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Loading indicator -->
                            <div id="loadingIndicator" class="text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2 text-gray-600">Memuat data sarana...</p>
                            </div>

                            <!-- Table View -->
                            <div class="table-responsive">
                                <table class="table table-hover align-middle gs-4 gy-4 mb-0">
                                    <thead>
                                    <tr class="fw-bold text-muted bg-light">
                                        <th class="min-w-150px ps-4">Kode Sarana</th>
                                        <th class="min-w-250px">Nama Sarana</th>
                                        <th class="min-w-150px text-end pe-4">Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody id="saranaBody">
                                    <!-- Data will be populated here -->
                                    </tbody>
                                </table>
                            </div>

                            <!-- Empty state -->
                            <div id="emptyState" class="text-center py-5 d-none">
                                <i class="fas fa-hospital-alt fs-1 text-muted mb-3"></i>
                                <p class="text-gray-600">Tidak ada data sarana yang ditemukan</p>
                            </div>
                        </div>
                        <div class="card-footer">
                            <!-- Simplified Info Display -->
                            <div class="d-flex justify-content-between align-items-center flex-wrap py-2">
                                <span class="text-muted fs-7">Menampilkan data sarana dari PCare BPJS</span>
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
                // Load sarana data on page load
                fetchSarana();

                function fetchSarana() {
                    // Show loading indicator
                    $('#loadingIndicator').removeClass('d-none');
                    $('#emptyState').addClass('d-none');

                    $.ajax({
                        url: '{{ route("pcare.get-sarana") }}',
                        method: 'GET',
                        success: function (response) {
                            console.log(response);
                            var tbody = $('#saranaBody');
                            tbody.empty();

                            // Hide loading indicator
                            $('#loadingIndicator').addClass('d-none');

                            if (response.response && response.response.list && response.response.list.length > 0) {
                                // Update result count
                                $('#resultCount').text(response.response.list.length + ' hasil');

                                // Populate table view
                                response.response.list.forEach(function (item) {
                                    var row = '<tr>' +
                                        '<td class="ps-4"><span class="badge badge-light-primary fw-bold">' + item.kdSarana + '</span></td>' +
                                        '<td><span class="text-dark fw-semibold">' + item.nmSarana + '</span></td>' +
                                        '<td class="text-end pe-4">' +
                                        '<div class="btn-group">' +
                                        '<button type="button" class="btn btn-sm btn-icon btn-light-primary copy-sarana" data-bs-toggle="tooltip" title="Salin Data Sarana" data-kode="' + item.kdSarana + '" data-nama="' + item.nmSarana + '">' +
                                        '<i class="fas fa-copy"></i>' +
                                        '</button>' +
                                        '<button type="button" class="btn btn-sm btn-icon btn-light-success select-sarana" data-bs-toggle="tooltip" title="Pilih Sarana" data-kode="' + item.kdSarana + '" data-nama="' + item.nmSarana + '">' +
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
                            toastr.error('Terjadi kesalahan saat mengambil data sarana. Silakan coba lagi.');
                            console.error(xhr.responseText);

                            // Show empty state with error message
                            $('#saranaBody').html('<tr><td colspan="3" class="text-center text-danger py-5"><i class="fas fa-exclamation-triangle fs-1 mb-3 d-block"></i>Gagal memuat data. Silakan coba lagi.</td></tr>');
                        }
                    });
                }

                // Handle copy sarana
                $(document).on('click', '.copy-sarana', function () {
                    var kode = $(this).data('kode');
                    var nama = $(this).data('nama');
                    var saranaText = kode + ' - ' + nama;

                    // Create temporary textarea to copy text
                    var $temp = $("<textarea>");
                    $("body").append($temp);
                    $temp.val(saranaText).select();
                    document.execCommand("copy");
                    $temp.remove();

                    // Show success message
                    toastr.success('Data sarana berhasil disalin: ' + saranaText);
                });

                // Handle select sarana
                $(document).on('click', '.select-sarana', function () {
                    var kode = $(this).data('kode');
                    var nama = $(this).data('nama');

                    // Show success message
                    toastr.success('Sarana berhasil dipilih: ' + kode + ' - ' + nama);

                    // Or if you want to pass the data back to a parent window/opener (if opened in a modal/popup)
                    if (window.opener && !window.opener.closed) {
                        window.opener.setSelectedSarana(kode, nama);
                        window.close();
                    }
                });
            });
        </script>
    @endpush
</x-base-layout>
