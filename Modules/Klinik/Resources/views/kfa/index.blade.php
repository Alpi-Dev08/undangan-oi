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
                                        <input type="text" class="form-control" id="keyword"
                                            placeholder="Masukkan nama produk...">
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
                                            <td colspan="5" class="text-center">Silakan lakukan pencarian terlebih
                                                dahulu
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        <!-- Pagination -->
                        <nav aria-label="Page navigation" id="paginationContainer" style="display: none;">
                            <ul class="pagination justify-content-center" id="pagination">
                            </ul>
                        </nav>

                        <!-- Synced Drugs Table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Nama Obat</th>
                                        <th>KFA Code</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="syncedDrugsBody">
                                    <tr>
                                        <td colspan="5" class="text-center">Memuat data...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Synced Drugs Pagination -->
                        <nav id="syncedDrugsPaginationContainer" style="display: none;">
                            <ul class="pagination justify-content-center" id="syncedDrugsPagination"></ul>
                        </nav>
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

    @push('customscript')
        <script>
            let currentPage = 1;
            let currentData = null;

            document.addEventListener('DOMContentLoaded', function() {
                // Load drugs for sync modal
                loadDrugsForSync(1);

                // Search form submission
                document.getElementById('kfaSearchForm').addEventListener('submit', function(e) {
                    e.preventDefault();
                    currentPage = 1;
                    searchKfaProducts();
                });

                // Sync button click
                document.getElementById('syncButton').addEventListener('click', syncDrugWithKfa);
            });

            async function searchKfaProducts(page = 1) {
                const productType = document.getElementById('productType').value;
                const keyword = document.getElementById('keyword').value;
                currentPage = page;

                try {
                    const response = await fetch(
                        `/api/v1/kfa/products?product_type=${productType}&keyword=${keyword}&page=${page}`, {
                            headers: {
                                'Accept': 'application/json'
                            }
                        });

                    const data = await response.json();
                    currentData = data;
                    displayKfaResults(data.items.data);
                    renderPagination(data.total, data.page, data.size);
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
                    document.getElementById('paginationContainer').style.display = 'none';
                    return;
                }

                products.forEach(product => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                <td>${product.kfa_code || '-'}</td>
                <td>${product.name || '-'}</td>
                <td>${product.manufacturer || '-'}</td>
                <td>
                    ${product.fix_price ? 'Rp ' + product.fix_price.toLocaleString('id-ID') : '-'}<br>
                    <small class="text-muted">${product.het_price ? 'HET: Rp ' + product.het_price.toLocaleString('id-ID') : ''}</small>
                </td>
                <td>
                    <button class="btn btn-sm btn-primary" onclick="openSyncModal('${product.product_code}', 'kfa')">
                        Sinkronkan
                    </button>
                </td>
            `;
                    tbody.appendChild(row);
                });
            }

            function renderPagination(total, currentPage, pageSize) {
                const paginationContainer = document.getElementById('paginationContainer');
                const pagination = document.getElementById('pagination');

                if (total <= pageSize) {
                    paginationContainer.style.display = 'none';
                    return;
                }

                paginationContainer.style.display = 'block';
                pagination.innerHTML = '';

                const totalPages = Math.ceil(total / pageSize);
                const maxVisiblePages = 5;

                // Previous button
                const prevLi = document.createElement('li');
                prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
                prevLi.innerHTML = `<a class="page-link" href="#" data-page="${currentPage - 1}">Sebelumnya</a>`;
                pagination.appendChild(prevLi);

                // Page numbers
                let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
                let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

                if (endPage - startPage + 1 < maxVisiblePages) {
                    startPage = Math.max(1, endPage - maxVisiblePages + 1);
                }

                for (let i = startPage; i <= endPage; i++) {
                    const li = document.createElement('li');
                    li.className = `page-item ${i === currentPage ? 'active' : ''}`;
                    li.innerHTML = `<a class="page-link" href="#" data-page="${i}">${i}</a>`;
                    pagination.appendChild(li);
                }

                // Next button
                const nextLi = document.createElement('li');
                nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
                nextLi.innerHTML = `<a class="page-link" href="#" data-page="${currentPage + 1}">Selanjutnya</a>`;
                pagination.appendChild(nextLi);

                // Add click handlers
                pagination.querySelectorAll('.page-link').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const page = parseInt(this.getAttribute('data-page'));
                        if (page >= 1 && page <= totalPages) {
                            searchKfaProducts(page);
                        }
                    });
                });
            }

            let currentSyncedPage = 1;

            async function loadDrugsForSync(page = 1) {
                currentSyncedPage = page;
                try {
                    const response = await fetch(`/api/v1/kfa/drugs-with-kfa?page=${page}&per_page=10`, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    });

                    const data = await response.json();
                    const tbody = document.getElementById('syncedDrugsBody');
                    
                    if (data.success && data.data.data.length > 0) {
                        tbody.innerHTML = '';
                        data.data.data.forEach(drug => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${drug.name}</td>
                                <td>${drug.kfa_code}</td>
                                <td>Rp ${parseInt(drug.price).toLocaleString('id-ID')}</td>
                                <td>${drug.stock}</td>
                                <td>
                                    <button class="btn btn-sm btn-info" onclick="viewKfaDetail('${drug.kfa_code}')">
                                        Lihat Detail
                                    </button>
                                </td>
                            `;
                            tbody.appendChild(row);
                        });
                        renderSyncedDrugsPagination(data.data.total, data.data.current_page, data.data.per_page, data.data.last_page);
                    } else {
                        tbody.innerHTML = '<tr><td colspan="5" class="text-center">Belum ada obat yang disinkronkan</td></tr>';
                        document.getElementById('syncedDrugsPaginationContainer').style.display = 'none';
                    }
                } catch (error) {
                    console.error('Error:', error);
                    document.getElementById('syncedDrugsBody').innerHTML = '<tr><td colspan="5" class="text-center">Gagal memuat data</td></tr>';
                    document.getElementById('syncedDrugsPaginationContainer').style.display = 'none';
                }
            }

            function renderSyncedDrugsPagination(total, currentPage, perPage, lastPage) {
                const paginationContainer = document.getElementById('syncedDrugsPaginationContainer');
                const pagination = document.getElementById('syncedDrugsPagination');
                
                if (total <= perPage || lastPage <= 1) {
                    paginationContainer.style.display = 'none';
                    return;
                }

                paginationContainer.style.display = 'block';
                pagination.innerHTML = '';

                const maxVisiblePages = 5;
                
                // Previous button
                const prevLi = document.createElement('li');
                prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
                prevLi.innerHTML = `<a class="page-link" href="#" data-page="${currentPage - 1}">Sebelumnya</a>`;
                pagination.appendChild(prevLi);

                // Page numbers
                let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
                let endPage = Math.min(lastPage, startPage + maxVisiblePages - 1);
                
                if (endPage - startPage + 1 < maxVisiblePages) {
                    startPage = Math.max(1, endPage - maxVisiblePages + 1);
                }

                for (let i = startPage; i <= endPage; i++) {
                    const li = document.createElement('li');
                    li.className = `page-item ${i === currentPage ? 'active' : ''}`;
                    li.innerHTML = `<a class="page-link" href="#" data-page="${i}">${i}</a>`;
                    pagination.appendChild(li);
                }

                // Next button
                const nextLi = document.createElement('li');
                nextLi.className = `page-item ${currentPage === lastPage ? 'disabled' : ''}`;
                nextLi.innerHTML = `<a class="page-link" href="#" data-page="${currentPage + 1}">Selanjutnya</a>`;
                pagination.appendChild(nextLi);

                // Add click handlers
                pagination.querySelectorAll('.page-link').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const page = parseInt(this.getAttribute('data-page'));
                        if (page >= 1 && page <= lastPage) {
                            loadDrugsForSync(page);
                        }
                    });
                });
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

</x-base-layout>
