<div class="tab-pane fade" id="suratsakit" role="tabpanel">
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-light-success">
            <h3 class="d-flex align-items-center">Informasi Surat Sakit</h3>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('suket.sakit', $examination->id) }}" method="POST" class="form">
                @csrf
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <label for="pekerjaan" class="form-label fw-bold mb-2">Pekerjaan</label>
                            <input type="text" class="form-control form-control-solid" placeholder="Pekerjaan"
                                name="pekerjaan" id="pekerjaan" value="{{ $info->job_title ?? '' }}" />
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <label for="perusahaan" class="form-label fw-bold mb-2">Perusahaan</label>
                            <input type="text" class="form-control form-control-solid" placeholder="Perusahaan"
                                name="perusahaan" id="perusahaan" value="{{ $info->company_name ?? '' }}" />
                        </div>
                    </div>
                </div>

                <div class="separator separator-dashed my-5"></div>

                <div class="mb-4">
                    <h4 class="fw-bold fs-6 mb-3">Keterangan Informasi</h4>

                    <div class="card card-bordered border-gray-300 mb-3">
                        <div class="card-body py-3">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" name="keterangan" value="1"
                                    id="keterangan1" />
                                <label class="form-check-label fw-semibold" for="keterangan1">
                                    Dapat Kembali Bekerja
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="card card-bordered border-gray-300 mb-3">
                        <div class="card-body py-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="keterangan" value="2"
                                    id="keterangan2" />
                                <label class="form-check-label fw-semibold" for="keterangan2">
                                    Disarankan untuk beristirahat selama
                                </label>
                            </div>
                            <div class="ms-4 mt-3">
                                <div class="row g-3 align-items-center">
                                    <div class="col-auto">
                                        <input name="hari" type="number"
                                            class="form-control form-control-solid w-70px" placeholder="0">
                                    </div>
                                    <div class="col-auto">
                                        <span class="fw-semibold">hari, dari tanggal:</span>
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control form-control-solid" name="start_date" type="date">
                                    </div>
                                    <div class="col-auto">
                                        <span class="fw-semibold">s.d</span>
                                    </div>
                                    <div class="col-md-3">
                                        <input name="end_date" class="form-control form-control-solid" type="date">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-bordered border-gray-300 mb-3">
                        <div class="card-body py-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="keterangan" value="3"
                                    id="keterangan3" />
                                <label class="form-check-label fw-semibold" for="keterangan3">
                                    Perlu datang kembali ke klinik pada
                                </label>
                            </div>
                            <div class="ms-4 mt-3">
                                <div class="row g-3 align-items-center">
                                    <div class="col-md-4">
                                        <input name="back_date" class="form-control form-control-solid" type="date">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-bordered border-gray-300 mb-3">
                        <div class="card-body py-3">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" name="keterangan" value="4"
                                    id="keterangan4" />
                                <label class="form-check-label fw-semibold" for="keterangan4">
                                    Perlu dirujuk ke Rumah Sakit untuk mendapatkan pemeriksaan lebih lanjut
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="separator separator-dashed my-5"></div>

                <div class="mb-5">
                    <label for="description" class="form-label fw-bold">Keterangan</label>
                    <textarea rows="3" class="form-control form-control-solid" placeholder="Keterangan" name="description"
                        id="description"></textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-6">
                        <i class="fas fa-file-pdf me-2"></i>Download PDF
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
