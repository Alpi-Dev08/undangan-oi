@extends('layouts.app')

@section('title', 'Integrasi KFA - SATUSEHAT')

@section('content')
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
                            <form id="kfaSearchForm">
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
                                        <input type="text" class="form-control" id="keyword" placeholder="Masukkan nama produk...">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">&nbsp;</label>
                                        <button type="submit" class="btn btn-primary d-block">Cari</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Results -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Hasil Pencarian</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="kfaResultsTable">
                                    <thead>
                                        <tr>
                                            <th>Kode</th>
                                            <th>Nama Produk</th>
                                            <th>Produsen</th>
                                            <th>Harga</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="kfaResultsBody">
                                        <tr>
                                            <td colspan="5" class="text-center">Silakan lakukan pencarian terlebih dahulu</td>
                                        </tr>
                                    </tbody>
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
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Load drugs for sync modal
        loadDrugsForSync();

        // Search form submission
        document.getElementById('kfaSearchForm').addEventListener('submit', function(e) {
            e.preventDefault();
            searchKfaProducts();
        });

        // Sync button click
        document.getElementById('syncButton').addEventListener('click', syncDrugWithKfa);
    });

    async function searchKfaProducts() {
        const productType = document.getElementById('productType').value;
        const keyword = document.getElementById('keyword').value;
        
        try {
            const response = await fetch(`/api/v1/kfa/products?product_type=${productType}&keyword=${keyword}`, {
                headers: {
                    'Authorization': 'Bearer ' + document.querySelector('meta[name="api-token"]').content,
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            displayKfaResults(data.items.data);
        } catch (error) {
            console.error('Error:', error);
            alert('Gagal mengambil data dari KFA');
        }
    }

    function displayKfaResults(products) {
        const tbody = document.getElementById('kfaResultsBody');
        tbody.innerHTML = '';

        if (products.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="text-center">Tidak ada data ditemukan</td></tr>';
            return;
        }

        products.forEach(product => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${product.product_code || '-'}</td>
                <td>${product.product_name || '-'}</td>
                <td>${product.manufacturer || '-'}</td>
                <td>${product.price ? 'Rp ' + product.price.toLocaleString('id-ID') : '-'}</td>
                <td>
                    <button class="btn btn-sm btn-primary" onclick="openSyncModal('${product.product_code}', 'kfa')">
                        Sinkronkan
                    </button>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    async function loadDrugsForSync() {
        try {
            const response = await fetch('/api/v1/kfa/drugs-with-kfa', {
                headers: {
                    'Authorization': 'Bearer ' + document.querySelector('meta[name="api-token"]').content,
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            const select = document.getElementById('drugSelect');
            
            data.data.data.forEach(drug => {
                const option = document.createElement('option');
                option.value = drug.id;
                option.textContent = drug.name;
                select.appendChild(option);
            });
        } catch (error) {
            console.error('Error loading drugs:', error);
        }
    }

    function openSyncModal(kfaCode, identifier) {
        document.getElementById('kfaCode').value = kfaCode;
        document.getElementById('kfaIdentifier').value = identifier;
        new bootstrap.Modal(document.getElementById('syncModal')).show();
    }

    async function syncDrugWithKfa() {
        const drugId = document.getElementById('drugSelect').value;
        const kfaCode = document.getElementById('kfaCode').value;
        const identifier = document.getElementById('kfaIdentifier').value;

        if (!drugId) {
            alert('Pilih obat terlebih dahulu');
            return;
        }

        try {
            const response = await fetch('/api/v1/kfa/sync-drug', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + document.querySelector('meta[name="api-token"]').content,
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
            } else {
                alert('Gagal menyinkronisasi: ' + data.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Gagal menyinkronisasi obat');
        }
    }
</script>
@endpush