<x-base-layout>
    <!--begin::Card-->
    <div class="card card-xxl-stretch mb-5 mb-xl-8">
        <!--begin::Card body-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                KFA (Katalog Farmasi dan Alat Kesehatan)
            </h3>

            <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title=""
                data-bs-original-title="Actions">
                <a href="{{ route('kfa.products') }}" class="btn btn-sm btn-light-success me-2">
                    <!--begin::Svg Icon | path: icons/duotune/files/fil003.svg-->
                    <span class="svg-icon svg-icon-muted svg-icon-2hx">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.3"
                                d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22Z"
                                fill="currentColor" />
                            <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    Export Excel
                </a>
            </div>
        </div>
        <div class="card-body pt-6">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="productType" class="form-label">Jenis Produk</label>
                    <select class="form-select form-select-solid" id="productType" data-control="select2"
                        data-hide-search="true">
                        <option value="farmasi">Farmasi</option>
                        <option value="alkes">Alat Kesehatan</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="keyword" class="form-label">Kata Kunci</label>
                    <input type="text" class="form-control form-control-solid" id="keyword"
                        placeholder="Masukkan nama produk atau kode KFA">
                </div>
                <div class="col-md-2">
                    <label>&nbsp;</label>
                    <button type="button" class="btn btn-primary w-100" id="searchBtn">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </div>

            @include('klinik::kfa._table')
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->

    <!-- Modal Detail Produk -->
    <div class="modal fade" id="kfaDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Produk KFA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="kfaDetailContent">
                        <!-- Content will be loaded here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    @push('customscript')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            "use strict";

            // Class definition
            var KFAProducts = function() {
                // Shared variables
                var table;
                var datatable;

                // Private functions
                var initDatatable = function() {
                    datatable = $('#kfa-products-table').DataTable({
                        processing: true,
                        serverSide: false,
                        searching: false,
                        ajax: {
                            url: "{{ route('kfa.products') }}",
                            type: 'GET',
                            data: function(d) {
                                d.product_type = $('#productType').val();
                                d.keyword = $('#keyword').val();
                            }
                        },
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'kfa_code',
                                name: 'kfa_code'
                            },
                            {
                                data: 'name',
                                name: 'name'
                            },
                            {
                                data: 'manufacturer',
                                name: 'manufacturer'
                            },
                            {
                                data: 'fix_price',
                                name: 'fix_price'
                            },
                            {
                                data: 'het_price',
                                name: 'het_price'
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            }
                        ],
                        responsive: true,
                        autoWidth: false,
                        language: {
                            paginate: {
                                first: '<i class="fas fa-angle-double-left"></i>',
                                previous: '<i class="fas fa-angle-left"></i>',
                                next: '<i class="fas fa-angle-right"></i>',
                                last: '<i class="fas fa-angle-double-right"></i>'
                            }
                        }
                    });

                    table = datatable;
                }

                var handleSearchDatatable = function() {
                    $('#searchBtn').on('click', function() {
                        console.log($('#productType').val());
                        var keyword = $('#keyword').val().trim();
                        if (keyword.length < 1) {
                            Swal.fire({
                                title: 'Peringatan',
                                text: 'Silakan masukkan kata kunci pencarian',
                                icon: 'warning',
                                confirmButtonText: 'OK'
                            });
                            return;
                        }

                        var btn = $(this);
                        btn.prop('disabled', true);
                        btn.html('<i class="fas fa-spinner fa-spin"></i> Mencari...');

                        datatable.ajax.reload(function() {
                            btn.prop('disabled', false);
                            btn.html('<i class="fas fa-search"></i> Cari');
                        });
                    });

                    $('#keyword').on('keypress', function(e) {
                        if (e.which == 13) {
                            var keyword = $(this).val().trim();
                            if (keyword.length < 1) {
                                Swal.fire({
                                    title: 'Peringatan',
                                    text: 'Silakan masukkan kata kunci pencarian',
                                    icon: 'warning',
                                    confirmButtonText: 'OK'
                                });
                                return;
                            }
                            datatable.ajax.reload();
                        }
                    });

                    $('#productType').on('change', function() {
                        datatable.ajax.reload();
                    });
                }

                var handleViewDetail = function() {
                    window.viewKfaDetail = function(kfaCode) {
                        if (!kfaCode) return;

                        $('#kfaDetailContent').html(
                            '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div> Memuat...</div>'
                        );
                        $('#kfaDetailModal').modal('show');

                        $.ajax({
                            url: "{{ route('kfa.product-detail') }}",
                            type: 'GET',
                            data: {
                                kfa_code: kfaCode
                            },
                            success: function(response) {
                                if (response.success && response.data) {
                                    let data = response.data;
                                    let dosageForm = data.dosage_form || '-';
                                    try {
                                        if (typeof data.dosage_form === 'string' && data.dosage_form
                                            .startsWith('{') || data.dosage_form.startsWith('[')) {
                                            dosageForm = JSON.parse(data.dosage_form);
                                            if (Array.isArray(dosageForm)) {
                                                dosageForm = dosageForm.join(', ');
                                            } else if (typeof dosageForm === 'object') {
                                                dosageForm = dosageForm.name || dosageForm.form || JSON
                                                    .stringify(dosageForm);
                                            }
                                        }
                                    } catch (e) {
                                        // Keep original dosageForm if parsing fails
                                    }

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
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <strong>Bentuk Sediaan:</strong><br>
                                            ${dosageForm}
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Kekuatan:</strong><br>
                                            ${data.strength || '-'} ${data.unit || ''}
                                        </div>
                                        <div class="col-md-4">
                                            <strong>No. Registrasi:</strong><br>
                                            ${data.registration_number || '-'}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Tanggal Registrasi:</strong><br>
                                            ${data.registration_date ? new Date(data.registration_date).toLocaleDateString('id-ID') : '-'}
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Tanggal Kadaluarsa:</strong><br>
                                            ${data.expiry_date ? new Date(data.expiry_date).toLocaleDateString('id-ID') : '-'}
                                        </div>
                                    </div>
                                    ${data.description ? `
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <strong>Deskripsi:</strong><br>
                                                                    <div class="border p-3 rounded bg-light">
                                                                        ${data.description}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            ` : ''}
                                `;
                                    $('#kfaDetailContent').html(html);
                                } else {
                                    $('#kfaDetailContent').html('<div class="alert alert-danger">' + (
                                            response.message || 'Gagal memuat detail produk.') +
                                        '</div>');
                                }
                            },
                            error: function() {
                                $('#kfaDetailContent').html(
                                    '<div class="alert alert-danger">Terjadi kesalahan saat memuat data.</div>'
                                );
                            }
                        });
                    }
                }

                // Public methods
                return {
                    init: function() {
                        initDatatable();
                        handleSearchDatatable();
                        handleViewDetail();
                    }
                }
            }();

            // On document ready
            KTUtil.onDOMContentLoaded(function() {
                KFAProducts.init();
            });
        </script>
    @endpush
</x-base-layout>
