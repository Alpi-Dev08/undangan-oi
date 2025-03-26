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
                    @include('pages.klinik.partials._pendaftaran')
                </div>

                <!-- Riwayat Pendaftaran Peserta Card -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Riwayat Pendaftaran Peserta</h3>
                        </div>
                        <div class="card-body">
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
                                        '</tr>';
                                    tbody.append(row);
                                });
                            } else {
                                tbody.append('<tr><td colspan="7">Tidak ada data</td></tr>');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error fetching data:", error);
                            $('#riwayatPendaftaranBody').html('<tr><td colspan="7">Error: ' + error + '</td></tr>');
                        }
                    });
                }

                // Fetch riwayat pendaftaran for today on page load
                fetchRiwayatPendaftaran('{{ date("Y-m-d") }}');
            });
        </script>
    @endpush

</x-base-layout>
