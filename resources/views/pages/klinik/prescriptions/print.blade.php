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

        /* Layout halaman cetak mengikuti surat sakit */
        @page {
            margin: 0.5cm 1.5cm;
        }

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 6.5cm;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
        }

        body {
            margin-top: 3cm;
            margin-bottom: 120px;
        }

        .item-row {
            border-bottom: 1px dashed #ddd;
            padding: 6px 0;
        }

        .small { font-size: 12px; color: #555; }
    </style>

    <title>Resep Obat #{{ $prescription->id }}</title>
</head>

<body style="font-family: 'Nunito Sans', sans-serif;">
    <!-- Header: sama seperti template surat sakit -->
    <header>
        <table style="width:100%;border-bottom-width:5px;border-bottom-style:double">
            <tr style="vertical-align:baseline">
                <td style="width: 50%;vertical-align:top">
                    <img src="{{ asset(theme()->getMediaUrlPath() . 'logos/logo-klinik.png') }}" style="height:50px;">
                </td>
                <td style="width: 50%; vertical-align:top">
                    <p style="margin:0px; margin-top:10px; font-size:12px;text-align: right;color:#000;">
                        {!! organizationInfo('full') !!}
                    </p>
                </td>
            </tr>
        </table>
    </header>

    <!-- Footer: sama seperti template surat sakit -->
    <footer>
        <table style="width:100%;border-top-width: 1px;border-top-style: solid">
            <tr>
                <td style="width:50%;text-align: left;vertical-align: top;height:100px">
                    <h2 style="margin:0px;text-transform: uppercase;font-size: 16px;font-weight: bold">WISHING YOU GOOD HEALTH AND HAPPINESS</h2>
                    <p style="margin:0px;text-transform: uppercase;font-size: 14px;">SEMOGA SEHAT DAN BAHAGIA SELALU</p>
                </td>
                <td style="width:50%;text-align: right;vertical-align: bottom;float: right;height:100px">
                    <img src="{{ asset(theme()->getMediaUrlPath() . 'logos/qr.jpeg') }}" style="height:85px;margin-right:5px;">
                    <img src="{{ asset(theme()->getMediaUrlPath() . 'logos/logo-yayasan.png') }}" style="height:75px;">
                </td>
            </tr>
        </table>
    </footer>

    <!-- Konten utama resep -->
    <main style="font-size:13px!important;">
        <p style="color:#000;margin:0px;font-size:16px;text-align:center;font-weight:bolder;text-transform:uppercase;font-family: 'Roboto Condensed', sans-serif;margin-top:20px;text-decoration:underline;">
            Resep Dokter</p>

        <table class="table" style="width:100%; margin-top:10px;">
            <tbody>
                <tr>
                    <td style="width:25%;">Tanggal</td>
                    <td style="width:75%;">: <b>{{ \Carbon\Carbon::parse($prescription->resep_date)->locale('id')->format('d F Y') }}</b></td>
                </tr>
                <tr>
                    <td style="width:25%;">Pemeriksaan</td>
                    <td style="width:75%;">: <b>{{ $prescription->examination->examination_code ?? '-' }}</b></td>
                </tr>
                <tr>
                    <td style="width:25%;">Pasien</td>
                    <td style="width:75%;">: <b>{{ $prescription->examination?->patient?->patient_code ?? '-' }}</b></td>
                </tr>
                <tr>
                    <td style="width:25%;">Dokter</td>
                    <td style="width:75%;">: <b>{{ $prescription->doctor?->name ?? '-' }}</b></td>
                </tr>
            </tbody>
        </table>

        <p style="color:#000;margin:10px 0 5px 0;font-weight:bold">Daftar Resep</p>
        <div>
            @forelse($prescription->items as $i)
                <div class="item-row">
                    <div style="font-weight:bold">{{ $i->drug_name ?? ($i->drug->name ?? '-') }} <span class="small">{{ $i->kfa_code }}</span></div>
                    <div>Kuantitas: {{ $i->qty }} {{ $i->unit }} | Dosis: {{ $i->dosis }}</div>
                    <div>Aturan Pakai: {{ $i->aturan_pakai }}</div>
                    @if($i->keterangan)
                        <div class="small">Keterangan: {{ $i->keterangan }}</div>
                    @endif
                    @if($i->perintah_perawat)
                        <div class="small">Perintah Perawat: {{ $i->perintah_perawat }}</div>
                    @endif
                </div>
            @empty
                <div class="text-muted">Tidak ada item resep.</div>
            @endforelse
        </div>

        @if($prescription->catatan_umum)
            <p style="color:#000;margin:10px 0 5px 0;font-weight:bold">Catatan Umum</p>
            <div class="small">{{ $prescription->catatan_umum }}</div>
        @endif

        <div style="width:300px;float:right;text-align:center;margin-top:20px">
            <p style="margin:0px">Kab. Tangerang, {{ \Carbon\Carbon::parse($prescription->resep_date)->locale('id')->format('d F Y') }}</p>
            <br><br><br><br><br>
            <b>{{ $prescription->doctor?->name ?? '-' }}</b>
        </div>
    </main>

    <!-- Tidak memanggil window.print agar konsisten dengan template surat sakit -->
</body>

</html>
