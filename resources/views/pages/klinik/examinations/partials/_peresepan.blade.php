<div class="tab-pane" id="peresepan" role="tabpanel" aria-labelledby="peresepan-tab"
    data-kt-timeline-widget-4-blockui="true">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Form Peresepan</h3>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-primary" id="add-resep-item">
                    <i class="fas fa-plus"></i> Tambah Obat
                </button>
            </div>
        </div>
        <div class="card-body">
            <!-- Informasi Dokter -->
            <div class="row mb-6">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Dokter</label>
                    <input type="text" class="form-control form-control-solid" value="{{ auth()->user()->name }}"
                        readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Tanggal Resep</label>
                    <input type="date" name="resep_date" class="form-control form-control-solid"
                        value="{{ date('Y-m-d') }}">
                </div>
            </div>

            <!-- Form Peresepan -->
            <div id="resep-container">
                <div class="resep-item border rounded p-4 mb-4" data-resep-index="0">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label required">Nama Obat</label>
                            <select name="resep[obat][0]" class="form-select form-select-solid resep-obat"
                                data-placeholder="Pilih obat..." required>
                                <option value="">Pilih obat...</option>
                                @foreach ($drugs as $drug)
                                    <option value="{{ $drug->id }}" data-unit="{{ $drug->unit }}"
                                        data-dosage="{{ $drug->dosage }}" data-kfa="{{ $drug->kfa_code }}">
                                        {{ $drug->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">KFA Code</label>
                            <input type="text" name="resep[kfa_code][0]" class="form-control form-control-solid resep-kfa"
                                placeholder="Masukkan kode KFA...">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label required">Jumlah</label>
                            <div class="input-group input-group-solid">
                                <input type="number" name="resep[qty][0]" class="form-control resep-qty" min="1"
                                    value="1" required>
                                <span class="input-group-text resep-unit">unit</span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label required">Dosis</label>
                            <input type="text" name="resep[dosis][0]"
                                class="form-control form-control-solid resep-dosis" placeholder="Contoh: 3x1 tablet"
                                required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Aturan Pakai</label>
                            <select name="resep[aturan_pakai][0]" class="form-select form-select-solid">
                                <option value="">Pilih aturan pakai...</option>
                                <option value="sebelum_makan">Sebelum makan</option>
                                <option value="sesudah_makan">Sesudah makan</option>
                                <option value="saat_makan">Saat makan</option>
                                <option value="sebelum_tidur">Sebelum tidur</option>
                                <option value="setelah_tidur">Setelah bangun tidur</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label class="form-label">Keterangan</label>
                            <textarea name="resep[keterangan][0]" class="form-control form-control-solid" rows="2"
                                placeholder="Catatan tambahan..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Perintah Perawat</label>
                            <textarea name="resep[perintah_perawat][0]" class="form-control form-control-solid" rows="2"
                                placeholder="Instruksi untuk perawat..."></textarea>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 text-end">
                            <button type="button" class="btn btn-sm btn-danger remove-resep-item"
                                style="display: none;">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total dan Catatan -->
            <div class="row mt-6">
                <div class="col-md-8">
                    <label class="form-label">Catatan Umum</label>
                    <textarea name="resep[catatan_umum]" class="form-control form-control-solid" rows="3"
                        placeholder="Catatan untuk pasien atau apoteker..."></textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Total Item</label>
                    <div class="input-group input-group-solid">
                        <span class="input-group-text">
                            <i class="fas fa-pills"></i>
                        </span>
                        <input type="text" id="total-items" class="form-control" value="1" readonly>
                        <span class="input-group-text">item</span>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="row mt-6">
                <div class="col-md-12 text-end">
                    <button type="button" class="btn btn-secondary me-3" id="preview-resep">
                        <i class="fas fa-eye"></i> Preview Resep
                    </button>
                    <button type="button" class="btn btn-success" id="save-resep">
                        <i class="fas fa-save"></i> Simpan Resep
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Preview -->
    <div class="modal fade" id="previewResepModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Preview Resep</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="preview-content">
                        <!-- Content akan diisi oleh JavaScript -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="print-resep">
                        <i class="fas fa-print"></i> Cetak Resep
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('customscript')
    <script>
        $(document).ready(function() {
            let resepIndex = 1;

            // Inisialisasi Select2 untuk dropdown obat (dengan fallback jika Select2 tidak tersedia)
            function initResepObatSelect2(context) {
                const $scope = context ? $(context) : $(document);
                const $selects = $scope.find('.resep-obat');

                if (typeof $.fn.select2 !== 'function') {
                    console.warn('Log: Select2 tidak tersedia, dropdown obat tetap standar.');
                    return;
                }

                $selects.each(function() {
                    const $el = $(this);
                    if ($el.data('select2')) {
                        return; // Hindari init ulang
                    }
                    $el.select2({
                        placeholder: 'Pilih obat...',
                        width: '100%',
                        allowClear: true
                    });
                });
                console.log('Log: Inisialisasi Select2 pada', $selects.length, 'dropdown obat.');
            }

            // Panggil pada load awal
            initResepObatSelect2();

            // Fungsi untuk menambah item resep
            $('#add-resep-item').click(function() {
                const newItem = `
            <div class="resep-item border rounded p-4 mb-4" data-resep-index="${resepIndex}">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label required">Nama Obat</label>
                        <select name="resep[obat][${resepIndex}]" class="form-select form-select-solid resep-obat"
                                data-placeholder="Pilih obat..." required>
                            <option value="">Pilih obat...</option>
                            @foreach ($drugs as $drug)
                                <option value="{{ $drug->id }}"
                                        data-unit="{{ $drug->unit }}"
                                        data-dosage="{{ $drug->dosage }}"
                                        data-kfa="{{ $drug->kfa_code }}">
                                    {{ $drug->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">KFA Code</label>
                        <input type="text" name="resep[kfa_code][${resepIndex}]"
                               class="form-control form-control-solid resep-kfa" placeholder="Masukkan kode KFA...">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label required">Jumlah</label>
                        <div class="input-group input-group-solid">
                            <input type="number" name="resep[qty][${resepIndex}]"
                                   class="form-control resep-qty" min="1" value="1" required>
                            <span class="input-group-text resep-unit">unit</span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label required">Dosis</label>
                        <input type="text" name="resep[dosis][${resepIndex}]"
                               class="form-control form-control-solid resep-dosis"
                               placeholder="Contoh: 3x1 tablet" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Aturan Pakai</label>
                        <select name="resep[aturan_pakai][${resepIndex}]" class="form-select form-select-solid">
                            <option value="">Pilih aturan pakai...</option>
                            <option value="sebelum_makan">Sebelum makan</option>
                            <option value="sesudah_makan">Sesudah makan</option>
                            <option value="saat_makan">Saat makan</option>
                            <option value="sebelum_tidur">Sebelum tidur</option>
                            <option value="setelah_tidur">Setelah bangun tidur</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label class="form-label">Keterangan</label>
                        <textarea name="resep[keterangan][${resepIndex}]" class="form-control form-control-solid"
                                  rows="2" placeholder="Catatan tambahan..."></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Perintah Perawat</label>
                        <textarea name="resep[perintah_perawat][${resepIndex}]" class="form-control form-control-solid"
                                  rows="2" placeholder="Instruksi untuk perawat..."></textarea>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 text-end">
                        <button type="button" class="btn btn-sm btn-danger remove-resep-item">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </div>
                </div>
            </div>
        `;

                $('#resep-container').append(newItem);
                resepIndex++;
                updateTotalItems();

                // Tampilkan tombol hapus untuk semua item kecuali yang pertama
                $('.remove-resep-item').show();

                // Inisialisasi Select2 untuk item baru
                const lastItem = $('#resep-container .resep-item').last();
                initResepObatSelect2(lastItem);
            });

            // Fungsi untuk menghapus item resep
            $(document).on('click', '.remove-resep-item', function() {
                $(this).closest('.resep-item').remove();
                updateTotalItems();

                // Sembunyikan tombol hapus jika hanya satu item tersisa
                if ($('.resep-item').length === 1) {
                    $('.remove-resep-item').hide();
                }
            });

            // Update unit dan auto-isi KFA Code saat obat dipilih
            $(document).on('change', '.resep-obat', function() {
                const selectedOption = $(this).find('option:selected');
                const unit = selectedOption.data('unit') || 'unit';
                const dosage = selectedOption.data('dosage') || '';
                const kfa = selectedOption.data('kfa') || '';

                $(this).closest('.resep-item').find('.resep-unit').text(unit.name);

                // Isi dosis otomatis jika tersedia
                if (dosage && !$(this).closest('.resep-item').find('.resep-dosis').val()) {
                    $(this).closest('.resep-item').find('.resep-dosis').val(dosage);
                }

                // Isi KFA Code otomatis jika tersedia (tetap bisa diubah manual)
                const kfaInput = $(this).closest('.resep-item').find('.resep-kfa');
                if (kfa) {
                    kfaInput.val(kfa);
                }
                console.log('Log: Perubahan obat - unit:', unit, ', dosis:', dosage, ', kfa:', kfa || '(kosong)');
            });

            // Update total items
            function updateTotalItems() {
                const total = $('.resep-item').length;
                $('#total-items').val(total);
            }

            // Preview resep
            $('#preview-resep').click(function() {
                generatePreview();
                $('#previewResepModal').modal('show');
            });

            // Generate preview content
            function generatePreview() {
                let html = `
            <div class="resep-preview">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <strong>Dokter:</strong> {{ auth()->user()->name }}
                    </div>
                    <div class="col-md-6">
                        <strong>Tanggal:</strong> ${$('input[name="resep_date"]').val()}
                    </div>
                </div>
                <hr>
                <h6>Daftar Obat:</h6>
        `;

                $('.resep-item').each(function(index) {
                    const obat = $(this).find('.resep-obat option:selected').text();
                    const qty = $(this).find('.resep-qty').val();
                    const unit = $(this).find('.resep-unit').text();
                    const dosis = $(this).find('.resep-dosis').val();
                    const kfaCode = $(this).find('.resep-kfa').val();
                    const aturanPakai = $(this).find('select[name*="aturan_pakai"]').find('option:selected')
                        .text();
                    const keterangan = $(this).find('textarea[name*="keterangan"]').val();
                    const perintahPerawat = $(this).find('textarea[name*="perintah_perawat"]').val();

                    html += `
                <div class="mb-3">
                    <strong>${index + 1}. ${obat}</strong><br>
                    <small>KFA: ${kfaCode ? kfaCode : '-'}</small><br>
                    <small>Jumlah: ${qty} ${unit}</small><br>
                    <small>Dosis: ${dosis}</small><br>
                    ${aturanPakai ? `<small>Aturan pakai: ${aturanPakai}</small><br>` : ''}
                    ${keterangan ? `<small>Keterangan: ${keterangan}</small><br>` : ''}
                    ${perintahPerawat ? `<small>Perintah perawat: ${perintahPerawat}</small>` : ''}
                </div>
            `;
                });

                const catatanUmum = $('textarea[name="resep[catatan_umum]"]').val();
                if (catatanUmum) {
                    html += `
                <hr>
                <h6>Catatan Umum:</h6>
                <p>${catatanUmum}</p>
            `;
                }

                html += '</div>';
                $('#preview-content').html(html);
            }

            // Simpan resep
            $('#save-resep').click(function() {
                // Validasi form
                let isValid = true;
                $('.resep-item').each(function() {
                    const obat = $(this).find('.resep-obat').val();
                    const qty = $(this).find('.resep-qty').val();
                    const dosis = $(this).find('.resep-dosis').val();

                    if (!obat || !qty || !dosis) {
                        isValid = false;
                        return false;
                    }
                });

                if (!isValid) {
                    alert('Mohon lengkapi semua data obat yang wajib diisi!');
                    return;
                }

                // Bangun payload sesuai controller PrescriptionsController@store
                const items = [];
                $('.resep-item').each(function() {
                    const $item = $(this);
                    const selected = $item.find('.resep-obat option:selected');
                    items.push({
                        drug_id: $item.find('.resep-obat').val() || null,
                        drug_name: selected.text() || null,
                        kfa_code: $item.find('.resep-kfa').val() || null,
                        qty: parseInt($item.find('.resep-qty').val() || '0', 10),
                        unit: ($item.find('.resep-unit').text() || '').trim() || null,
                        dosis: $item.find('.resep-dosis').val() || null,
                        aturan_pakai: $item.find('select[name^="resep[aturan_pakai]"]').val() || null,
                        keterangan: $item.find('textarea[name^="resep[keterangan]"]').val() || null,
                        perintah_perawat: $item.find('textarea[name^="resep[perintah_perawat]"]').val() || null,
                    });
                });

                const payload = {
                    examination_id: {{ $examination->id }},
                    resep_date: $('input[name="resep_date"]').val() || null,
                    catatan_umum: $('textarea[name="resep[catatan_umum]"]').val() || null,
                    items: items
                };

                const csrf = $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}';
                console.log('Log: Mengirim payload resep', payload);

                // Simpan data via AJAX ke route prescriptions.store
                $.ajax({
                    url: '{{ route('prescriptions.store') }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    contentType: 'application/json',
                    data: JSON.stringify(payload),
                    success: function(response) {
                        console.log('Log: Respon simpan resep', response);
                        if (response.success) {
                            alert('Resep berhasil disimpan!');
                            // Refresh atau redirect sesuai kebutuhan
                        } else {
                            alert('Gagal menyimpan resep: ' + (response.message || 'Tidak diketahui'));
                        }
                    },
                    error: function(xhr) {
                        console.error('Log: Error simpan resep', xhr?.responseJSON || xhr);
                        const msg = xhr?.responseJSON?.message || 'Terjadi kesalahan saat menyimpan resep!';
                        alert(msg);
                    }
                });
            });

            // Cetak resep
            $('#print-resep').click(function() {
                const printWindow = window.open('', '_blank');
                generatePreview();

                const printContent = $('#preview-content').html();
                printWindow.document.write(`
            <html>
                <head>
                    <title>Resep - {{ $examination->examination_code }}</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
                    <style>
                        body { padding: 20px; }
                        @media print { .btn { display: none; } }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <h4 class="text-center mb-4">Resep Dokter</h4>
                        ${printContent}
                    </div>
                </body>
            </html>
        `);
                printWindow.document.close();
                printWindow.print();
            });
        });
    </script>
@endpush
