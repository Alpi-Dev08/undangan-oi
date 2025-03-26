<x-base-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('PCare Integration') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-5">
                        <label for="noKartu" class="form-label">Nomor Kartu BPJS</label>
                        <input type="text" class="form-control" id="noKartu" name="noKartu">
                    </div>
                    <button type="button" class="btn btn-primary" id="cekPeserta">Cek Peserta</button>
                    <div id="pesertaInfo" class="mt-5"></div>

                    <hr class="my-5">

                    <button type="button" class="btn btn-secondary" id="getDokter">Daftar Dokter</button>
                    <div id="dokterInfo" class="mt-5"></div>
                </div>
            </div>
        </div>
    </div>

    @push('customscript')
    <script>
        document.getElementById('cekPeserta').addEventListener('click', function() {
            const noKartu = document.getElementById('noKartu').value;
            fetch(`/pcare/peserta/${noKartu}`)
                .then(response => response.json())
                .then(data => {
                    const pesertaInfo = document.getElementById('pesertaInfo');
                    pesertaInfo.innerHTML = `
                        <h4>Informasi Peserta:</h4>
                        <p>Nama: ${data.response.nama}</p>
                        <p>NIK: ${data.response.nik}</p>
                        <p>Jenis Kelamin: ${data.response.sex}</p>
                        <!-- Tambahkan informasi lain sesuai kebutuhan -->
                    `;
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengambil data peserta');
                });
        });

        document.getElementById('getDokter').addEventListener('click', function() {
            fetch('/pcare/dokter')
                .then(response => response.json())
                .then(data => {
                    const dokterInfo = document.getElementById('dokterInfo');
                    let dokterList = '<h4>Daftar Dokter:</h4><ul>';
                    data.response.list.forEach(dokter => {
                        dokterList += `<li>${dokter.nmDokter} (${dokter.kdDokter})</li>`;
                    });
                    dokterList += '</ul>';
                    dokterInfo.innerHTML = dokterList;
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengambil data dokter');
                });
        });
    </script>
    @endpush
</x-base-layout>
