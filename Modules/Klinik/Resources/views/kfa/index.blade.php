<x-base-layout>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Integrasi KFA (National Formulary) SATUSEHAT</h3>
        </div>
        <div class="card-body">
            <!-- Search Form -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Cari Produk KFA</h4>
                        </div>
                        <div class="card-body">
                            <form id="kfaSearchForm" class="mb-4">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label">Tipe Produk</label>
                                        <select class="form-select" id="productType" required>
                                            <option value="farmasi">Farmasi</option>
                                            <option value="alkes">Alat Kesehatan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Kata Kunci</label>
                                        <input type="text" class="form-control" id="keyword"
                                            placeholder="Masukkan nama produk...">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">&nbsp;</label>
                                        <button type="submit" class="btn btn-primary d-block">Cari</button>
                                    </div>
                                </div>
                            </form>

                            <!-- KFA Products DataTable -->
                            <div class="table-responsive">
                                <table id="kfa-products-table" class="table table-striped table-row-bordered gy-5 gs-7">
                                    <thead>
                                        <tr>
                                            <th>Aksi</th>
                                            <th>Kode</th>
                                            <th>Nama Produk</th>
                                            <th>Merk</th>
                                            <th>Manufaktur</th>
                                            <th>Harga</th>
                                            <th>Tipe</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Synced Drugs DataTable -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Obat yang Sudah Disinkronkan</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="kfa-synced-drugs-table" class="table table-striped table-row-bordered gy-5 gs-7">
                                    <thead>
                                        <tr>
                                            <th>Aksi</th>
                                            <th>Kode Obat</th>
                                            <th>Nama Obat</th>
                                            <th>Kode KFA</th>
                                            <th>Harga</th>
                                            <th>Tanggal Sinkronisasi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Drug Sync -->
    <div class="modal fade" id="syncModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sinkronisasi dengan Obat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="syncForm">
                        <div class="mb-3">
                            <label class="form-label">Pilih Obat</label>
                            <select class="form-select" id="drugSelect" required>
                                <option value="">Pilih obat...</option>
                            </select>
                        </div>
                        <input type="hidden" id="kfaCode" value="">
                        <input type="hidden" id="kfaIdentifier" value="">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="syncButton">Sinkronkan</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Inject Scripts --}}
    @push('customscript')
        <script>
            $(document).ready(function() {
                // Initialize DataTables
                initializeKfaProductsTable();
                initializeKfaSyncedDrugsTable();
                
                // Load drugs for sync modal
                loadDrugsForSelect();

                // Search form submission
                $('#kfaSearchForm').on('submit', function(e) {
                    e.preventDefault();
                    $('#kfa-products-table').DataTable().ajax.reload();
                });

                // Sync button click
                $('#syncButton').on('click', syncDrugWithKfa);

                // Handle sync button clicks on DataTable
                $('#kfa-products-table').on('click', '.sync-btn', function() {
                    const kfaCode = $(this).data('kfa-code');
                    const productCode = $(this).data('product-code');
                    openSyncModal(kfaCode, 'kfa');
                });

                // Handle view detail clicks on synced drugs DataTable
                $('#kfa-synced-drugs-table').on('click', '.view-btn', function() {
                    const kfaCode = $(this).data('kfa-code');
                    viewKfaDetail(kfaCode);
                });
            });

            function initializeKfaProductsTable() {
                $('#kfa-products-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '/api/v1/kfa/products',
                        data: function(d) {
                            d.product_type = $('#productType').val();
                            d.keyword = $('#keyword').val();
                        }
                    },
                    columns: [
                        { data: 'action', name: 'action', orderable: false, searchable: false },
                        { data: 'code', name: 'code' },
                        { data: 'name', name: 'name' },
                        { data: 'brand', name: 'brand' },
                        { data: 'manufacturer', name: 'manufacturer' },
                        { data: 'price', name: 'price' },
                        { data: 'type', name: 'type' }
                    ],
                    order: [[1, 'asc']]
                });
            }

            function initializeKfaSyncedDrugsTable() {
                $('#kfa-synced-drugs-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '/api/v1/kfa/drugs-with-kfa',
                    columns: [
                        { data: 'action', name: 'action', orderable: false, searchable: false },
                        { data: 'drug_code', name: 'drug_code' },
                        { data: 'drug_name', name: 'drug_name' },
                        { data: 'kfa_code', name: 'kfa_code' },
                        { data: 'price', name: 'price' },
                        { data: 'synced_at', name: 'synced_at' }
                    ],
                    order: [[5, 'desc']]
                });
            }

            function loadDrugsForSelect() {
                $.ajax({
                    url: '/api/v1/drugs/select-options',
                    method: 'GET',
                    success: function(response) {
                        const select = $('#drugSelect');
                        select.empty();
                        select.append('<option value="">Pilih obat...</option>');
                        
                        if (response.data) {
                            response.data.forEach(function(drug) {
                                select.append(`<option value="${drug.id}">${drug.name}</option>`);
                            });
                        }
                    },
                    error: function() {
                        console.error('Failed to load drugs for select');
                    }
                });
            }

            function openSyncModal(kfaCode, identifier) {
                $('#kfaCode').val(kfaCode);
                $('#kfaIdentifier').val(identifier);
                new bootstrap.Modal(document.getElementById('syncModal')).show();
            }

            async function syncDrugWithKfa() {
                const drugId = $('#drugSelect').val();
                const kfaCode = $('#kfaCode').val();
                const identifier = $('#kfaIdentifier').val();

                if (!drugId) {
                    alert('Pilih obat terlebih dahulu');
                    return;
                }

                try {
                    const response = await fetch('/api/v1/kfa/sync-drug', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            drug_id: drugId,
                            kfa_code: kfaCode,
                            identifier: identifier
                        })
                    });

                    const data = await response.json();

                    if (response.ok) {
                        alert('Obat berhasil disinkronisasi dengan KFA');
                        bootstrap.Modal.getInstance(document.getElementById('syncModal')).hide();
                        
                        // Reload both DataTables
                        $('#kfa-products-table').DataTable().ajax.reload();
                        $('#kfa-synced-drugs-table').DataTable().ajax.reload();
                    } else {
                        alert('Gagal menyinkronisasi: ' + data.message);
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Gagal menyinkronisasi obat');
                }
            }

            function viewKfaDetail(kfaCode) {
                // Redirect to detail page or open modal with details
                window.open(`/api/v1/kfa/product-detail?identifier=kfa&code=${kfaCode}`, '_blank');
            }
        </script>
    @endpush

    @section('styles')
        <style>
            .dataTables_filter {
                display: none;
            }
        </style>
    @endsection
</x-base-layout>
