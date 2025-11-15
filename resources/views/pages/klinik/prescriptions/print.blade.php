<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Resep #{{ $prescription->id }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.bundle.css') }}">
    <style>
        .print-container{max-width:800px;margin:0 auto;padding:24px;}
        .print-header,.print-footer{border-top:2px solid #ddd;border-bottom:2px solid #ddd;padding:12px 0;}
        .print-title{font-size:20px;font-weight:700;margin:12px 0;}
        .item-row{border-bottom:1px dashed #ddd;padding:8px 0;}
        .small{font-size:12px;color:#555;}
    </style>
</head>
<body>
    <div class="print-container">
        <div class="print-header d-flex justify-content-between align-items-center">
            <div>
                <div class="fw-bold">{{ organizationInfo('name') }}</div>
                <div class="small">{{ organizationInfo('address') }}</div>
            </div>
            <div class="text-end">
                <div class="fw-bold">Resep Obat</div>
                <div class="small">Tanggal: {{ \Carbon\Carbon::parse($prescription->resep_date)->format('d/m/Y') }}</div>
            </div>
        </div>

        <div class="mt-4">
            <div><strong>Pemeriksaan:</strong> {{ $prescription->examination->examination_code ?? '-' }}</div>
            <div><strong>Pasien:</strong> {{ $prescription->examination?->patient?->patient_code ?? '-' }}</div>
            <div><strong>Dokter:</strong> {{ $prescription->doctor?->name ?? '-' }}</div>
        </div>

        <div class="print-title">Daftar Resep</div>
        <div>
            @forelse($prescription->items as $i)
                <div class="item-row">
                    <div><strong>{{ $i->drug_name ?? ($i->drug->name ?? '-') }}</strong> <span class="small">{{ $i->kfa_code }}</span></div>
                    <div>Kuantitas: {{ $i->qty }} {{ $i->unit }} | Dosis: {{ $i->dosis }}</div>
                    <div>Aturan Pakai: {{ $i->aturan_pakai }}</div>
                    @if($i->keterangan)<div class="small">Keterangan: {{ $i->keterangan }}</div>@endif
                    @if($i->perintah_perawat)<div class="small">Perintah Perawat: {{ $i->perintah_perawat }}</div>@endif
                </div>
            @empty
                <div class="text-muted">Tidak ada item resep.</div>
            @endforelse
        </div>

        @if($prescription->catatan_umum)
            <div class="mt-4">
                <strong>Catatan Umum:</strong>
                <div class="small">{{ $prescription->catatan_umum }}</div>
            </div>
        @endif

        <div class="print-footer d-flex justify-content-between align-items-center mt-5">
            <div class="small">Dicetak: {{ now()->format('d/m/Y H:i') }}</div>
            <div class="text-end">
                <div>Dokter</div>
                <div class="mt-10 fw-bold">{{ $prescription->doctor?->name ?? '-' }}</div>
            </div>
        </div>
    </div>

    <script>
        // Otomatis panggil dialog print setelah halaman siap
        window.addEventListener('load', function(){
            try { window.print(); } catch(e) { console.error('Gagal memanggil print:', e); }
        });
    </script>
</body>
</html>