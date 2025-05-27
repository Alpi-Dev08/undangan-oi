<div class="card">
    <div class="card-header">
        <h3 class="card-title">Pendaftaran Pasien</h3>
    </div>
    <div class="card-body">
        <form id="pendaftaranForm">
            @csrf
            <div class="mb-5">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}">
            </div>

            <div class="mb-5">
                <label class="form-label">Pendaftaran</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jenis_pendaftaran" id="baru"
                           value="baru" checked>
                    <label class="form-check-label" for="baru">Baru</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jenis_pendaftaran" id="rujukan"
                           value="rujukan">
                    <label class="form-check-label" for="rujukan">Rujukan</label>
                </div>
            </div>

            <div class="mb-5">
                <label for="nomorPencarian" class="form-label">Pencarian Peserta</label>
                <div class="input-group">
                    <select class="form-select" id="jenisPencarian" name="jenis_pencarian" style="max-width: 150px;">
                        <option value="noPeserta" selected>No. Peserta</option>
                        <option value="nik">NIK</option>
                    </select>
                    <input type="text" class="form-control" id="nomorPencarian" name="nomorPencarian"
                           placeholder="Masukkan nomor...">
                    <button type="button" class="btn btn-primary" id="cekPeserta">Cek Peserta</button>
                </div>
            </div>

            <!-- PCare Registration Form Fields -->
            <div id="pendaftaranPcareFields" class="mt-8" style="display: none;">
                <h4 class="font-bold mb-4">Form Pendaftaran PCare</h4>

                <div class="row">
                    <div class="col-md-6">
                        <!-- Provider Peserta -->
                        <div class="mb-5">
                            <label for="kdProviderPeserta" class="form-label required">Provider Peserta</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="kdProviderPeserta" name="kdProviderPeserta" placeholder="Kode Provider" required>
                                <button type="button" class="btn btn-secondary" id="cariProvider">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Tanggal Daftar -->
                        <div class="mb-5">
                            <label for="tglDaftar" class="form-label required">Tanggal Daftar</label>
                            <input type="text" class="form-control" id="tglDaftar" name="tglDaftar" placeholder="DD-MM-YYYY" required>
                        </div>

                        <!-- No Kartu -->
                        <div class="mb-5">
                            <label for="noKartu" class="form-label required">No. Kartu BPJS</label>
                            <input type="text" class="form-control" id="noKartu" name="noKartu" readonly required>
                        </div>

                        <!-- Poli -->
                        <div class="mb-5">
                            <label for="kdPoli" class="form-label required">Poli</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="kdPoli" name="kdPoli" placeholder="Kode Poli" required>
                                <button type="button" class="btn btn-secondary" id="cariPoli">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Keluhan -->
                        <div class="mb-5">
                            <label for="keluhan" class="form-label">Keluhan</label>
                            <textarea class="form-control" id="keluhan" name="keluhan" rows="3" placeholder="Masukkan keluhan pasien"></textarea>
                        </div>

                        <!-- Kunjungan Sakit -->
                        <div class="mb-5">
                            <label class="form-label required">Jenis Kunjungan</label>
                            <div class="form-check form-check-custom form-check-solid mb-2">
                                <input class="form-check-input" type="radio" name="kunjSakit" id="kunjSakit1" value="1" checked>
                                <label class="form-check-label" for="kunjSakit1">
                                    Kunjungan Sakit
                                </label>
                            </div>
                            <div class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input" type="radio" name="kunjSakit" id="kunjSakit0" value="0">
                                <label class="form-check-label" for="kunjSakit0">
                                    Kunjungan Sehat
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Pemeriksaan Fisik -->
                        <h5 class="font-bold mb-4">Pemeriksaan Fisik</h5>

                        <div class="row">
                            <!-- Sistole -->
                            <div class="col-md-6 mb-5">
                                <label for="sistole" class="form-label">Sistole (mmHg)</label>
                                <input type="number" class="form-control" id="sistole" name="sistole" value="0">
                            </div>

                            <!-- Diastole -->
                            <div class="col-md-6 mb-5">
                                <label for="diastole" class="form-label">Diastole (mmHg)</label>
                                <input type="number" class="form-control" id="diastole" name="diastole" value="0">
                            </div>
                        </div>

                        <div class="row">
                            <!-- Berat Badan -->
                            <div class="col-md-6 mb-5">
                                <label for="beratBadan" class="form-label">Berat Badan (kg)</label>
                                <input type="number" step="0.01" class="form-control" id="beratBadan" name="beratBadan" value="0">
                            </div>

                            <!-- Tinggi Badan -->
                            <div class="col-md-6 mb-5">
                                <label for="tinggiBadan" class="form-label">Tinggi Badan (cm)</label>
                                <input type="number" step="0.01" class="form-control" id="tinggiBadan" name="tinggiBadan" value="0">
                            </div>
                        </div>

                        <div class="row">
                            <!-- Respiratory Rate -->
                            <div class="col-md-6 mb-5">
                                <label for="respRate" class="form-label">Respiratory Rate (/menit)</label>
                                <input type="number" class="form-control" id="respRate" name="respRate" value="0">
                            </div>

                            <!-- Heart Rate -->
                            <div class="col-md-6 mb-5">
                                <label for="heartRate" class="form-label">Heart Rate (/menit)</label>
                                <input type="number" class="form-control" id="heartRate" name="heartRate" value="0">
                            </div>
                        </div>

                        <div class="row">
                            <!-- Lingkar Perut -->
                            <div class="col-md-6 mb-5">
                                <label for="lingkarPerut" class="form-label">Lingkar Perut (cm)</label>
                                <input type="number" step="0.01" class="form-control" id="lingkarPerut" name="lingkarPerut" value="0">
                            </div>

                            <!-- Rujuk Balik -->
                            <div class="col-md-6 mb-5">
                                <label for="rujukBalik" class="form-label">Rujuk Balik</label>
                                <input type="number" class="form-control" id="rujukBalik" name="rujukBalik" value="0">
                            </div>
                        </div>

                        <!-- TKP (Tipe Kunjungan) -->
                        <div class="mb-5">
                            <label for="kdTkp" class="form-label required">Tipe Kunjungan</label>
                            <select class="form-select" id="kdTkp" name="kdTkp" required>
                                <option value="">Pilih Tipe Kunjungan</option>
                                <option value="10">Rawat Jalan</option>
                                <option value="20">Rawat Inap</option>
                                <option value="30">Promotif Preventif</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-5">
                    <button type="button" class="btn btn-light me-3" id="resetForm">Reset</button>
                    <button type="submit" class="btn btn-primary" id="submitPendaftaran">
                        <span class="indicator-label">Simpan Pendaftaran</span>
                        <span class="indicator-progress">Mohon tunggu...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>


@push('customscript')
    <script>
        document.getElementById('cekPeserta').addEventListener('click', function () {
            const jenisPencarian = document.getElementById('jenisPencarian').value;
            const nomorPencarian = document.getElementById('nomorPencarian').value;
            const pesertaInfo = document.getElementById('pesertaInfo');

            // Validate input is numeric only
            if (!/^\d+$/.test(nomorPencarian)) {
                pesertaInfo.innerHTML =
                    `<p class="text-danger">Error: ${jenisPencarian === 'nik' ? 'NIK' : 'Nomor Peserta'} hanya boleh berisi angka.</p>`;
                return;
            }

            // Validate input based on search type
            if (jenisPencarian === 'nik') {
                if (nomorPencarian.length < 16) {
                    pesertaInfo.innerHTML = `<p class="text-danger">Error: NIK kurang dari 16 digit.</p>`;
                    return;
                } else if (nomorPencarian.length > 16) {
                    pesertaInfo.innerHTML = `<p class="text-danger">Error: NIK lebih dari 16 digit.</p>`;
                    return;
                }
            } else { // noPeserta
                if (nomorPencarian.length < 13) {
                    pesertaInfo.innerHTML = `<p class="text-danger">Error: Nomor Peserta kurang dari 13 digit.</p>`;
                    return;
                } else if (nomorPencarian.length > 13) {
                    pesertaInfo.innerHTML = `<p class="text-danger">Error: Nomor Peserta lebih dari 13 digit.</p>`;
                    return;
                }
            }

            let url = `/pcare/peserta/${nomorPencarian}`;

            if (jenisPencarian === 'nik') {
                url += '?jenisId=nik';
            }

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const pesertaInfo = document.getElementById('pesertaInfo');
                    if (data.metaData.code === 200) {
                        const peserta = data.response;
                        pesertaInfo.innerHTML = `
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr><td class="font-semibold">No. Kartu</td><td>${peserta.noKartu}</td></tr>
                                    <tr><td class="font-semibold">Nama</td><td>${peserta.nama}</td></tr>
                                    <tr><td class="font-semibold">Hubungan Keluarga</td><td>${peserta.hubunganKeluarga}</td></tr>
                                    <tr><td class="font-semibold">Jenis Kelamin</td><td>${peserta.sex}</td></tr>
                                    <tr><td class="font-semibold">Tanggal Lahir</td><td>${peserta.tglLahir}</td></tr>
                                    <tr><td class="font-semibold">Tanggal Mulai Aktif</td><td>${peserta.tglMulaiAktif}</td></tr>
                                    <tr><td class="font-semibold">Tanggal Akhir Berlaku</td><td>${peserta.tglAkhirBerlaku}</td></tr>
                                    <tr><td class="font-semibold">Provider PST</td><td>${peserta.kdProviderPst.kdProvider} - ${peserta.kdProviderPst.nmProvider}</td></tr>
                                    <tr><td class="font-semibold">Provider Gigi</td><td>${peserta.kdProviderGigi.kdProvider ? peserta.kdProviderGigi.kdProvider + ' - ' + peserta.kdProviderGigi.nmProvider : 'Tidak ada'}</td></tr>
                                    <tr><td class="font-semibold">Jenis Kelas</td><td>${peserta.jnsKelas.nama} (${peserta.jnsKelas.kode})</td></tr>
                                    <tr><td class="font-semibold">Jenis Peserta</td><td>${peserta.jnsPeserta.nama} (${peserta.jnsPeserta.kode})</td></tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr><td class="font-semibold">Golongan Darah</td><td>${peserta.golDarah}</td></tr>
                                    <tr><td class="font-semibold">No. HP</td><td>${peserta.noHP || 'Tidak ada'}</td></tr>
                                    <tr><td class="font-semibold">No. KTP</td><td>${peserta.noKTP}</td></tr>
                                    <tr><td class="font-semibold">PST PROL</td><td>${peserta.pstProl || 'Tidak ada'}</td></tr>
                                    <tr><td class="font-semibold">PST PRB</td><td>${peserta.pstPrb || 'Tidak ada'}</td></tr>
                                    <tr><td class="font-semibold">Status</td><td>${peserta.aktif ? 'Aktif' : 'Tidak Aktif'}</td></tr>
                                    <tr><td class="font-semibold">Keterangan Aktif</td><td>${peserta.ketAktif}</td></tr>
                                    <tr><td class="font-semibold">Asuransi</td><td>${peserta.asuransi.nmAsuransi ? peserta.asuransi.nmAsuransi + ' (' + peserta.asuransi.noAsuransi + ')' : 'Tidak ada'}</td></tr>
                                    <tr><td class="font-semibold">COB</td><td>${peserta.asuransi.cob ? 'Ya' : 'Tidak'}</td></tr>
                                    <tr><td class="font-semibold">Tunggakan</td><td>${peserta.tunggakan}</td></tr>
                                </table>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            <button type="button" class="btn btn-primary" id="lanjutPendaftaran">
                                <i class="fas fa-arrow-right me-2"></i>Lanjut ke Pendaftaran PCare
                            </button>
                        </div>
                        <input type="hidden" id="nama" name="nama" value="${peserta.nama}">
                        <input type="hidden" id="nik" name="nik" value="${peserta.noKTP}">
                        <input type="hidden" id="jenis_kelamin" name="jenis_kelamin" value="${peserta.sex}">
                        <input type="hidden" id="tanggal_lahir" name="tanggal_lahir" value="${peserta.tglLahir}">
                        <input type="hidden" id="status_peserta" name="status_peserta" value="${peserta.ketAktif}">
                        <input type="hidden" id="jenis_peserta" name="jenis_peserta" value="${peserta.jnsPeserta.nama}">
                        <input type="hidden" id="noKartuHidden" name="noKartuHidden" value="${peserta.noKartu}">
                        <input type="hidden" id="kdProviderPstHidden" name="kdProviderPstHidden" value="${peserta.kdProviderPst.kdProvider}">
                    `;

                        // Add event listener for the "Lanjut ke Pendaftaran PCare" button
                        document.getElementById('lanjutPendaftaran').addEventListener('click', function () {
                            // Show the PCare registration form
                            document.getElementById('pendaftaranPcareFields').style.display = 'block';

                            // Scroll to the form
                            document.getElementById('pendaftaranPcareFields').scrollIntoView({
                                behavior: 'smooth'
                            });

                            // Pre-fill form fields with data from the peserta
                            document.getElementById('noKartu').value = peserta.noKartu;
                            document.getElementById('kdProviderPeserta').value = peserta.kdProviderPst.kdProvider;

                            // Format current date as DD-MM-YYYY for tglDaftar
                            const today = new Date();
                            const day = String(today.getDate()).padStart(2, '0');
                            const month = String(today.getMonth() + 1).padStart(2, '0');
                            const year = today.getFullYear();
                            document.getElementById('tglDaftar').value = `${day}-${month}-${year}`;
                        });
                    } else {
                        pesertaInfo.innerHTML =
                            `<p class="text-danger">Error: Pencarian ${jenisPencarian == 'nik' ? 'NIK' : 'No Kartu'} Tidak Ditemukan</p>`;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengambil data peserta');
                });
        });

        // Initialize date picker for tglDaftar
        $(document).ready(function () {
            // Initialize date picker for tglDaftar with format DD-MM-YYYY
            $("#tglDaftar").daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                locale: {
                    format: 'DD-MM-YYYY'
                }
            });

            // Handle provider search button
            $('#cariProvider').on('click', function () {
                // Open provider search modal or page
                window.open('/pcare/provider', 'providerSearch', 'width=800,height=600');
            });

            // Handle poli search button
            $('#cariPoli').on('click', function () {
                // Open poli search modal or page
                window.open('/pcare/poli', 'poliSearch', 'width=800,height=600');
            });

            // Function to receive selected provider data from popup
            window.setSelectedProvider = function (kode, nama) {
                document.getElementById('kdProviderPeserta').value = kode;
            };

            // Function to receive selected poli data from popup
            window.setSelectedPoli = function (kode, nama) {
                document.getElementById('kdPoli').value = kode;
            };

            // Reset form button handler
            $('#resetForm').on('click', function () {
                if (confirm('Apakah Anda yakin ingin mengatur ulang formulir?')) {
                    // Reset only the PCare registration form fields, not the peserta search
                    document.getElementById('pendaftaranForm').reset();

                    // Keep the noKartu value if it exists
                    const noKartuHidden = document.getElementById('noKartuHidden');
                    if (noKartuHidden) {
                        document.getElementById('noKartu').value = noKartuHidden.value;
                    }

                    // Keep the provider value if it exists
                    const kdProviderPstHidden = document.getElementById('kdProviderPstHidden');
                    if (kdProviderPstHidden) {
                        document.getElementById('kdProviderPeserta').value = kdProviderPstHidden.value;
                    }

                    // Reset date to current date
                    const today = new Date();
                    const day = String(today.getDate()).padStart(2, '0');
                    const month = String(today.getMonth() + 1).padStart(2, '0');
                    const year = today.getFullYear();
                    document.getElementById('tglDaftar').value = `${day}-${month}-${year}`;
                }
            });

            // Form submission handler
            $('#pendaftaranForm').on('submit', function (e) {
                e.preventDefault();

                // Validate required fields
                const requiredFields = ['kdProviderPeserta', 'tglDaftar', 'noKartu', 'kdPoli', 'kdTkp'];
                let isValid = true;

                requiredFields.forEach(field => {
                    const input = document.getElementById(field);
                    if (!input.value.trim()) {
                        isValid = false;
                        input.classList.add('is-invalid');

                        // Add error message if it doesn't exist
                        let errorDiv = input.nextElementSibling;
                        if (!errorDiv || !errorDiv.classList.contains('invalid-feedback')) {
                            errorDiv = document.createElement('div');
                            errorDiv.classList.add('invalid-feedback');
                            errorDiv.textContent = 'Field ini wajib diisi';
                            input.parentNode.insertBefore(errorDiv, input.nextSibling);
                        }
                    } else {
                        input.classList.remove('is-invalid');

                        // Remove error message if it exists
                        const errorDiv = input.nextElementSibling;
                        if (errorDiv && errorDiv.classList.contains('invalid-feedback')) {
                            errorDiv.remove();
                        }
                    }
                });

                if (!isValid) {
                    toastr.error('Mohon lengkapi semua field yang wajib diisi');
                    return;
                }

                // Show loading indicator
                const submitButton = document.getElementById('submitPendaftaran');
                submitButton.setAttribute('data-kt-indicator', 'on');
                submitButton.disabled = true;

                // Prepare form data
                const formData = {
                    kdProviderPeserta: document.getElementById('kdProviderPeserta').value,
                    tglDaftar: document.getElementById('tglDaftar').value,
                    noKartu: document.getElementById('noKartu').value,
                    kdPoli: document.getElementById('kdPoli').value,
                    keluhan: document.getElementById('keluhan').value,
                    kunjSakit: document.querySelector('input[name="kunjSakit"]:checked').value,
                    sistole: document.getElementById('sistole').value,
                    diastole: document.getElementById('diastole').value,
                    beratBadan: document.getElementById('beratBadan').value,
                    tinggiBadan: document.getElementById('tinggiBadan').value,
                    respRate: document.getElementById('respRate').value,
                    heartRate: document.getElementById('heartRate').value,
                    lingkarPerut: document.getElementById('lingkarPerut').value,
                    rujukBalik: document.getElementById('rujukBalik').value,
                    kdTkp: document.getElementById('kdTkp').value,
                    _token: document.querySelector('input[name="_token"]').value
                };

                // Submit form data via AJAX
                fetch('/pcare/pendaftaran', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify(formData)
                })
                    .then(response => response.json())
                    .then(data => {
                        // Hide loading indicator
                        submitButton.removeAttribute('data-kt-indicator');
                        submitButton.disabled = false;

                        if (data.success) {
                            // Show success message
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Pendaftaran PCare berhasil disimpan',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                // Redirect to the detail page or refresh
                                if (data.redirectUrl) {
                                    window.location.href = data.redirectUrl;
                                } else {
                                    // Reset form and hide PCare registration fields
                                    document.getElementById('pendaftaranForm').reset();
                                    document.getElementById('pendaftaranPcareFields').style.display = 'none';
                                    document.getElementById('pesertaInfo').innerHTML = '';
                                    document.getElementById('nomorPencarian').value = '';
                                }
                            });
                        } else {
                            // Show error message
                            Swal.fire({
                                title: 'Gagal!',
                                text: data.message || 'Terjadi kesalahan saat menyimpan pendaftaran',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);

                        // Hide loading indicator
                        submitButton.removeAttribute('data-kt-indicator');
                        submitButton.disabled = false;

                        // Show error message
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat mengirim data pendaftaran',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    });
            });

            // Add input validation for numeric fields
            const numericFields = ['sistole', 'diastole', 'beratBadan', 'tinggiBadan', 'respRate', 'heartRate', 'lingkarPerut', 'rujukBalik'];

            numericFields.forEach(field => {
                const input = document.getElementById(field);

                input.addEventListener('input', function () {
                    // Remove non-numeric characters except decimal point
                    this.value = this.value.replace(/[^0-9.]/g, '');

                    // Ensure only one decimal point
                    const parts = this.value.split('.');
                    if (parts.length > 2) {
                        this.value = parts[0] + '.' + parts.slice(1).join('');
                    }
                });
            });

            // Add validation for noKartu field (numeric only)
            document.getElementById('nomorPencarian').addEventListener('input', function () {
                this.value = this.value.replace(/\D/g, '');
            });
        });
    </script>
@endpush
