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
    <p style="color:#000;margin:0px;font-size:22px;text-align:center;font-weight:bolder;text-transform:uppercase;font-family: 'Roboto Condensed', sans-serif;margin-bottom:50px;margin-top:20px;        text-decoration:underline;">Pemberian Informasi</p>
    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:20%;">Dokter Pelaksana Tindakan</td>
                <td style="width:80%;">: <b>{{ (!in_array($examination->health_profesional->user->info->title_prefix,['','-']) ? $examination->health_profesional->user->info->title_prefix.'. ' : '').$examination->health_profesional->user->name.(!in_array($examination->health_profesional->user->info->title_suffix,['','-']) ? ', '.$examination->health_profesional->user->info->title_suffix : '') }}</b><br>
                    <b>{{ $examination->health_profesional->sip_number ? 'SIP.'.$examination->health_profesional->sip_number : '' }}</b></td>
            </tr>
            <tr>
                <td style="width:20%;">Pemberi Informasi</td>
                <td style="width:80%;">: <b>{{ $data->pemberi_informasi }}</b></td>
            </tr>
            <tr>
                <td style="width:20%;">Penerima Informasi/Pemberi Persetujuan</td>
                <td style="width:80%;">: <b>{{ (!in_array($user->info->title_prefix,['','-']) ? $user->info->title_prefix.'. ' : '').$user->name.(!in_array($user->info->title_suffix,['','-']) ? ', '.$user->info->title_suffix : '') }}</b></td>
            </tr>
        </tbody>
    </table>

    <br>
    <table class="table"  style="width:100%;border:1px solid black">
        <thead>
        <tr>
            <th style="border:1px solid black;text-align:center;width:30px">No.</th>
            <th style="border:1px solid black">Jenis Informasi</th>
            <th style="border:1px solid black">Isi Informasi</th>
            <th style="border:1px solid black">Tanda</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style="border:1px solid black;text-align:center;">1. </td>
            <td style="border:1px solid black">Diagnosis (WD & DD)</td>
            <td style="border:1px solid black">{{ $data->diagnosis }}</td>
            <td style="border:1px solid black; text-align: center;width:150px">{{ isset($data->diagnosis_check) ? "v" : "-" }}</td>
        </tr>
        <tr>
            <td style="border:1px solid black;text-align:center;">2. </td>
            <td style="border:1px solid black">Dasar Diagnosis</td>
            <td style="border:1px solid black">{{ $data->dasar_diagnosis }}</td>
            <td style="border:1px solid black; text-align: center">{{ isset($data->dasar_diagnosis_check) ? "v" : "-" }}</td>
        </tr>
        <tr>
            <td style="border:1px solid black;text-align:center;">3. </td>
            <td style="border:1px solid black">Tindakan Kedokteran</td>
            <td style="border:1px solid black">{{ $data->tindakan }}</td>
            <td style="border:1px solid black; text-align: center">{{ isset($data->tindakan_check) ? "v" : "-" }}</td>
        </tr>
        <tr>
            <td style="border:1px solid black;text-align:center;">4. </td>
            <td style="border:1px solid black">Indikasi Tindakan</td>
            <td style="border:1px solid black">{{ $data->indikasi }}</td>
            <td style="border:1px solid black; text-align: center">{{ isset($data->indikasi_check) ? "v" : "-" }}</td>
        </tr>
        <tr>
            <td style="border:1px solid black;text-align:center;">5. </td>
            <td style="border:1px solid black">Tata Cara</td>
            <td style="border:1px solid black">{{ $data->tatacara }}</td>
            <td style="border:1px solid black; text-align: center">{{ isset($data->tatacara_check) ? "v" : "-" }}</td>
        </tr>
        <tr>
            <td style="border:1px solid black;text-align:center;">6. </td>
            <td style="border:1px solid black">Tujuan</td>
            <td style="border:1px solid black">{{ $data->tujuan }}</td>
            <td style="border:1px solid black; text-align: center">{{ isset($data->tujuan_check) ? "v" : "-" }}</td>
        </tr>
        <tr>
            <td style="border:1px solid black;text-align:center;">7. </td>
            <td style="border:1px solid black">Risiko</td>
            <td style="border:1px solid black">{{ $data->resiko }}</td>
            <td style="border:1px solid black; text-align: center">{{ isset($data->resiko_check) ? "v" : "-" }}</td>
        </tr>
        <tr>
            <td style="border:1px solid black;text-align:center;">8. </td>
            <td style="border:1px solid black">Komplikasi</td>
            <td style="border:1px solid black">{{ $data->komplikasi }}</td>
            <td style="border:1px solid black; text-align: center">{{ isset($data->komplikasi_check) ? "v" : "-" }}</td>
        </tr>
        <tr>
            <td style="border:1px solid black;text-align:center;">9. </td>
            <td style="border:1px solid black">Prognosis</td>
            <td style="border:1px solid black">{{ $data->prognosis }}</td>
            <td style="border:1px solid black; text-align: center">{{ isset($data->prognosis_check) ? "v" : "-" }}</td>
        </tr>
        <tr>
            <td style="border:1px solid black;text-align:center;">10. </td>
            <td style="border:1px solid black">Alternatif dan Risiko</td>
            <td style="border:1px solid black">{{ $data->alternatif }}</td>
            <td style="border:1px solid black; text-align: center">{{ isset($data->alternatif_check) ? "v" : "-" }}</td>
        </tr>
        <tr>
            <td style="border:1px solid black;text-align:center;">11. </td>
            <td style="border:1px solid black">Lain-lain</td>
            <td style="border:1px solid black">{{ $data->lain }}</td>
            <td style="border:1px solid black; text-align: center">{{ isset($data->lain_check) ? "v" : "-" }}</td>
        </tr>
        <tr>
            <td colspan="3"  style="border:1px solid black">Dengan ini menyatakan bahwa saya telah menerangkan hal-hal di atas secara benar dan jujur dan memberikan kesempatan untuk bertanya dan/atau berdiskusi</td>
            <td style="border:1px solid black; text-align: center"></td>
        </tr>
        <tr>
            <td colspan="3"  style="border:1px solid black">>Dengan ini menyatakan bahwa saya telah menerima informasi sebagaimana di atas yang saya beri tanda/paraf di kolom kanannya, dan telah memahaminya</td>
            <td style="border:1px solid black; text-align: center"></td>
        </tr>
        <tr>
            <td colspan="4"  style="border:1px solid black">*Bila pasien tidak kompeten atau tidak mau menerima informasi, maka penerima informasi adalah wali atau keluarga terdekat</td>
        </tr>

        </tbody>
    </table>

    <div class="page_break"></div>
    <table class="table"  style="width:100%;border:1px solid black">
        <tbody>
            <tr>
                <td colspan="4" style=" border:1px solid black;text-align: center">
                    <p style="font-weight: bold">PERSETUJUAN TINDAKAN KEDOKTERAN</p>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="padding:0px 10px;">
                    Yang bertandatangan di bawah ini, saya, nama <b>{{ $data->nama }}</b>, umur <b>{{ $data->umur }}</b> tahun, <b>{{ $data->jenis_kelamin }}</b>, alamat <b>{{ $data->alamat }}</b>, dengan ini menyatakan <b>{{ isset($data->setuju) ? "persetujuan" : 'penolakan'  }}</b> untuk dilakukannya tindakan <b>{{ $data->jenis_tindakan }}</b> terhadap <b>{{ $data->terhadap }}</b> saya* bernama <b>{{ $data->nama_tindak }}</b>,
                    umur <b>{{ $data->umur_tindak }}</b> tahun, <b>{{ $data->jenis_kelamin_tindak }}</b>, alamat <b>{{ $data->alamat_tindak }}</b>
                    Saya memahami perlunya dan manfaat tindakan tersebut sebagaimana telah dijelaskan seperti diatas kepada saya, termasuk resiko dan komplikasi yang mungkin timbul jika tindakan tersebut tidak dilakukan.
                    Saya juga menyadari bahwa oleh karena ilmu kedokteran bukanlah ilmu pasti, maka keberhasilan tindakan kedokteran bukanlah keniscayaan, melainkan sangat bergantung kepada izin Tuhan Yang Maha Esa.
                </td>
            </tr>
            <tr>
                <td colspan="4">Kab. Tangerang, Tanggal{{ \Carbon\Carbon::parse($examination->examination_date)->locale('id')->format('d F Y') }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pukul  {{ date('H:i:s')  }}</td>
            </tr>
            <tr>
                <td colspan="2"style="text-align: center">Yang Menyatakan</td>
                <td colspan="2" style="text-align: center">Saksi</td>
            </tr>
            <tr>
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
            </tr>
            <tr>
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
            </tr>
            <tr>
                <td colspan="2" style="text-align: center">(....................................)</td>
                <td style="text-align: center">(....................................)</td>
                <td style="text-align: center">(....................................)</td>
            </tr>
        </tbody>
    </table>
</main>

<!--end::Text-->
</body>
</html>

