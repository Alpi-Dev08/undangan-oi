<x-base-layout>
    <div class="card card-xxl-stretch mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <div class="d-flex align-items-center position-relative my-1">
                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor"></path>
                        </svg>
                    </span>
                    <form method="GET" action="{{ route('prescriptions.index') }}" class="d-flex gap-3">
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-solid border border-gray-300 w-250px ps-15" placeholder="Cari pasien/kode pemeriksaan">
                        <select name="status" class="form-select form-select-solid w-200px">
                            <option value="">Semua Status</option>
                            @foreach(["saved"=>"Tersimpan","printed"=>"Tercetak","dispensed"=>"Didispensasi","cancelled"=>"Dibatalkan"] as $key => $label)
                                <option value="{{ $key }}" @selected(request('status')===$key)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-primary" type="submit">Filter</button>
                    </form>
                </div>
            </h3>
        </div>

        <div class="card-body pt-6">
            <table class="table align-middle table-row-dashed fs-6 gy-5">
                <thead>
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Kode Pemeriksaan</th>
                        <th>Pasien</th>
                        <th>Dokter</th>
                        <th>Total Item</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold">
                    @forelse($prescriptions as $prescription)
                        <tr>
                            <td>{{ $prescription->id }}</td>
                            <td>{{ \Carbon\Carbon::parse($prescription->resep_date)->format('d/m/Y') }}</td>
                            <td>{{ $prescription->examination->examination_code ?? '-' }}</td>
                            <td>{{ $prescription->examination?->patient?->patient_code ?? '-' }}</td>
                            <td>{{ $prescription->doctor?->name ?? '-' }}</td>
                            <td>{{ $prescription->total_items }}</td>
                            <td>
                                <span class="badge {{ match($prescription->status){
                                    'saved' => 'badge-light-info',
                                    'printed' => 'badge-light-primary',
                                    'dispensed' => 'badge-light-success',
                                    'cancelled' => 'badge-light-danger',
                                    default => 'badge-light-secondary'
                                } }}">{{ ucfirst($prescription->status) }}</span>
                            </td>
                            <td class="d-flex gap-2">
                                <a href="{{ route('prescriptions.print', $prescription) }}" class="btn btn-sm btn-light-primary">Cetak</a>
                                <a href="{{ route('prescriptions.pdf', $prescription) }}" class="btn btn-sm btn-light-info" target="_blank" rel="noopener">Unduh PDF</a>
                                <button class="btn btn-sm btn-light-success" onclick="updatePrescriptionStatus({{ $prescription->id }}, 'dispensed')">Dispensasi</button>
                                <button class="btn btn-sm btn-light-danger" onclick="updatePrescriptionStatus({{ $prescription->id }}, 'cancelled')">Batalkan</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data resep.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $prescriptions->withQueryString()->links() }}
            </div>
        </div>
    </div>

    <script>
        /**
         * Mengubah status resep secara AJAX.
         * Log sukses/gagal di console.
         */
        function updatePrescriptionStatus(id, status){
            fetch(`{{ url('klinik/prescriptions') }}/${id}/status`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': `{{ csrf_token() }}`,
                },
                body: JSON.stringify({ status })
            }).then(async r => {
                const data = await r.json().catch(() => ({}));
                if(r.ok){
                    console.log('Status resep diperbarui:', data);
                    location.reload();
                }else{
                    console.error('Gagal update status resep:', data);
                    alert(data.message || 'Gagal update status');
                }
            }).catch(err => {
                console.error('Error jaringan update status resep:', err);
                alert('Error jaringan');
            });
        }
    </script>
</x-base-layout>