<x-base-layout>
    <!--begin::Card-->
    <div class="card card-xxl-stretch mb-5 mb-xl-8">
        <!--begin::Card body-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                Import Drugs from Excel
            </h3>

            <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title=""
                data-bs-original-title="Click to cancel">
                <a href="{{ route('drugs.index') }}" class="btn btn-sm btn-light-primary">
                    <!--begin::Svg Icon | path: assets/media/icons/duotune/arrows/arr079.svg-->
                    <span class="svg-icon svg-icon-muted svg-icon-2hx">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none">
                            <path opacity="0.5"
                                d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                                fill="currentColor" />
                            <path
                                d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                                fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    Cancel
                </a>
            </div>
        </div>
        <div class="card-body pt-6">
            <div class="row">
                <div class="col-md-8">
                    <form action="{{ route('drugs.process-import') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-10">
                            <label for="file" class="form-label required">Select Excel File</label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror"
                                id="file" name="file" accept=".xlsx,.xls,.csv" required>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Supported formats: .xlsx, .xls, .csv (Max: 2MB)</div>
                        </div>

                        <div class="mb-10">
                            <div class="alert alert-info">
                                <h5 class="alert-heading">Format File Excel:</h5>
                                <p class="mb-2">File Excel harus memiliki kolom dengan header berikut:</p>
                                <ul class="mb-2">
                                    <li><strong>ID</strong> - ID obat (opsional, untuk update)</li>
                                    <li><strong>Unit</strong> - Nama unit obat (<a href="{{ route('units.index') }}"
                                            class="text-primary">Lihat di Menu Unit</a>)</li>
                                    <li><strong>Name</strong> - Nama obat (wajib)</li>
                                    <li><strong>Price</strong> - Harga obat</li>
                                    <li><strong>Stock</strong> - Stok obat</li>
                                    <li><strong>Created At</strong> - Tanggal dibuat (diabaikan saat import)</li>
                                </ul>
                                <p class="mb-0">Anda dapat menggunakan file hasil export sebagai template.</p>
                            </div>
                        </div>

                        <div class="mb-10">
                            <div class="alert alert-warning">
                                <h6 class="alert-heading">Catatan Penting:</h6>
                                <ul class="mb-0">
                                    <li>Jika nama unit tidak ditemukan, obat akan disimpan tanpa unit</li>
                                    <li>Jika obat dengan nama yang sama sudah ada, data akan diperbarui</li>
                                    <li>Baris dengan nama obat kosong akan diabaikan</li>
                                </ul>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <span class="svg-icon svg-icon-muted svg-icon-2hx me-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3"
                                            d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22Z"
                                            fill="currentColor" />
                                        <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor" />
                                    </svg>
                                </span>
                                Import Data
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-4">
                    <div class="card bg-light-primary">
                        <div class="card-body">
                            <h5 class="card-title">Download Template</h5>
                            <p class="card-text">Download file template atau export data yang sudah ada untuk melihat
                                format yang benar.</p>
                            <a href="{{ route('drugs.export') }}" class="btn btn-primary btn-sm">
                                <span class="svg-icon svg-icon-muted svg-icon-2hx me-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3"
                                            d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22Z"
                                            fill="currentColor" />
                                        <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor" />
                                    </svg>
                                </span>
                                Download Template
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
</x-base-layout>
