@if(isset($pemeriksaan_awal))
    @php
        $alertClass = 'alert-success';
        if ($pemeriksaan_awal->kriteria_satu == 'ya' && $pemeriksaan_awal->kriteria_dua == 'ya') {
            $alertClass = 'alert-danger';
        } elseif ($pemeriksaan_awal->kriteria_satu == 'ya' || $pemeriksaan_awal->kriteria_dua == 'ya') {
            $alertClass = 'alert-warning';
        }
    @endphp

    <div class="alert {{ $alertClass }} d-flex align-items-center p-5 mb-5">
        <div class="d-flex flex-column">
            <h4 class="mb-1 text-dark">{{ $pemeriksaan_awal->interpretasi }}</h4>
            <span>{{ ucwords($pemeriksaan_awal->tindakan) }}</span>
        </div>
    </div>
@endif
