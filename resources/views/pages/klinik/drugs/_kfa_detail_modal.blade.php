<!--begin::Modal - KFA Detail-->
<div class="modal fade" id="kfaDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="kfaDetailModalTitle">Detail Produk KFA</h2>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            <div class="modal-body">
                <div id="kfaDetailContent">
                    <!-- Loading state -->
                    <div class="d-flex justify-content-center align-items-center" style="min-height: 200px;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    /**
     * Show KFA detail modal
     * @param {string} kfaCode - KFA product code
     */
    function showKfaDetail(kfaCode) {
        // Reset modal content
        document.getElementById('kfaDetailContent').innerHTML = `
        <div class="d-flex justify-content-center align-items-center" style="min-height: 200px;">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `;

        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('kfaDetailModal'));
        modal.show();

        // Fetch KFA detail
        fetch(`/klinik/kfa/product-detail?kfa_code=${encodeURIComponent(kfaCode)}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const product = data.data;
                    document.getElementById('kfaDetailContent').innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Kode KFA</label>
                            <div class="text-gray-800">${product.kfa_code || '-'}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Produk</label>
                            <div class="text-gray-800">${product.name || '-'}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Manufacturer</label>
                            <div class="text-gray-800">${product.manufacturer || '-'}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Negara Asal</label>
                            <div class="text-gray-800">${product.manufacturer_country || '-'}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nomor Registrasi</label>
                            <div class="text-gray-800">${product.registration_number || '-'}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Harga HET</label>
                            <div class="text-gray-800">Rp ${parseInt(product.het_price || 0).toLocaleString('id-ID')}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Harga Fix</label>
                            <div class="text-gray-800">Rp ${parseInt(product.fix_price || 0).toLocaleString('id-ID')}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Kemasan</label>
                            <div class="text-gray-800">
                                ${(() => {
                                    try {
                                        const packaging = product.packaging;
                                        if (typeof packaging === 'string' && packaging.trim().startsWith('{')) {
                                            const parsed = JSON.parse(packaging);
                                            return parsed.name || '-';
                                        }
                                        return packaging || '-';
                                    } catch (e) {
                                        return packaging || '-';
                                    }
                                })()}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Bentuk Sediaan</label>
                            <div class="text-gray-800">
                                ${(() => {
                                    try {
                                        const dosageForm = product.dosage_form;
                                        if (typeof dosageForm === 'string' && dosageForm.trim().startsWith('{')) {
                                            const parsed = JSON.parse(dosageForm);
                                            return parsed.name || '-';
                                        }
                                        return dosageForm || '-';
                                    } catch (e) {
                                        return dosageForm    || '-';
                                    }
                                })()}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Kekuatan</label>
                            <div class="text-gray-800">${product.strength || '-'}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Satuan</label>
                            <div class="text-gray-800">
                                ${(() => {
                                    try {
                                        const unit = product.unit;
                                        if (typeof unit === 'string' && unit.trim().startsWith('{')) {
                                            const parsed = JSON.parse(unit);
                                            return parsed.name || '-';
                                        }
                                        return unit || '-';
                                    } catch (e) {
                                        return unit || '-';
                                    }
                                })()}
                            </div>
                        </div>
                    </div>
                </div>
                ${product.description ? `
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi</label>
                            <div class="text-gray-800">${product.description}</div>
                        </div>
                    </div>
                </div>
                ` : ''}
            `;
                } else {
                    document.getElementById('kfaDetailContent').innerHTML = `
                <div class="text-center py-5">
                    <div class="text-gray-500">
                        <i class="ki-duotone ki-information-2 fs-3x mb-4"></i>
                        <div class="fw-bold">Data tidak ditemukan</div>
                        <div class="text-muted">Produk dengan kode ${kfaCode} tidak ditemukan di database KFA.</div>
                    </div>
                </div>
            `;
                }
            })
            .catch(error => {
                console.error('Error fetching KFA detail:', error);
                document.getElementById('kfaDetailContent').innerHTML = `
            <div class="text-center py-5">
                <div class="text-danger">
                    <i class="ki-duotone ki-information-2 fs-3x mb-4"></i>
                    <div class="fw-bold">Terjadi Kesalahan</div>
                    <div class="text-muted">Gagal memuat detail produk KFA. Silakan coba lagi.</div>
                </div>
            </div>
        `;
            });
    }
</script>
