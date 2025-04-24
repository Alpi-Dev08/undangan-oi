<div class="card">
    <div class="card-header">
        <h3 class="card-title">Pendaftaran Pasien</h3>
    </div>
    <div class="card-body">
        <form id="pendaftaranForm">
            <div class="mb-5">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}">
            </div>

            <div class="mb-5">
                <label class="form-label">Pendaftaran</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jenis_pendaftaran" id="baru" value="baru" checked>
                    <label class="form-check-label" for="baru">Baru</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jenis_pendaftaran" id="rujukan" value="rujukan">
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
                    <input type="text" class="form-control" id="nomorPencarian" name="nomorPencarian" placeholder="Masukkan nomor...">
                    <button type="button" class="btn btn-primary" id="cekPeserta">Cek Peserta</button>
                </div>
            </div>
            <div id="pesertaInfo" class="mt-5"></div>
        </form>
    </div>
</div>


@push('customscript')
    <script>
        document.getElementById('cekPeserta').addEventListener('click', function () {
            const jenisPencarian = document.getElementById('jenisPencarian').value;
            const nomorPencarian = document.getElementById('nomorPencarian').value;

            // Validate input is numeric only
            if (!/^\d+$/.test(nomorPencarian)) {
                pesertaInfo.innerHTML = `<p class="text-danger">Error: ${jenisPencarian === 'nik' ? 'NIK' : 'Nomor Peserta'} hanya boleh berisi angka.</p>`;
                return;
            }
            
            // Validate input based on search type
            if (jenisPencarian === 'nik') {
                if (nomorPencarian.length < 16) {
                    pesertaInfo.innerHTML = `<p class="text-danger">Error: NIK kurang dari 16 digit.</p>`;
                    return;
                }else if (nomorPencarian.length > 16) {
                    pesertaInfo.innerHTML = `<p class="text-danger">Error: NIK lebih dari 16 digit.</p>`;
                    return;
                }
            } else { // noPeserta
                if (nomorPencarian.length < 13) {
                    pesertaInfo.innerHTML = `<p class="text-danger">Error: Nomor Peserta kurang dari 13 digit.</p>`;
                    return;
                } else if(nomorPencarian.length > 13){
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
                        <h4 class="font-semibold text-lg mb-3">Informasi Peserta:</h4>
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
                        <input type="hidden" id="nama" name="nama" value="${peserta.nama}">
                        <input type="hidden" id="nik" name="nik" value="${peserta.noKTP}">
                        <input type="hidden" id="jenis_kelamin" name="jenis_kelamin" value="${peserta.sex}">
                        <input type="hidden" id="tanggal_lahir" name="tanggal_lahir" value="${peserta.tglLahir}">
                        <input type="hidden" id="status_peserta" name="status_peserta" value="${peserta.ketAktif}">
                        <input type="hidden" id="jenis_peserta" name="jenis_peserta" value="${peserta.jnsPeserta.nama}">
                    `;
                    } else {
                        pesertaInfo.innerHTML = `<p class="text-danger">Error: Pencarian ${jenisPencarian=='nik' ? 'NIK' : 'No Kartu'} Tidak Ditemukan</p>`;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengambil data peserta');
                });
        });

        document.getElementById('pendaftaranForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch('/pcare/pendaftaran', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Pendaftaran berhasil disimpan');
                        // Reset form atau redirect ke halaman lain jika diperlukan
                    } else {
                        alert('Gagal menyimpan pendaftaran: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menyimpan pendaftaran');
                });
        });
    </script>
@endpush
