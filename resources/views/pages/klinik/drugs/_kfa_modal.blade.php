<div class="modal fade" id="kfaModal" tabindex="-1" aria-labelledby="kfaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kfaModalLabel">Pilih Data KFA</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Obat:</label>
                    <input type="text" id="drugNameDisplay" class="form-control" readonly>
                    <input type="hidden" id="drugId" value="">
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Cari KFA:</label>
                    <div class="input-group">
                        <input type="text" id="kfaSearch" class="form-control" placeholder="Ketik nama obat...">
                        <button class="btn btn-primary" type="button" id="searchKfaBtn">
                            <i class="bi bi-search"></i> Cari
                        </button>
                    </div>
                </div>

                <div id="kfaResults" class="table-responsive">
                    <div class="text-center py-5" id="loadingSpinner" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Mencari data KFA...</p>
                    </div>
                    
                    <div id="noResults" class="text-center py-5" style="display: none;">
                        <i class="bi bi-search fs-1 text-muted"></i>
                        <p class="text-muted mt-2">Tidak ada data KFA yang cocok</p>
                    </div>

                    <table id="kfaTable" class="table table-striped" style="display: none;">
                        <thead>
                            <tr>
                                <th>Nama Obat</th>
                                <th>Produsen</th>
                                <th>KFA Code</th>
                                <th>Kesesuaian</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="kfaTableBody">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Define global variables at the top level
window.currentDrugId = null;
window.currentDrugName = null;

// Define global function at the top level
window.openKfaModal = function(drugId, drugName) {
    console.log('Opening KFA modal for:', drugName, 'ID:', drugId);
    window.currentDrugId = drugId;
    window.currentDrugName = drugName;
    
    document.getElementById('drugId').value = window.currentDrugId;
    document.getElementById('drugNameDisplay').value = window.currentDrugName;
    
    // Update modal title
    document.getElementById('kfaModalLabel').textContent = `Pilih KFA untuk: ${drugName}`;
    
    // Auto search saat modal dibuka
    document.getElementById('kfaSearch').value = window.currentDrugName;
    searchKfa(window.currentDrugName);
};

document.addEventListener('DOMContentLoaded', function() {

    // Event handler untuk tombol search
    document.getElementById('searchKfaBtn').addEventListener('click', function() {
        const searchTerm = document.getElementById('kfaSearch').value;
        if (searchTerm.trim()) {
            searchKfa(searchTerm);
        }
    });

    // Event handler untuk enter key di search input
    document.getElementById('kfaSearch').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            const searchTerm = this.value;
            if (searchTerm.trim()) {
                searchKfa(searchTerm);
            }
        }
    });

    function searchKfa(searchTerm) {
        console.log('Mencari KFA dengan term:', searchTerm);
        
        const loadingSpinner = document.getElementById('loadingSpinner');
        const noResults = document.getElementById('noResults');
        const kfaTable = document.getElementById('kfaTable');
        const kfaTableBody = document.getElementById('kfaTableBody');

        loadingSpinner.style.display = 'block';
        noResults.style.display = 'none';
        kfaTable.style.display = 'none';

        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
            console.error('CSRF token tidak ditemukan');
            alert('CSRF token tidak ditemukan. Silakan refresh halaman.');
            return;
        }

        fetch(`/klinik/drugs/kfa-search?drug_name=${encodeURIComponent(searchTerm)}`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken.content,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            loadingSpinner.style.display = 'none';
            kfaTableBody.innerHTML = '';

            if (data.success && data.data.length > 0) {
                kfaTable.style.display = 'table';
                
                data.data.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.name}</td>
                        <td>${item.manufacturer || '-'}</td>
                        <td>${item.kfa_code}</td>
                        <td>
                            <span class="badge ${item.similarity_score >= 80 ? 'badge-light-success' : item.similarity_score >= 60 ? 'badge-light-warning' : 'badge-light-danger'}">
                                ${item.similarity_score}%
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary select-kfa-btn" 
                                    data-kfa-code="${item.kfa_code}" 
                                    data-kfa-name="${item.name}">
                                <i class="bi bi-check"></i> Pilih
                            </button>
                        </td>
                    `;
                    kfaTableBody.appendChild(row);
                });

                // Event handler untuk tombol select
                document.querySelectorAll('.select-kfa-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const kfaCode = this.dataset.kfaCode;
                        const kfaName = this.dataset.kfaName;
                        
                        if (confirm(`Yakin ingin menghubungkan dengan ${kfaName}?`)) {
                              updateKfaCode(kfaCode, kfaName);
                          }
                    });
                });
            } else {
                noResults.style.display = 'block';
            }
        })
        .catch(error => {
            loadingSpinner.style.display = 'none';
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mencari data KFA: ' + error.message);
        });
    }

    function updateKfaCode(drugId, kfaCode, kfaName) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
            console.error('CSRF token tidak ditemukan');
            alert('CSRF token tidak ditemukan. Silakan refresh halaman.');
            return;
        }

        console.log('Mengupdate KFA code untuk drug:', drugId, 'dengan kfaCode:', kfaCode);
        
        fetch(`/klinik/drugs/${drugId}/update-kfa-code`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken.content,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                kfa_code: kfaCode,
                kfa_name: kfaName
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Data KFA berhasil diperbarui');
                
                // Tutup modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('kfaModal'));
                modal.hide();
                
                // Reload DataTable
                if (window.LaravelDataTables && window.LaravelDataTables['drugs-table']) {
                    window.LaravelDataTables['drugs-table'].ajax.reload();
                } else {
                    location.reload();
                }
            } else {
                alert(data.message || 'Gagal memperbarui data KFA');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memperbarui data KFA: ' + error.message);
        });
    }
});
</script>
@endpush