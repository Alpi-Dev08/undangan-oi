<div class="tab-pane fade active show" id="suratsehat" role="tabpanel">
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-light-success">
            <h3 class="d-flex align-items-center">Informasi Kesehatan</h3>
        </div>
        <div class="card-body p-4">
            <form method="post" action="{{ route('suket.sehat', $examination->id) }}" class="form">
                @csrf
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <span class="fw-bold text-gray-700 min-w-150px">Tinggi Badan</span>
                                <span class="text-gray-800">: {{ $examination->vitality->height ?? '-' }} cm</span>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <span class="fw-bold text-gray-700 min-w-150px">Berat Badan</span>
                                <span class="text-gray-800">: {{ $examination->vitality->weight ?? '-' }} kg</span>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <span class="fw-bold text-gray-700 min-w-150px">Tekanan Darah</span>
                                <span class="text-gray-800">: {{ $examination->vitality->blood_pressure ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <span class="fw-bold text-gray-700 min-w-150px">Nadi</span>
                                <span class="text-gray-800">: {{ $examination->vitality->heart_rate ?? '-' }}</span>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <span class="fw-bold text-gray-700 min-w-150px">Suhu Tubuh</span>
                                <span class="text-gray-800">: {{ $examination->vitality->temperature ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="separator separator-dashed my-5"></div>

                <div class="row g-4">
                    <!-- Gigi -->
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <label for="gigi" class="form-label fw-bold mb-2">Gigi</label>
                            <div class="d-flex gap-3">
                                <select class="form-select form-select-solid" name="gigi" id="gigi">
                                    <option value="Normal">Normal</option>
                                    <option value="Tidak Normal">Tidak Normal</option>
                                </select>
                                <input type="text" name="keterangan_gigi" class="form-control form-control-solid"
                                    placeholder="Keterangan">
                            </div>
                        </div>
                    </div>

                    <!-- Keadaan Umum -->
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <label for="keadaan_umum" class="form-label fw-bold mb-2">Keadaan Umum</label>
                            <div class="d-flex gap-3">
                                <select class="form-select form-select-solid" name="keadaan_umum" id="keadaan_umum">
                                    <option value="Normal">Normal</option>
                                    <option value="Tidak Normal">Tidak Normal</option>
                                </select>
                                <input type="text" name="keterangan_keadaan_umum"
                                    class="form-control form-control-solid" placeholder="Keterangan">
                            </div>
                        </div>
                    </div>

                    <!-- Mata -->
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <label for="mata" class="form-label fw-bold mb-2">Mata</label>
                            <div class="d-flex gap-3">
                                <select class="form-select form-select-solid" name="mata" id="mata">
                                    <option value="Normal">Normal</option>
                                    <option value="Tidak Normal">Tidak Normal</option>
                                </select>
                                <input type="text" name="keterangan_mata" class="form-control form-control-solid"
                                    placeholder="Keterangan">
                            </div>
                        </div>
                    </div>

                    <!-- THT -->
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <label for="tht" class="form-label fw-bold mb-2">THT</label>
                            <div class="d-flex gap-3">
                                <select class="form-select form-select-solid" name="tht" id="tht">
                                    <option value="Normal">Normal</option>
                                    <option value="Tidak Normal">Tidak Normal</option>
                                </select>
                                <input type="text" name="keterangan_tht" class="form-control form-control-solid"
                                    placeholder="Keterangan">
                            </div>
                        </div>
                    </div>

                    <!-- Mulut -->
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <label for="mulut" class="form-label fw-bold mb-2">Mulut</label>
                            <div class="d-flex gap-3">
                                <select class="form-select form-select-solid" name="mulut" id="mulut">
                                    <option value="Normal">Normal</option>
                                    <option value="Tidak Normal">Tidak Normal</option>
                                </select>
                                <input type="text" name="keterangan_mulut" class="form-control form-control-solid"
                                    placeholder="Keterangan">
                            </div>
                        </div>
                    </div>

                    <!-- Dada -->
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <label for="dada" class="form-label fw-bold mb-2">Dada (Paru & Jantung)</label>
                            <div class="d-flex gap-3">
                                <select class="form-select form-select-solid" name="dada" id="dada">
                                    <option value="Normal">Normal</option>
                                    <option value="Tidak Normal">Tidak Normal</option>
                                </select>
                                <input type="text" name="keterangan_dada" class="form-control form-control-solid"
                                    placeholder="Keterangan">
                            </div>
                        </div>
                    </div>

                    <!-- Perut -->
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <label for="perut" class="form-label fw-bold mb-2">Perut</label>
                            <div class="d-flex gap-3">
                                <select class="form-select form-select-solid" name="perut" id="perut">
                                    <option value="Normal">Normal</option>
                                    <option value="Tidak Normal">Tidak Normal</option>
                                </select>
                                <input type="text" name="keterangan_perut" class="form-control form-control-solid"
                                    placeholder="Keterangan">
                            </div>
                        </div>
                    </div>

                    <!-- Extremitas -->
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <label for="extremitas" class="form-label fw-bold mb-2">Extremitas</label>
                            <div class="d-flex gap-3">
                                <select class="form-select form-select-solid" name="extremitas" id="extremitas">
                                    <option value="Normal">Normal</option>
                                    <option value="Tidak Normal">Tidak Normal</option>
                                </select>
                                <input type="text" name="keterangan_extremitas"
                                    class="form-control form-control-solid" placeholder="Keterangan">
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
