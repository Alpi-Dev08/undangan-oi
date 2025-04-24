 <x-base-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('PCare Integration') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row">
                <!-- Pendaftaran Pasien Card -->
                <div class="col-md-4">
                    @include('pages.klinik.pcare.partials._pendaftaran')
                </div>

                <!-- Tabs for Peserta Information and History -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-stretch nav-pills nav-pills-custom d-flex mt-4">
                                <!--begin::Nav item-->
                                <li class="nav-item p-0 ms-0">
                                    <a class="nav-link btn btn-color-gray-400 flex-center px-3 active   " data-kt-timeline-widget-4="tab" data-bs-toggle="tab" href="#informasiPeserta">
                                        <!--begin::Title-->
                                        <span class="nav-text fw-semibold fs-4 mb-3">Informasi Peserta</span>
                                        <!--end::Title-->
                                        <!--begin::Bullet-->
                                        <span class="bullet-custom position-absolute z-index-2 w-100 h-1px top-100 bottom-n100 bg-primary rounded"></span>
                                        <!--end::Bullet-->
                                    </a>
                                </li>
                                <li class="nav-item p-0 ms-0">
                                    <a class="nav-link btn btn-color-gray-400 flex-center px-3" data-kt-timeline-widget-4="tab" data-bs-toggle="tab" href="#riwayatPendaftaran">
                                        <!--begin::Title-->
                                        <span class="nav-text fw-semibold fs-4 mb-3">Riwayat Pendaftaran</span>
                                        <!--end::Title-->
                                        <!--begin::Bullet-->
                                        <span class="bullet-custom position-absolute z-index-2 w-100 h-1px top-100 bottom-n100 bg-primary rounded"></span>
                                        <!--end::Bullet-->
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <!-- Informasi Peserta Tab -->
                                <div class="tab-pane fade show active" id="informasiPeserta" role="tabpanel">
                                    <div id="pesertaInfo" class="mt-3"></div>
                                </div>

                                <!-- Riwayat Pendaftaran Tab -->
                                <div class="tab-pane fade" id="riwayatPendaftaran" role="tabpanel">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h5 class="card-title mb-0">Riwayat Pendaftaran Peserta</h5>
                                        <div class="input-group" style="width: 300px;">
                                            <input type="date" class="form-control" id="tanggalPendaftaran" value="{{ date('Y-m-d') }}">
                                            <button class="btn btn-primary" type="button" id="fetchRiwayat">Cari</button>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>No. Kartu</th>
                                                    <th>Nama Peserta</th>
                                                    <th>Kelamin</th>
                                                    <th>Usia</th>
                                                    <th>Poli/Kegiatan</th>
                                                    <th>Sumber</th>
                                                    <th>Status</th>
                                                    <th>Hapus</th>
                                                </tr>
                                            </thead>
                                            <tbody id="riwayatPendaftaranBody">
                                                <!-- Data riwayat pendaftaran akan diisi di sini -->
                                            </tbody>
                                        </table>
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
            $(document).ready(function() {
                $('#fetchRiwayat').click(function() {
                    var tanggal = $('#tanggalPendaftaran').val();
                    fetchRiwayatPendaftaran(tanggal);
                });

                function fetchRiwayatPendaftaran(tanggal) {
                    $.ajax({
                        url: '{{ route("pcare.riwayat-pendaftaran") }}',
                        method: 'GET',
                        data: { tanggalPendaftaran: tanggal },
                        success: function(response) {
                            var tbody = $('#riwayatPendaftaranBody');
                            tbody.empty();

                            if (response.response && response.response.list) {
                                response.response.list.forEach(function(item) {
                                    var row = '<tr>' +
                                        '<td>' + item.noKartu + '</td>' +
                                        '<td>' + item.nama + '</td>' +
                                        '<td>' + item.sex + '</td>' +
                                        '<td>' + item.tglLahir + '</td>' +
                                        '<td>' + item.nmPoli + '</td>' +
                                        '<td>' + item.noUrut + '</td>' +
                                        '<td>' + item.status + '</td>' +
                                        '<td><button class="btn btn-sm btn-danger delete-pendaftaran" data-id="' + item.noKartu + '"><i class="fas fa-trash"></i></button></td>' +
                                        '</tr>';
                                    tbody.append(row);
                                });
                            } else {
                                tbody.append('<tr><td colspan="8" class="text-center">Tidak ada data</td></tr>');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error fetching data:", error);
                            $('#riwayatPendaftaranBody').html('<tr><td colspan="8" class="text-center">Error: ' + error + '</td></tr>');
                        }
                    });
                }

                // Fetch riwayat pendaftaran for today on page load
                fetchRiwayatPendaftaran('{{ date("Y-m-d") }}');

                // Handle tab change to refresh data when switching to riwayat tab
                $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
                    if ($(e.target).attr('href') === '#riwayatPendaftaran') {
                        fetchRiwayatPendaftaran($('#tanggalPendaftaran').val());
                    }
                });

                // Handle delete button click (delegation for dynamically created elements)
                $(document).on('click', '.delete-pendaftaran', function() {
                    if (confirm('Apakah Anda yakin ingin menghapus pendaftaran ini?')) {
                        var id = $(this).data('id');
                        // Add your delete logic here
                        console.log('Delete pendaftaran with ID:', id);
                        // After successful deletion, refresh the table
                        fetchRiwayatPendaftaran($('#tanggalPendaftaran').val());
                    }
                });
            });
        </script>
    @endpush
</x-base-layout>
