@php use Carbon\Carbon; @endphp
    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
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
            margin: 0.5cm 0.5cm;
        }

        /** Define the header rules **/
        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 5cm;
            padding-bottom: 20px;
        }

        /** Define the footer rules **/
        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
        }

        body {
            margin-top: 5.3cm;
            margin-bottom: 120px;
            margin-left: 0px;
            margin-right: 0px;
        }

        .border-klinik {
            --bs-border-opacity: 1;
            border-color: #4874ac !important;
        }

        .text-klinik {
            color: #4874ac;
        }

        .bg-klinik {
            background-color: #4874ac;
        }

        .border {
            border: 3px solid #4874ac !important;
        }

    </style>

    <title>Hasil Laboratorium</title>
</head>
<body style="font-family: 'Nunito Sans', sans-serif;">
<!--begin::Text-->
<header>
    <table style="width:100%;" cellspacing="15" class="border border-klinik">
        <tr style="vertical-align:baseline">
            <td style="width: 25%;vertical-align:middle">
                {{--<img src="{{ public_path(theme()->getMediaUrlPath() . 'logos/logo-klinik.png') }}" alt="" style="height:50px;">--}}
                <img src="{{ public_path(theme()->getMediaUrlPath() . 'logos/logo-klinik.png') }}" style="height:50px;">
            </td>
            <td style="width: 75%; vertical-align:top;text-align:left;border-left: 3px solid #4874ac;padding-left:10px;">
                <p style="font-size: 14px;margin:0px; padding:0px;">Ruko C-17, Pasar Modern Intermoda - BSD<br>Jl. Raya
                    Cisauk Lapan, Sampora, Cisauk, Tangerang, Banten.
                </p>
                <p style="font-size: 12px;margin:0px; padding:0px;margin-top:5px;">
                    <img src="{{ public_path(theme()->getMediaUrlPath() . 'logos/wa.png') }}" alt=""
                         style="height:10px;"> 0896 5886 8769
                    <img src="{{ public_path(theme()->getMediaUrlPath() . 'logos/call.png') }}" alt=""
                         style="height:10px;margin-left:5px;"> 021 5569 8265
                    <img src="{{ public_path(theme()->getMediaUrlPath() . 'logos/globe.png') }}" alt=""
                         style="height:10px;margin-left:5px;"> kliniksatriabudi.com
                    <img src="{{ public_path(theme()->getMediaUrlPath() . 'logos/ig.png') }}" alt=""
                         style="height:10px;margin-left:5px;"> klinik.satriabudi</p>
            </td>
        </tr>
    </table>
    <table style="width:100%;border-top:0px !important;border-bottom: 0px !important;" class="border border-klinik">
        <tr style="vertical-align:baseline">
            <td colspan="4" style="width: 100%;text-align:center">
                <p style="margin:0px;font-size:22px;text-align:center;color:black;font-weight:bolder;text-transform:uppercase;font-family: 'Roboto Condensed', sans-serif;">
                    HASIL LABORATORIUM</p>
            </td>
        </tr>
    </table>
    <table style="width:100%;border-top:0px !important;" class="border border-klinik">
        <tr>
            <td style="width:20%;font-size:12px;font-weight:bold">Nama
            <td>
            <td style="width:30%;font-size:12px;">
                : {{ (!in_array($user->info->title_prefix,['','-']) ? $user->info->title_prefix.'. ' : '').$user->name.(!in_array($user->info->title_suffix,['','-']) ? ', '.$user->info->title_suffix : '') }}
            <td>
            <td style="width:20%;font-size:12px;font-weight:bold">Spesimen Diterima
            <td>
            <td style="width:30%;font-size:12px;">
                : {{ $laboratoryexaminations->created_at->locale('id')->translatedFormat('d F Y H:i:s') }}
            <td>
        </tr>
        <tr>
            <td style="width:20%;font-size:12px;font-weight:bold">Alamat
            <td>
            <td style="width:30%;font-size:12px;">: {{ $user->info->address }}
            <td>
            <td style="width:20%;font-size:12px;font-weight:bold">Pelaporan Hasil
            <td>
            <td style="width:30%;font-size:12px;">
                : {{ $laboratoryexaminations->updated_at->locale('id')->translatedFormat('d F Y H:i:s') }}
            <td>
        </tr>
        <tr>
            <td style="width:20%;font-size:12px;font-weight:bold">Tanggal Lahir
            <td>
            <td style="width:30%;font-size:12px;">
                : {{  Carbon::parse($user->info->date_of_birth)->locale('id')->translatedFormat('d F Y') }}
            <td>
            <td style="width:20%;font-size:12px;font-weight:bold">Dokter Pengirim
            <td>
            <td style="width:30%;font-size:12px;">: {{ $laboratoryexaminations->laboratory_name }}
            <td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </table>
</header>
<main>
    <table class="border border-klinik" style="width:100%;border-top:0px !important;" cellspacing="0" cellpadding="0">
        <thead class="bg-klinik" style="color: white;text-transform: capitalize;text-align: left;font-size: 13px">
        <tr>
            <th width="20" style="padding:5px 0px;padding-left: 5px;text-align: left;">Jenis Pemeriksaan</th>
            <th width="25" style="padding:5px 0px;padding-left: 5px;text-align: left;">Hasil Pemeriksaan</th>
            <th width="25" style="padding:5px 0px;padding-left: 5px;text-align: left;">Nilai Rujukan</th>
            <th width="10" style="padding:5px 0px;padding-left: 5px;text-align: left;">Satuan</th>
            <th width="30" style="padding:5px 0px;padding-left: 5px;text-align: left;">Keterangan</th>
        </tr>
        </thead>
        <tbody style="font-size: 12px">
        @foreach($result as $key => $value)
            <tr>
                <td style="padding:3px 0px;padding-left: 5px">{{ $value->ItemName }}</td>
                <td style="padding:3px 0px;padding-left: 5px">{{ $value->hasil }}</td>
                <td style="padding:3px 0px;padding-left: 5px">{{ $value->nilai_rujukan }}</td>
                <td style="padding:3px 0px;padding-left: 5px">{{ $value->satuan ?? '' }}</td>
                <td style="padding:3px 0px;padding-left: 5px">{{ $value->keterangan ?? '' }}</td>
            </tr>
        @endforeach
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="3" style="text-align: center"><img
                    src="{{ public_path(theme()->getMediaUrlPath() . 'logos/stampel.png') }}" alt=""
                    style="height:100px;"></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="3" style="text-align: center"><img
                    src="{{ public_path(theme()->getMediaUrlPath() . 'logos/stampel-name.png') }}" alt=""
                    style="height:35px;"></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        </tbody>
    </table>
</main>
<!--end::Text-->
</body>
</html>

