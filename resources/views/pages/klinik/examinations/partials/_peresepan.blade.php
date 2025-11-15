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

            /**
             * generatePrintHtml
             * Membangun HTML cetak resep dengan Header & Footer seperti surat sakit.
             * - Header: logo klinik + informasi organisasi
             * - Footer: slogan + QR + logo yayasan
             * - Konten: data dokter, tanggal, daftar obat, catatan umum
             * Log: Menampilkan proses pembuatan HTML cetak
             */
            function generatePrintHtml() {
                console.log('Log: Membuat HTML cetak resep (safe builder)');
                const tanggal = $('input[name="resep_date"]').val();
                const dokter = '{{ auth()->user()->name }}';
                const organisasiHtml = "{!! addslashes(organizationInfo('full')) !!}";
                const logoKlinik = '{{ asset(theme()->getMediaUrlPath() . 'logos/logo-klinik.png') }}';
                const logoYayasan = '{{ asset(theme()->getMediaUrlPath() . 'logos/logo-yayasan.png') }}';
                const logoQr = '{{ asset(theme()->getMediaUrlPath() . 'logos/qr.jpeg') }}';

                // Bangun daftar obat dari form
                let daftarObatHtml = '';
                $('.resep-item').each(function(index) {
                    const obat = $(this).find('.resep-obat option:selected').text();
                    const qty = $(this).find('.resep-qty').val();
                    const unit = $(this).find('.resep-unit').text();
                    const dosis = $(this).find('.resep-dosis').val();
                    const kfaCode = $(this).find('.resep-kfa').val();
                    const aturanPakaiText = $(this).find('select[name*="aturan_pakai"]').find('option:selected').text();
                    const keterangan = $(this).find('textarea[name*="keterangan"]').val();
                    const perintahPerawat = $(this).find('textarea[name*="perintah_perawat"]').val();

                    daftarObatHtml += '<div style="margin-bottom:12px;">'
                        + '<div style="font-weight:700;">' + (index + 1) + '. ' + obat + '</div>'
                        + '<div style="font-size:12px;">KFA: ' + (kfaCode ? kfaCode : '-') + '</div>'
                        + '<div style="font-size:12px;">Jumlah: ' + qty + ' ' + unit + '</div>'
                        + '<div style="font-size:12px;">Dosis: ' + dosis + '</div>'
                        + (aturanPakaiText ? '<div style="font-size:12px;">Aturan pakai: ' + aturanPakaiText + '</div>' : '')
                        + (keterangan ? '<div style="font-size:12px;">Keterangan: ' + keterangan + '</div>' : '')
                        + (perintahPerawat ? '<div style="font-size:12px;">Perintah perawat: ' + perintahPerawat + '</div>' : '')
                        + '</div>';
                });

                const catatanUmum = $('textarea[name="resep[catatan_umum]"]').val();

                // Bangun HTML menggunakan array-of-lines untuk menghindari konflik template literal
                const lines = [];
                lines.push('<!doctype html>');
                lines.push('<html lang="id">');
                lines.push('<head>');
                lines.push('    <meta charset="UTF-8">');
                lines.push('    <meta name="viewport" content="width=device-width, initial-scale=1.0">');
                lines.push('    <title>Cetak Resep</title>');
                lines.push('    <style>');
                lines.push('        @page { margin: 0.5cm 1.5cm; }');
                lines.push('        header { position: fixed; top: 0cm; left: 0cm; right: 0cm; height: 6.5cm; }');
                lines.push('        footer { position: fixed; bottom: 0cm; left: 0cm; right: 0cm; }');
                lines.push('        body { margin-top: 3cm; margin-bottom: 120px; font-family: Arial, Helvetica, sans-serif; color: #000; }');
                lines.push('        .title { color:#000; margin:0; font-size:16px; text-align:center; font-weight:800; text-transform:uppercase; text-decoration:underline; }');
                lines.push('        .section-title { font-weight:700; font-size:14px; margin: 12px 0 6px 0; }');
                lines.push('        .divider { border-top: 1px solid #000; margin: 10px 0; }');
                lines.push('        .info-row { display:flex; justify-content:space-between; font-size:13px; margin-bottom:8px; }');
                lines.push('    </style>');
                lines.push('</head>');
                lines.push('<body>');
                lines.push('    <header>');
                lines.push('        <table style="width:100%;border-bottom-width:5px;border-bottom-style:double">');
                lines.push('            <tr style="vertical-align:baseline">');
                lines.push('                <td style="width:50%;vertical-align:top">');
                lines.push('                    <img src="' + logoKlinik + '" style="height:50px;">');
                lines.push('                </td>');
                lines.push('                <td style="width:50%; vertical-align:top">');
                lines.push('                    <p style="margin:0px; margin-top:10px; font-size:12px; text-align:right; color:#000;">' + organisasiHtml + '</p>');
                lines.push('                </td>');
                lines.push('            </tr>');
                lines.push('        </table>');
                lines.push('    </header>');
                lines.push('    <footer>');
                lines.push('        <table style="width:100%;border-top-width: 1px;border-top-style: solid">');
                lines.push('            <tr>');
                lines.push('                <td style="width:50%;text-align: left;vertical-align: top;height:100px">');
                lines.push('                    <h2 style="margin:0px;text-transform: uppercase;font-size: 16px;font-weight: bold">WISHING YOU GOOD HEALTH AND HAPPINESS</h2>');
                lines.push('                    <p style="margin:0px;text-transform: uppercase;font-size: 14px;">SEMOGA SEHAT DAN BAHAGIA SELALU</p>');
                lines.push('                </td>');
                lines.push('                <td style="width:50%;text-align: right;vertical-align: bottom;float: right;height:100px">');
                lines.push('                    <img src="' + logoQr + '" style="height:85px;margin-right:5px;">');
                lines.push('                    <img src="' + logoYayasan + '" style="height:75px;">');
                lines.push('                </td>');
                lines.push('            </tr>');
                lines.push('        </table>');
                lines.push('    </footer>');
                lines.push('    <main style="font-size:13px!important;">');
                lines.push('        <p class="title" style="margin-top:20px;">Resep Obat</p>');
                lines.push('        <p class="title" style="margin-bottom:20px;">PRESCRIPTION</p>');
                lines.push('        <div class="info-row">');
                lines.push('            <div><strong>Dokter:</strong> ' + dokter + '</div>');
                lines.push('            <div><strong>Tanggal:</strong> ' + tanggal + '</div>');
                lines.push('        </div>');
                lines.push('        <div class="divider"></div>');
                lines.push('        <div class="section-title">Daftar Obat</div>');
                lines.push(daftarObatHtml);
                if (catatanUmum) {
                    lines.push('        <div class="divider"></div>');
                    lines.push('        <div class="section-title">Catatan Umum</div>');
                    lines.push('        <div style="font-size:12px;">' + catatanUmum + '</div>');
                }
                lines.push('    </main>');
                lines.push('</body>');
                lines.push('</html>');

                const html = lines.join('\n');
                console.log('Log: HTML cetak resep selesai dibuat (safe)');
                return html;
            }

            /**
             * printResep
             * Membuka jendela baru, menulis HTML resep, dan memanggil print.
             * Log: Menangani proses cetak, error ditangani dengan aman.
             */
            function printResep() {
                try {
                    const html = generatePrintHtml();
                    const printWindow = window.open('', '_blank');
                    if (!printWindow) {
                        alert('Gagal membuka jendela print. Mohon izinkan pop-up untuk situs ini.');
                        return;
                    }
                    const doc = printWindow.document;
                    doc.open('text/html', 'replace');
                    doc.write(html);
                    doc.close();
                    printWindow.onload = function() {
                        try {
                            printWindow.focus();
                            printWindow.print();
                            console.log('Log: Cetak resep dipanggil setelah onload.');
                        } catch (e) {
                            console.warn('Log: Gagal memanggil print pada jendela:', e);
                        }
                    };
                } catch (error) {
                    console.error('Log: Kesalahan saat mencetak resep:', error);
                    alert('Terjadi kesalahan saat mencoba mencetak resep.');
                }
            }

            // Tombol Cetak Resep
            $('#print-resep').on('click', function() {
                console.log('Log: Tombol cetak resep diklik');
                printResep();
            });

            // Simpan resep
            $('#save-resep').click(function() {
                const $btn = $(this);
                if ($btn.prop('disabled')) {
                    console.warn('Log: Klik simpan diabaikan karena sedang proses.');
                    return;
                }
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

                function doSave(confirmUpdate = false) {
                    const dataToSend = Object.assign({}, payload, { confirm_update: !!confirmUpdate });
                    $btn.prop('disabled', true).addClass('disabled');
                    $.ajax({
                        url: '{{ route('prescriptions.store') }}',
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': csrf },
                        contentType: 'application/json',
                        data: JSON.stringify(dataToSend),
                        success: function(response) {
                            console.log('Log: Respon simpan resep', response);
                            $btn.prop('disabled', false).removeClass('disabled');
                            if (response.success) {
                                if (typeof Swal !== 'undefined') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: response.action === 'updated' ? 'Resep diperbarui' : 'Resep disimpan',
                                        text: 'Data resep telah ' + (response.action || 'disimpan') + ' dengan sukses.',
                                    });
                                } else {
                                    alert((response.action === 'updated' ? 'Resep diperbarui' : 'Resep disimpan') + ' dengan sukses.');
                                }
                                // TODO: optional refresh UI
                            } else {
                                const msg = response.message || 'Gagal menyimpan resep';
                                if (typeof Swal !== 'undefined') {
                                    Swal.fire({ icon: 'error', title: 'Gagal', text: msg });
                                } else { alert(msg); }
                            }
                        },
                        error: function(xhr) {
                            $btn.prop('disabled', false).removeClass('disabled');
                            const res = xhr?.responseJSON || {};
                            console.error('Log: Error simpan resep', res);
                            // Tangani skenario perlu konfirmasi update
                            if (xhr.status === 409 && res?.requires_confirmation) {
                                const confirmText = res.message || 'Resep untuk tanggal ini sudah ada. Ingin memperbarui?';
                                if (typeof Swal !== 'undefined') {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Konfirmasi Pembaruan',
                                        text: confirmText,
                                        showCancelButton: true,
                                        confirmButtonText: 'Ya, perbarui',
                                        cancelButtonText: 'Batal'
                                    }).then(function(result) {
                                        if (result.isConfirmed) {
                                            doSave(true);
                                        }
                                    });
                                } else {
                                    if (confirm(confirmText)) { doSave(true); }
                                }
                                return;
                            }

                            const msg = res?.message || 'Terjadi kesalahan saat menyimpan resep!';
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({ icon: 'error', title: 'Gagal', text: msg });
                            } else { alert(msg); }
                        }
                    });
                }

                // Simpan data via AJAX ke route prescriptions.store (dengan konfirmasi update jika perlu)
                doSave(false);
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
