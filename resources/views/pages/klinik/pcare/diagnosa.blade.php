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
                    <div class="card shadow-sm">
                        <div class="card-header py-4">
                            <div class="d-flex justify-content-between align-items-center w-100">
                                <div class="flex-1 card-title fs-3 fw-bold text-dark mb-0">
                                    <i class="fas fa-stethoscope text-primary me-2"></i>Service Diagnosa
                                </div>
                                <div class="flex-1  input-group input-group-solid" style="width: 350px;">
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
                        <div class="card-body p-0">
                            <!-- Loading indicator -->
                            <div id="loadingIndicator" class="text-center py-5 d-none">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2 text-gray-600">Mencari data diagnosa...</p>
                            </div>

                            <!-- Table container -->
                            <div class="table-responsive">
                                <table class="table table-hover align-middle gs-4 gy-4 mb-0">
                                    <thead>
                                        <tr class="fw-bold text-muted">
                                            <th class="min-w-150px ps-4">Kode Diagnosa</th>
                                            <th class="min-w-250px">Diagnosa</th>
                                            <th class="min-w-150px">Non Spesialis</th>
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
                        <div class="card-footer py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted fs-7">Menampilkan data diagnosa dari PCare BPJS</span>
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
            $(document).ready(function() {
                // Search when button is clicked
                $('#searchButton').click(function() {
                    var diagnosa = $('#searchDiagnosa').val();
                    if (diagnosa.trim() === '') {
                        toastr.warning('Silakan masukkan kata kunci pencarian terlebih dahulu');
                        return;
                    }
                    fetchDiagnosa(diagnosa);
                });

                // Search when Enter key is pressed
                $('#searchDiagnosa').keypress(function(e) {
                    if (e.which === 13) {
                        $('#searchButton').click();
                    }
                });

                // Reset search
                $('#resetSearch').click(function() {
                    $('#searchDiagnosa').val('');
                    $('#diagnosaBody').html('<tr><td colspan="4" class="text-center text-muted py-5"><i class="fas fa-search fs-1 mb-3 d-block"></i>Silakan masukkan kata kunci untuk mencari diagnosa</td></tr>');
                    $('#emptyState').addClass('d-none');
                    $('#resultCount').text('0 hasil');
                });

                function fetchDiagnosa(diagnosa) {
                    // Show loading indicator
                    $('#loadingIndicator').removeClass('d-none');
                    $('#emptyState').addClass('d-none');

                    $.ajax({
                        url: '{{ route("pcare.get-diagnosa") }}',
                        method: 'GET',
                        data: { keyword: diagnosa },
                        success: function(response) {
                            console.log(response);
                            var tbody = $('#diagnosaBody');
                            tbody.empty();

                            // Hide loading indicator
                            $('#loadingIndicator').addClass('d-none');

                            if (response.response && response.response.list && response.response.list.length > 0) {
                                // Update result count
                                $('#resultCount').text(response.response.list.length + ' hasil');

                                response.response.list.forEach(function(item) {
                                    var nonSpesialis = item.nonSpesialis === 'true' ?
                                        '<span class="badge badge-light-success">Ya</span>' :
                                        '<span class="badge badge-light-danger">Tidak</span>';

                                    var row = '<tr>' +
                                        '<td class="ps-4"><span class="badge badge-light-primary fw-bold">' + item.kdDiag + '</span></td>' +
                                        '<td><span class="text-dark fw-semibold">' + item.nmDiag + '</span></td>' +
                                        '<td>' + nonSpesialis + '</td>' +
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
                        error: function(xhr, status, error) {
                            console.error("Error fetching data:", error);
                            $('#loadingIndicator').addClass('d-none');
                            $('#diagnosaBody').html('<tr><td colspan="4" class="text-center text-danger py-5"><i class="fas fa-exclamation-circle fs-1 mb-3 d-block"></i>Error: ' + (xhr.responseJSON?.message || error) + '</td></tr>');
                            $('#resultCount').text('0 hasil');
                        }
                    });
                }

                // Handle select diagnosa button click
                $(document).on('click', '.select-diagnosa', function() {
                    var kode = $(this).data('kode');
                    var nama = $(this).data('nama');

                    // You can implement what happens when a diagnosa is selected
                    toastr.success('Diagnosa berhasil dipilih: ' + kode + ' - ' + nama);

                    // For example, you might want to fill a form or trigger another action
                    // window.opener.setDiagnosa(kode, nama);
                    // window.close();
                });

                // Handle copy diagnosa button click
                $(document).on('click', '.copy-diagnosa', function() {
                    var kode = $(this).data('kode');
                    var nama = $(this).data('nama');
                    var textToCopy = kode + ' - ' + nama;

                    // Copy to clipboard
                    navigator.clipboard.writeText(textToCopy).then(function() {
                        toastr.info('Berhasil menyalin: ' + textToCopy);
                    }, function() {
                        toastr.error('Gagal menyalin teks');
                    });
                });
            });
        </script>
    @endpush
</x-base-layout>
