<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        /* Fonts mengikuti template surat sakit */
        @font-face {
            font-family: 'Roboto Condensed';
            src: asset('assets/fonts/Roboto_Condensed/RobotoCondensed-Regular.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Roboto';
            src: asset('assets/fonts/Roboto/Roboto-Regular.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Nunito Sans';
            src: asset('assets/fonts/Nunito_Sans/NunitoSans-Regular.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        /* Layout halaman cetak kompak hemat kertas */
        @page { size: A4; margin: 1cm; }

        header { position: fixed; top: 0; left: 0; right: 0; height: 2.8cm; }
        footer { position: fixed; bottom: 0; left: 0; right: 0; height: 2.2cm; }
        body   { margin-top: 3.2cm; margin-bottom: 2.6cm; }

        .title { color:#000; margin:6px 0 10px 0; font-size:13px; text-align:center; font-weight:700; text-transform:uppercase; }
        .meta-table { width:100%; font-size:12px; }
        .compact-table { width:100%; border-collapse:collapse; font-size:11px; }
        .compact-table th, .compact-table td { border:1px solid #000; padding:4px; }
        .small { font-size: 11px; color: #555; }
    </style>

    <title>Resep Obat #{{ $prescription->id }}</title>
</head>

<body style="font-family: 'Nunito Sans', sans-serif;">
    <!-- Header: sama seperti template surat sakit -->
    <header>
        <table style="width:100%;border-bottom-width:2px;border-bottom-style:solid">
            <tr style="vertical-align:baseline">
                <td style="width: 50%;vertical-align:top">
                    <img src="{{ asset(theme()->getMediaUrlPath() . 'logos/logo-klinik.png') }}" style="height:34px;">
                </td>
                <td style="width: 50%; vertical-align:top">
                    <p style="margin:0; margin-top:4px; font-size:11px;text-align: right;color:#000;">
                        {!! organizationInfo('full') !!}
                    </p>
                </td>
            </tr>
        </table>
    </header>

    <!-- Footer: sama seperti template surat sakit -->
    <footer>
        <table style="width:100%;border-top-width:1px;border-top-style:solid">
            <tr>
                <td style="width:60%;text-align: left;vertical-align: middle;height:80px">
                    <h2 style="margin:0;text-transform: uppercase;font-size: 14px;font-weight: bold">WISHING YOU GOOD HEALTH AND HAPPINESS</h2>
                    <p style="margin:0;text-transform: uppercase;font-size: 12px;">SEMOGA SEHAT DAN BAHAGIA SELALU</p>
                </td>
                <td style="width:40%;text-align: right;vertical-align: middle;height:80px">
                    <img src="{{ asset(theme()->getMediaUrlPath() . 'logos/qr.jpeg') }}" style="height:65px;margin-right:4px;">
                    <img src="{{ asset(theme()->getMediaUrlPath() . 'logos/logo-yayasan.png') }}" style="height:60px;">
                </td>
            </tr>
        </table>
    </footer>

    <!-- Konten utama resep -->
    <main style="font-size:12px!important;">
        <p class="title">RESEP OBAT / PRESCRIPTION</p>

        <table class="meta-table" style="margin-top:6px;">
            <tbody>
                <tr>
                    <td style="width:25%;">Tanggal</td>
                    <td style="width:75%; text-align:right"><b>{{ \Carbon\Carbon::parse($prescription->resep_date)->locale('id')->format('d F Y') }}</b></td>
                </tr>
                <tr>
                    <td>Pemeriksaan</td>
                    <td style="text-align:right"><b>{{ $prescription->examination->examination_code ?? '-' }}</b></td>
                </tr>
                <tr>
                    <td>Pasien</td>
                    <td style="text-align:right"><b>{{ $prescription->examination?->patient?->patient_code ?? '-' }}</b></td>
                </tr>
                <tr>
                    <td>Dokter</td>
                    <td style="text-align:right"><b>{{ $prescription->doctor?->name ?? '-' }}</b></td>
                </tr>
            </tbody>
        </table>

        <p style="color:#000;margin:6px 0 4px 0;font-weight:bold">Daftar Resep</p>
        <table class="compact-table">
            <thead>
                <tr>
                    <th style="width:4%">No</th>
                    <th style="width:28%">Obat</th>
                    <th style="width:12%">KFA</th>
                    <th style="width:10%">Qty</th>
                    <th style="width:10%">Unit</th>
                    <th style="width:12%">Dosis</th>
                    <th style="width:12%">Aturan</th>
                    <th style="width:10%">Keterangan</th>
                    <th style="width:10%">Perintah</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prescription->items as $idx => $i)
                    <tr style="page-break-inside:avoid;">
                        <td style="text-align:center;">{{ $idx + 1 }}</td>
                        <td>{{ $i->drug_name ?? ($i->drug->name ?? '-') }}</td>
                        <td>{{ $i->kfa_code ?? '-' }}</td>
                        <td style="text-align:center;">{{ $i->qty }}</td>
                        <td>{{ $i->unit }}</td>
                        <td>{{ $i->dosis ?? '-' }}</td>
                        <td>{{ $i->aturan_pakai ?? '-' }}</td>
                        <td>{{ $i->keterangan ?? '-' }}</td>
                        <td>{{ $i->perintah_perawat ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-muted">Tidak ada item resep.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($prescription->catatan_umum)
            <p style="color:#000;margin:6px 0 4px 0;font-weight:bold">Catatan Umum</p>
            <div class="small">{{ $prescription->catatan_umum }}</div>
        @endif

        <div style="width:280px;float:right;text-align:center;margin-top:12px">
            <p style="margin:0">Kab. Tangerang, {{ \Carbon\Carbon::parse($prescription->resep_date)->locale('id')->format('d F Y') }}</p>
            <br><br><br><br>
            <b>{{ $prescription->doctor?->name ?? '-' }}</b>
</div>

<script>
    // Auto-print saat halaman cetak dibuka
    window.addEventListener('load', function() {
        try {
            console.log('Log: Halaman cetak resep dimuat, memanggil window.print()');
            setTimeout(function(){ window.print(); }, 300);
        } catch (e) {
            console.warn('Log: Gagal memanggil print otomatis:', e);
        }
    });
</script>
    </main>

    <!-- Tidak memanggil window.print agar konsisten dengan template surat sakit -->
</body>

</html>
