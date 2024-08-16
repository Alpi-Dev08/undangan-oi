<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        @font-face {
            font-family: 'Roboto Condensed';
            src: public_path('assets/fonts/Roboto_Condensed/RobotoCondensed-Regular.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Roboto';
            src: public_path('assets/fonts/Roboto/Roboto-Regular.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Nunito Sans';
            src: public_path('assets/fonts/Nunito_Sans/NunitoSans-Regular.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        /**
                Set the margins of the page to 0, so the footer and the header
                can be of the full height and width !
             **/
        @page {
            margin: 0.5cm 1.5cm;
        }
        .page_break { page-break-before: always; }

        /** Define the header rules **/
        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 6.5cm;

        }

        /** Define the footer rules **/
        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
        }

        body{
            margin-top: 3cm;
            margin-bottom: 120px;
        }

    </style>

    <title>Surat Keterangan {{ $user->name }}</title>
</head>
<body  style="font-family: 'Nunito Sans', sans-serif;">
<!--begin::Text-->
<header>
    <table style="width:100%;border-bottom-width:5px;border-bottom-style:double">
        <tr style="vertical-align:baseline">
            <td style="width: 50%;vertical-align:top">

                <img src="{{ public_path(theme()->getMediaUrlPath() . 'logos/logo-klinik.png') }}"  style="height:50px;">
            </td>
            <td style="width: 50%; vertical-align:top">
                <p style="margin:0px; margin-top:10px; font-size:12px;text-align: right;color:#000;">
                    Ruko C17, Pasar Intermoda BSD<br>
                    Sampora, Cisauk, Kab. Tangerang, Banten - 15414<br>
                    +62 21 5020 8805 - klinik@dharma.or.id<br>
                    https://klinik.dharma.or.id
                </p>
            </td>
        </tr>
    </table>
</header>
<footer>
    <table style="width:100%;border-top-width: 1px;border-top-style: solid">
        <tr>
            <td style="width:50%;text-align: left;vertical-align: top;height:100px">
                <h2 style="margin:0px;text-transform: uppercase;font-size: 16px;font-weight: bold">WISHING YOU GOOD HEALTH AND HAPPINESS</h2>
                <p style="margin:0px;text-transform: uppercase;font-size: 14px;">SEMOGA SEHAT DAN BAHAGIA SELALU</p>
            </td>
            <td style="width:50%;text-align: right;vertical-align: bottom;float: right;height:100px">
                <img src="{{ public_path(theme()->getMediaUrlPath() . 'logos/qr.jpeg') }}"  style="height:85px;margin-right:5px;"><img src="{{ public_path(theme()->getMediaUrlPath() . 'logos/logo-yayasan.png') }}"  style="height:75px;">
            </td>
        </tr>
    </table>
</footer>
<main style="font-size:12px!important;">
    <p style="color:#000;margin:0px;font-size:22px;text-align:center;font-weight:bolder;text-transform:uppercase;font-family: 'Roboto Condensed', sans-serif;margin-bottom:50px;margin-top:20px;        text-decoration:underline;">Dokumen Persetujuan / Penolakan Tindakan Medis</p>
    <p>Saya yang bertandatangan di bawah ini:</p>
    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:20%;">Nama</td>
                <td style="width:80%;">: <b>{{ (!in_array($user->info->title_prefix,['','-']) ? $user->info->title_prefix.'. ' : '').$user->name.(!in_array($user->info->title_suffix,['','-']) ? ', '.$user->info->title_suffix : '') }}</b></td>
            </tr>
            <tr>
                <td style="width:20%;">Tempat, Tanggal Lahir</td>
                <td style="width:80%;">: <b>{{ $data->tempat_tgl }}</b></td>
            </tr>
            <tr>
                <td style="width:20%;">Jenis Kelamin</td>
                <td style="width:80%;">: <b>{{ $data->jenis_kel }}</b></td>
            </tr>
            <tr>
                <td style="width:20%;">Alamat</td>
                <td style="width:80%;">: <b>{{ $data->alamat_pas }}</b></td>
            </tr>
        </tbody>
    </table>

    <p>Dengan ini menyatakan dengan sesungguhnya telah memberikan pernyataan :</p>
    
    <p><strong>{{ $data->persetujuan }} dilakukan tindakan medis</strong></p>

    @if($data->persetujuan === 'Tidak Setuju')
        <p>Alasan: {{ $data->description }}</p>
    @endif

    <p>Untuk dilakukan tindakan medis yang ada hubungannya dengan penyakit yang diderita oleh <b>{{ $data->terhadap }}</b>, dengan :</p>

    <br>
    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:20%;">Nama</td>
                <td style="width:80%;">: <b>{{ $data->nama_pasien }}</b></td>
            </tr>
            <tr>
                <td style="width:20%;">Tempat, Tanggal Lahir</td>
                <td style="width:80%;">: <b>{{ $data->tempat_tanggal }}</b></td>
            </tr>
            <tr>
                <td style="width:20%;">Jenis Kelamin</td>
                <td style="width:80%;">: <b>{{ $data->jenis_kelamin }}</b></td>
            </tr>
            <tr>
                <td style="width:20%;">Alamat</td>
                <td style="width:80%;">: <b>{{ $data->alamat }}</b></td>
            </tr>
            <tr>
                <td style="width:20%;">Diagnosis (WD & DD)</td>
                <td style="width:80%;">: <b>{{ $data->diagnosis }}</b></td>
            </tr>
            <tr>
                <td style="width:20%;">Dasar Diagnosis</td>
                <td style="width:80%;">: <b>{{ $data->dasar_diagnosis }}</b></td>
            </tr>
            <tr>
                <td style="width:20%;">Tindakan Kedokteran</td>
                <td style="width:80%;">: <b>{{ $data->tindakan }}</b></td>
            </tr>
            <tr>
                <td style="width:20%;">Tata Cara</td>
                <td style="width:80%;">: <b>{{ $data->tatacara }}</b></td>
            </tr>
            <tr>
                <td style="width:20%;">Tujuan</td>
                <td style="width:80%;">: <b>{{ $data->tujuan }}</b></td>
            </tr>
            <tr>
                <td style="width:20%;">Alternatif dan Risiko</td>
                <td style="width:80%;">: <b>{{ $data->resiko }}</b></td>
            </tr>
            <tr>
                <td style="width:20%;">Resiko dan Komplikasi</td>
                <td style="width:80%;">: <b>{{ $data->komplikasi }}</b></td>
            </tr>
            <tr>
                <td style="width:20%;">Prognosis</td>
                <td style="width:80%;">: <b>{{ $data->prognosis }}</b></td>
            </tr>
        </tbody>
    </table>

    <p>
        Yang tujuan, sifat dan perlunya tindakan medis tersebut diatas, serta risiko yang dapat 
        ditimbulkannya telah cukup dijelaskan oleh dokter dan telah saya mengerti sepenuhnya.
    </p>
    <p>
        Demikian dokumen pernyataan ini saya buat dengan penuh kesadaran dan tanpa paksaan.
    </p>
    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td colspan="4" style="text-align: right;">
                    Kab. Tangerang, {{ \Carbon\Carbon::parse($examination->examination_date)->locale('id')->format('d F Y') }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pukul {{ date('H:i:s')  }}
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center">Dokter Pemeriksa</td>
                <td colspan="2" style="text-align: center">Yang Menyatakan</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center">
                    <br>
                    <b>{{ (!in_array($examination->health_profesional->user->info->title_prefix,['','-']) ? $examination->health_profesional->user->info->title_prefix.'. ' : '').$examination->health_profesional->user->name.(!in_array($examination->health_profesional->user->info->title_suffix,['','-']) ? ', '.$examination->health_profesional->user->info->title_suffix : '') }}</b><br>
                    <b>{{ $examination->health_profesional->sip_number ? 'SIP.'.$examination->health_profesional->sip_number : '' }}</b>
                </td>
                <td colspan="2" style="text-align: center">
                    @if(isset($signature) && !empty($signature))
                        <img src="{{ $signature }}" alt="Tanda Tangan" style="border:1px solid #000;"/>
                    @else
                        <p>No signature available</p>
                    @endif
                    <b>{{ (!in_array($user->info->title_prefix,['','-']) ? $user->info->title_prefix.'. ' : '').$user->name.(!in_array($user->info->title_suffix,['','-']) ? ', '.$user->info->title_suffix : '') }}</b><br>
                </td>
            </tr>
        </tbody>
    </table>
</main>

<!--end::Text-->
</body>
</html>

