@extends('layouts.app')

@section('title', 'Daftar Produk KFA')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Produk KFA</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="productType">Jenis Produk</label>
                                <select class="form-control" id="productType">
                                    <option value="farmasi">Farmasi</option>
                                    <option value="alkes">Alat Kesehatan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="keyword">Kata Kunci</label>
                                <input type="text" class="form-control" id="keyword" placeholder="Masukkan nama produk atau kode KFA">
                            </div>
                            <div class="col-md-2">
                                <label>&nbsp;</label>
                                <button type="button" class="btn btn-primary btn-block" id="searchBtn">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="kfa-products-table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode KFA</th>
                                        <th>Nama Produk</th>
                                        <th>Produsen</th>
                                        <th>Harga Fix</th>
                                        <th>HET</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Produk -->
    <div class="modal fade" id="kfaDetailModal" tabindex="-1" role="dialog" aria-labelledby="kfaDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kfaDetailModalLabel">Detail Produk KFA</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="kfaDetailContent">
                        <!-- Content will be loaded here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let kfaProductsTable = $('#kfa-products-table').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: "{{ route('kfa.products') }}",
                    type: 'GET',
                    data: function(d) {
                        d.product_type = $('#productType').val();
                        d.keyword = $('#keyword').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'kfa_code', name: 'kfa_code' },
                    { data: 'name', name: 'name' },
                    { data: 'manufacturer', name: 'manufacturer' },
                    { data: 'fix_price', name: 'fix_price' },
                    { data: 'het_price', name: 'het_price' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                responsive: true,
                autoWidth: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                }
            });

            $('#searchBtn').click(function() {
                kfaProductsTable.ajax.reload();
            });

            $('#keyword').keypress(function(e) {
                if (e.which == 13) {
                    kfaProductsTable.ajax.reload();
                }
            });
        });

        function viewKfaDetail(kfaCode) {
            if (!kfaCode) return;

            $('#kfaDetailContent').html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Memuat...</div>');
            $('#kfaDetailModal').modal('show');

            $.ajax({
                url: `{{ route('kfa.product-detail') }}`,
                type: 'GET',
                data: { kfa_code: kfaCode },
                success: function(response) {
                    if (response.success && response.data) {
                        let data = response.data;
                        let html = `
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Kode KFA:</strong><br>
                                    ${data.kfa_code || '-'}
                                </div>
                                <div class="col-md-6">
                                    <strong>Nama Produk:</strong><br>
                                    ${data.name || '-'}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Produsen:</strong><br>
                                    ${data.manufacturer || '-'}
                                </div>
                                <div class="col-md-6">
                                    <strong>Negara Produsen:</strong><br>
                                    ${data.manufacturer_country || '-'}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>Harga Fix:</strong><br>
                                    ${data.fix_price ? 'Rp ' + new Intl.NumberFormat('id-ID').format(data.fix_price) : '-'}
                                </div>
                                <div class="col-md-4">
                                    <strong>HET:</strong><br>
                                    ${data.het_price ? 'Rp ' + new Intl.NumberFormat('id-ID').format(data.het_price) : '-'}
                                </div>
                                <div class="col-md-4">
                                    <strong>Kemasan:</strong><br>
                                    ${data.packaging || '-'}
                                </div>
                            </div>
                        `;
                        $('#kfaDetailContent').html(html);
                    } else {
                        $('#kfaDetailContent').html('<div class="alert alert-danger">' + (response.message || 'Gagal memuat detail produk.') + '</div>');
                    }
                },
                error: function() {
                    $('#kfaDetailContent').html('<div class="alert alert-danger">Terjadi kesalahan saat memuat data.</div>');
                }
            });
        }
    </script>
@endpush