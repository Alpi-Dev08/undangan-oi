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

        body {
            font-family: 'Arial', sans-serif; 
        }

        body {
            font-family: 'DejaVu Sans', 'Segoe UI', Arial, sans-serif; /* Font yang mendukung Unicode */
        }

    </style>

    <title>Surat Keterangan {{ $user->name }}</title>
</head>
<body  style="font-family: 'Nunito Sans', sans-serif;">
<!--begin::Text-->
<header>
    <table style="width:100%;border-bottom-width:5px;border-bottom-style:double">
        <tr>
            <td style="width: 50%; vertical-align:top">
                <img src="{{ public_path(theme()->getMediaUrlPath() . 'logos/logo-klinik.png') }}" style="height:50px;">
            </td>
            <!-- <td style="width: 50%; vertical-align:top; text-align: right;">
                <p style="font-size:12px; margin: 0; color:#000;">
                    Nama: <b>{{ (!in_array($user->info->title_prefix,['','-']) ? $user->info->title_prefix.'. ' : '').$user->name.(!in_array($user->info->title_suffix,['','-']) ? ', '.$user->info->title_suffix : '') }}</b>
                    <br>
                    Tempat, Tanggal Lahir: <b>{{ $data->tempat_tgl }}</b>
                </p>
            </td> -->
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
    <p style="color:#000;margin:0px;font-size:22px;text-align:center;font-weight:bolder;text-transform:uppercase;font-family: 'Roboto Condensed', sans-serif;margin-bottom:50px;margin-top:20px;        text-decoration:underline;">SURGICAL SAFETY CHECKLIST</p>
    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:20%;">Nama</td>
                <td style="width:80%;">: <b>{{ (!in_array($user->info->title_prefix,['','-']) ? $user->info->title_prefix.'. ' : '').$user->name.(!in_array($user->info->title_suffix,['','-']) ? ', '.$user->info->title_suffix : '') }}</b></td>
            </tr>
            <tr>
                <td style="width:20%;">Tempat, Tanggal Lahir</td>
                <td style="width:80%;">: <b>{{ $data->waktu_tindakan}}</b></td>
            </tr>
            <tr>
                <td style="width:20%;">Nomor RM</td>
                <td style="width:80%;">: <b>{{ $data->no_RM}}</b></td>
            </tr>
        </tbody>
    </table>

    <br>
    <br>
    <p style="color:#000;margin:0px;font-size:16px;text-align:left;font-weight:bold;font-family: 'Roboto Condensed', sans-serif; text-decoration:underline;">I. SIGN IN ( Sebelum induksi anestesi )</p>
    <p style="color:#000;margin:0px;font-size:16px;text-align:left;font-weight:bold;font-family: 'Roboto Condensed', sans-serif;">Dilakukan oleh perawat dan dokter</p>
    <table class="table"  style="width:100%;">
        <tbody>
            <br>
            <tr>
                <td><strong>1.1  VERIFIKASI</strong></td>
            </tr>
            <tr>
                <td style="width:100%;"> <span style="font-family: DejaVu Sans, sans-serif;">✔</span> Identitas pasien (nama lengkap dan tanggal lahir) dan gelang pasien</td>
            </tr>
            <tr>
                <td style="width:100%;"> <span style="font-family: DejaVu Sans, sans-serif;">✔</span> Informed Consent</td>
            </tr>
            <tr>
                <td style="width:20%;"><span style="font-family: DejaVu Sans, sans-serif;">✔</span>Dokter</td>
                <td style="width:80%;"> :
                    <b>{{ (!in_array($examination->health_profesional->user->info->title_prefix,['','-']) ? $examination->health_profesional->user->info->title_prefix.'. ' : '').$examination->health_profesional->user->name.(!in_array($examination->health_profesional->user->info->title_suffix,['','-']) ? ', '.$examination->health_profesional->user->info->title_suffix : '') }}</b><br>
                    <b>{{ $examination->health_profesional->sip_number ? 'SIP.'.$examination->health_profesional->sip_number : '' }}</b>
                </td>
            </tr>
            <tr>
                <td style="width:20%;"><span style="font-family: DejaVu Sans, sans-serif;">✔</span>Nama Operator</td>
                <td style="width:80%;">: <b>{{ $data->nama_operator }}</b></td>
            </tr>
            <tr>
                <td style="width:20%;"><span style="font-family: DejaVu Sans, sans-serif;">✔</span>Nama Tindakan</td>
                <td style="width:80%;">: <b>{{ $data->nama_tindakan }}</b></td>
            </tr>
            <tr>
                <td style="width:20%;"><span style="font-family: DejaVu Sans, sans-serif;">✔</span>Diagnosa</td>
                <td style="width:80%;">: <b>{{ $data->diagnosa }}</b></td>
            </tr>
        </tbody>
    </table>

    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:100%;"></td>
            </tr>
            <tr>
                <td style="width:20%;"><span style="font-family: DejaVu Sans, sans-serif;">✔</span> Pemberian tanda di lokasi operasi ?</td>
                <td style="width:80%;"> <b>{{ $data->perdarahan}}</b></td>
            </tr>
        </tbody>
    </table>
    
    <br>
    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:100%;"><strong>1.2 PEMERIKSAAN KELENGKAPAN ANESTESI</strong></td>
            </tr>
            <tr>
                <td style="width:20%;"><span style="font-family: DejaVu Sans, sans-serif;">✔</span>Pemeriksaan Kelengkapan Anestesi</td>
                <td style="width:80%;">
                    <b>
                        {{ isset($data->kelengkapan_anestesi_mesin) ? $data->kelengkapan_anestesi_mesin : '' }}
                        <br>
                        {{ isset($data->kelengkapan_anestesi_obat) ? $data->kelengkapan_anestesi_obat : '' }}
                        <br>
                        {{ isset($data->kelengkapan_anestesi_laboratorium) ? $data->kelengkapan_anestesi_laboratorium : '' }}
                        <br>
                        {{ isset($data->kelengkapan_anestesi_ivline) ? $data->kelengkapan_anestesi_ivline : '' }}
                    </b>
                </td>
            </tr>
        </tbody>
    </table>

    <br>
    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:100%;"><strong>1.3 PEMERIKSAAN TANDA VITAL</strong></td>
            </tr>
            <tr>
                <td style="width:20%;"><span style="font-family: DejaVu Sans, sans-serif;">✔</span>Tekanan Darah</td>
                <td style="width:80%;">: <b>{{ $examination->vitality->blood_pressure ?? "-" }}</b></td>
            </tr>
            <tr>
                <td style="width:20%;"><span style="font-family: DejaVu Sans, sans-serif;">✔</span>Nadi</td>
                <td style="width:80%;">: <b>{{ $examination->vitality->heart_rate ?? "-" }}</b></td>
            </tr>
            <tr>
                <td style="width:20%;"><span style="font-family: DejaVu Sans, sans-serif;">✔</span>Pernafasan</td>
                <td style="width:80%;">: <b>{{ $data->pernafasan }}</b></td>
            </tr>
            <tr>
                <td style="width:20%;"><span style="font-family: DejaVu Sans, sans-serif;">✔</span>Saturasi O2</td>
                <td style="width:80%;">: <b>{{ $data->saturasi_o2 }}</b></td>
            </tr>
            <tr>
                <td style="width:20%;"><span style="font-family: DejaVu Sans, sans-serif;">✔</span>Suhu</td>
                <td style="width:80%;">: <b>{{ $examination->vitality->temperature ?? "-" }}</b></td>
            </tr>
        </tbody>
    </table>

    <br>
    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:100%;"><strong>1.4  RIWAYAT ALERGI</strong></td>
            </tr>
            <tr>
                <td style="width:20%;"><span style="font-family: DejaVu Sans, sans-serif;">✔</span>Riwayat Alergi</td>
                <td style="width:80%;"><b>{{ $data->riwayat_alergi}}</b></td>
            </tr>
        </tbody>
    </table>

    <br>
    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:100%;"><strong>1.5  RISIKO ASPIRASI ATAU GANGGUAN PERNAFASAN</strong></td>
            </tr>
            <tr>
                <td style="width:20%;"><span style="font-family: DejaVu Sans, sans-serif;">✔</span>Risiko Aspirasi atau Gangguan Pernafasan</td>
                <td style="width:80%;"><b>{{ $data->aspirasi}}</b></td>
            </tr>
        </tbody>
    </table>

    <br>
    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:100%;"><strong>1.6   RISIKO PERDARAHAN</strong></td>
            </tr>
            <tr>
                <td style="width:20%;"><span style="font-family: DejaVu Sans, sans-serif;">✔</span>Risiko Perdarahan</td>
                <td style="width:80%;"><b>{{ $data->resiko_perdarahan}}</b></td>
            </tr>
        </tbody>
    </table>

    <br>
    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:100%;"><strong>1.7    RENCANA ANESTESI</strong></td>
            </tr>
            <tr>
                <td style="width:20%;"><span style="font-family: DejaVu Sans, sans-serif;">✔</span>Rencana Anestesi</td>
                <td style="width:80%;">
                    <b>
                        {{ isset($data->risiko_perdarahan_umum) ? $data->risiko_perdarahan_umum : '' }}
                        <br>
                        {{ isset($data->risiko_perdarahan_spinal) ? $data->risiko_perdarahan_spinal : '' }}
                        <br>
                        {{ isset($data->risiko_perdarahan_blok) ? $data->risiko_perdarahan_blok : '' }}
                        <br>
                        {{ isset($data->risiko_perdarahan_lokal) ? $data->risiko_perdarahan_lokal : '' }}
                    </b>
                </td>
            </tr>
        </tbody>
    </table>

    <br>
    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:20%;">TANGGAL VERIFIKASI</td>
                <td style="width:80%;"> : <b>{{ \Carbon\Carbon::parse($examination->examination_date)->locale('id')->format('d F Y') }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
            </tr>
            <tr>
                <td style="width:20%;">JAM VERIFIKASI</td>
                <td style="width:80%;"> : <b>{{ date('H:i:s')  }}</b></td>
            </tr>
        </tbody>
    </table>

    
    <br>
    <br>
    <br>
    <p style="color:#000;margin:0px;font-size:16px;text-align:left;font-weight:bold;font-family: 'Roboto Condensed', sans-serif; text-decoration:underline;">II. TIME OUT ( Sebelum insisi kulit )</p>
    <p style="color:#000;margin:0px;font-size:16px;text-align:left;font-weight:bold;font-family: 'Roboto Condensed', sans-serif;">Dilakukan oleh perawat dan dokter </p>
    
    <br>
    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:100%;"><strong>2.1 KELENGKAPAN TIM  DAN FASILITAS OPERASI</strong></td>
            </tr>
            <tr>
                <td style="width:20%;"><span style="font-family: DejaVu Sans, sans-serif;">✔</span>Kelengkapan Tim dan Fasilitas Operasi</td>
                <td style="width:80%;"><b>{{ $data->kelengkapan_tim}}</b></td>
            </tr>
        </tbody>
    </table>

    <br>
    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:100%;"><strong>2.2 PERIKSA KELENGKAPAN PERALATAN  OPERASI</strong></td>
            </tr>
            <tr>
                <td style="width:20%;"><span style="font-family: DejaVu Sans, sans-serif;">✔</span> Kelengkapan Alat : </td>
                <td style="width:80%;"> <b>{{ $data->kelengkapan_alat_instrument1}}</b></td>
            </tr>
            <tr>
                <td style="width:20%;"></td>
                <td style="width:80%;"> <b>{{ $data->kelengkapan_alat_kasa1}}</b></td>
            </tr>
            <tr>
                <td style="width:20%;"></td>
                <td style="width:80%;"> <b>{{ $data->kelengkapan_alat_jarum1}}</b></td>
            </tr>
            <tr>
                <td style="width:20%;"></td>
                <td style="width:80%;"> <b>{{ $data->Keterangan_dll}}</b></td>
            </tr>
        </tbody>
    </table>

    <br>
    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:100%;"><strong>2.3 MENYEBUTKAN NAMA DAN PERAN TIM OPERASI </strong></td>
            </tr>
            <tr>
                <td style="width:20%;"><span style="font-family: DejaVu Sans, sans-serif;">✔</span> Menyebutkan nama dan peran tim operasi</td>
                <td style="width:80%;">
                    <b>
                        {{ isset($data->peran_tim_membacakan) ? $data->peran_tim_membacakan : '' }}
                        <br>
                        {{ isset($data->peran_tim_tanggal) ? $data->peran_tim_tanggal : '' }}
                        <br>
                        {{ isset($data->peran_tim_nama_pasien) ? $data->peran_tim_nama_pasien : '' }}
                        <br>
                        {{ isset($data->peran_tim_diagnosa) ? $data->peran_tim_diagnosa : '' }}
                        <br>
                        {{ isset($data->peran_tim_nama_tindakan) ? $data->peran_tim_nama_tindakan : '' }}
                        <br>
                        {{ isset($data->peran_tim_prosedur) ? $data->peran_tim_prosedur : '' }}
                        <br>
                        {{ isset($data->peran_tim_lokasi) ? $data->peran_tim_lokasi : '' }}
                        <br>
                        {{ isset($data->peran_tim_consent) ? $data->peran_tim_consent : '' }}
                    </b>
                </td>
            </tr>
        </tbody>
    </table>

    <script>
        window.onload = function() {
            let hasil = JSON.parse(sessionStorage.getItem('peranTim'));

            if (hasil) {
                document.getElementById('hasilPeranTim').innerHTML = hasil.join(', ');
            } else {
                document.getElementById('hasilPeranTim').innerHTML = 'Tidak ada data yang dipilih.';
            }
        }
    </script>

    <br>
    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:100%;"><strong>2.4 Mengantisipasi Peristiwa Kritis</strong></td>
            </tr>
            <br>
            <tr>
                <td style="width:100%;"><strong>2.4.1  Dokter Bedah : </strong></td>
            </tr>
        </tbody>
    </table>

    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:100%;"></td>
            </tr>
            <tr>
                <td style="width:20%;">- Apakah tindakan yang dilakukan berisiko tinggi ?</td>
                <td style="width:80%;"> <b>{{ $data->risiko_tinggi}}</b></td>
            </tr>
        </tbody>
    </table>

    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:100%;"></td>
            </tr>
            <tr>
                <td style="width:20%;">- Berapa lama tindakan ini akan dilakukan?</td>
                <td style="width:80%;"> <b>{{ $data->waktu_tindakan}}</b></td>
            </tr>
        </tbody>
    </table>

    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:100%;"></td>
            </tr>
            <tr>
                <td style="width:20%;">- Apakah sudah diantisipasi perdarahan?</td>
                <td style="width:80%;"> <b>{{ $data->perdarahan_antisipasi}}</b></td>
            </tr>
        </tbody>
    </table>


    <br>
    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:100%;"><strong>2.4.2  Dokter Anestesi :  </strong></td>
            </tr>
        </tbody>
    </table>

    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:100%;"></td>
            </tr>
            <tr>
                <td style="width:20%;">- Apakah ada perhatian / kekhawatiran pada pasien ini?</td>
                <td style="width:80%;"> <b>{{ $data->perhatian}}</b></td>
            </tr>
        </tbody>
    </table>

    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:100%;"></td>
            </tr>
            <tr>
                <td style="width:20%;">- Pasien ASA berapa?</td>
                <td style="width:80%;"> <b>{{ $data->jumlah_pasien}}</b></td>
            </tr>
        </tbody>
    </table>

    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:100%;"></td>
            </tr>
            <tr>
                <td style="width:20%;">- Apakah ada peralatan yang perlu disediakan (darah)?</td>
                <td style="width:80%;"> <b>{{ $data->peralatan}}</b></td>
            </tr>
        </tbody>
    </table>

    <br>
    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:100%;"><strong>2.4.3  Perawat :   </strong></td>
            </tr>
        </tbody>
    </table>

    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:100%;"></td>
            </tr>
            <tr>
                <td style="width:20%;">- Apakah sudah mengecek sterilisasi alat (melalui indikator sterilisasi)?</td>
                <td style="width:80%;"> <b>{{ $data->sterilisasi}}</b></td>
            </tr>
        </tbody>
    </table>

    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:100%;"></td>
            </tr>
            <tr>
                <td style="width:20%;">- Apakah ada kesiapan peralatan yang harus diperhatikan?</td>
                <td style="width:80%;"> <b>{{ $data->kesiapan_peralatan}}</b></td>
            </tr>
        </tbody>
    </table>

    <br>
    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:100%;"><strong>2.5  ANTIBIOTIK PROPHYLAXIS</strong></td>
            </tr>
            <tr>
                <td style="width:20%;">Apakah sudah diberikan dalam waktu sekurangnya  60 menit  sebelum tindakan?</td>
                <td style="width:80%;"> <b>{{ $data->antibiotik}}</b></td>
            </tr>
        </tbody>
    </table>


    <br>
    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:20%;"><span style="font-family: DejaVu Sans, sans-serif;">✔</span> Nama obat  </td>
                <td style="width:80%;">: <b>{{ $data->nama_obat }}</b></td>
            </tr>
            <tr>
                <td style="width:20%;"><span style="font-family: DejaVu Sans, sans-serif;">✔</span> Dosis obat  </td>
                <td style="width:80%;">: <b>{{ $data->dosis_obat }}</b></td>
            </tr>
            <tr>
                <td style="width:20%;"><span style="font-family: DejaVu Sans, sans-serif;">✔</span> Jam Diberikan  </td>
                <td style="width:80%;">: <b>{{ $data->jam_diberikan }}</b></td>
            </tr>
        </tbody>
    </table>

    <br>
    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:100%;"><strong>2.6 FOTO PEMERIKSAAN RADIOLOGI YANG DIPERLUKAN</strong></td>
            </tr>
            <tr>
                <td style="width:20%;">Foto Pemeriksaan Radiologi yang Diperlukan</td>
                <td style="width:80%;"> <b>{{ $data->radiologi}}</b></td>
            </tr>
        </tbody>
    </table>


    <br>
    <br>
    <br>
    <p style="color:#000;margin:0px;font-size:16px;text-align:left;font-weight:bold;font-family: 'Roboto Condensed', sans-serif; text-decoration:underline;">III. SIGN OUT ( Sebelum pasien keluar kamar tindakan)</p>
    <p style="color:#000;margin:0px;font-size:16px;text-align:left;font-weight:bold;font-family: 'Roboto Condensed', sans-serif;">Dilakukan oleh perawat dan dokter </p>
    
    <br>
    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:100%;"><strong>3.1  Secara Verbal Perawat Memastikan : </strong></td>
            </tr>
            <tr>
                <td style="width:20%;"><span style="font-family: DejaVu Sans, sans-serif;">✔</span> Kelengkapan Alat : </td>
                <td style="width:80%;"> <b>{{ $data->kelengkapan_alat_instrument}}</b></td>
            </tr>
            <tr>
                <td style="width:20%;"></td>
                <td style="width:80%;"> <b>{{ $data->kelengkapan_alat_kasa}}</b></td>
            </tr>
            <tr>
                <td style="width:20%;"></td>
                <td style="width:80%;"> <b>{{ $data->kelengkapan_alat_jarum}}</b></td>
            </tr>
        </tbody>
    </table>

    <br>
    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:100%;"></td>
            </tr>
            <tr>
                <td style="width:20%;"><span style="font-family: DejaVu Sans, sans-serif;">✔</span>Pelabelan specimen (baca spesimen dan nama pasien dengan keras)</td>
                <td style="width:80%;"> <b>{{ $data->pelabelan_specimen}}</b></td>
            </tr>
        </tbody>
    </table>

    <table class="table" style="width:100%;">
        <tbody>
            <tr>
                <td style="width:100%;">Jenis Specimen</td>
            </tr>
            <tr>
                <td style="width:20%;"></td>
                <td style="width:80%;"> <b>{{ isset($data->pemeriksaan_pa) ? $data->pemeriksaan_pa : '' }}</b></td>
            </tr>
            <tr>
                <td style="width:20%;"></td>
                <td style="width:80%;"> <b>{{ isset($data->pemeriksaan_kultur) ? $data->pemeriksaan_kultur : '' }}</b></td>
            </tr>
            <tr>
                <td style="width:20%;"></td>
                <td style="width:80%;"> <b>{{ isset($data->pemeriksaan_sitologi) ? $data->pemeriksaan_sitologi : '' }}</b></td>
            </tr>
        </tbody>
    </table>

    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:100%;"></td>
            </tr>
            <tr>
                <td style="width:20%;"><span style="font-family: DejaVu Sans, sans-serif;">✔</span>Apakah ada masalah peralatan yang perlu disampaikan dari 
                dokter Bedah?</td>
                <td style="width:80%;"> <b>{{ $data->masalah_peralatan}}</b></td>
            </tr>
        </tbody>
    </table>

    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:100%;"></td>
            </tr>
            <tr>
                <td style="width:20%;"><span style="font-family: DejaVu Sans, sans-serif;">✔</span>Formulir permintaan pemeriksaan</td>
                <td style="width:80%;"> <b>{{ $data->formulir_pemeriksaan}}</b></td>
            </tr>
        </tbody>
    </table>

    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:100%;"></td>
            </tr>
            <tr>
                <td style="width:20%;"><span style="font-family: DejaVu Sans, sans-serif;">✔</span>Telah dilengkapi identitas pasien</td>
                <td style="width:80%;"> <b>{{ $data->identitas_pasien}}</b></td>
            </tr>
        </tbody>
    </table>

    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:100%;"></td>
            </tr>
            <tr>
                <td style="width:20%;"><span style="font-family: DejaVu Sans, sans-serif;">✔</span>Penjelasan oleh operator kepada keluarga pasien</td>
                <td style="width:80%;"> <b>{{ $data->penjelasan_operator}}</b></td>
            </tr>
        </tbody>
    </table>

    <br>
    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:100%;"><strong>3.2  OBAT - OBATAN YANG DIBERIKAN SELAMA OPERASI </strong></td>
            </tr>
            <tr>
                <td style="width:20%;"><span style="font-family: DejaVu Sans, sans-serif;">✔</span>Obat-obatan yang diberikan selama Operasi</td>
                <td style="width:80%;"> <b>{{ $data->obat_operasi}}</b></td>
            </tr>
            <tr>
                <td style="width:20%;">Alasan</td>
                <td style="width:80%;"> <b>{{ $data->alasan_obat}}</b></td>
            </tr>
        </tbody>
    </table>


    <br>
    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:100%;"><strong>3.3 PEMERIKSAAN TANDA VITAL </strong></td>
            </tr>
            <tr>
                <td style="width:20%;"><span style="font-family: DejaVu Sans, sans-serif;">✔</span>Kesadaran</td>
                <td style="width:80%;">: <b>{{ $data->kesadaran_1}}</b></td>
            </tr>
            <tr>
                <td style="width:20%;"><span style="font-family: DejaVu Sans, sans-serif;">✔</span>Tekanan darah  </td>
                <td style="width:80%;">: <b>{{ $data->tekanan_1}}</b></td>
            </tr>
            <tr>
                <td style="width:20%;"><span style="font-family: DejaVu Sans, sans-serif;">✔</span>Nadi  </td>
                <td style="width:80%;">: <b>{{ $data->nadi_1}}</b></td>
            </tr>
            <tr>
                <td style="width:20%;"><span style="font-family: DejaVu Sans, sans-serif;">✔</span>Saturasi  O2  </td>
                <td style="width:80%;">: <b>{{ $data->saturasi_1}}</b></td>
            </tr>
            <tr>
                <td style="width:20%;"><span style="font-family: DejaVu Sans, sans-serif;">✔</span>Suhu </td>
                <td style="width:80%;">: <b>{{ $data->suhu_1}}</b></td>
            </tr>
            <tr>
                <td style="width:20%;"><span style="font-family: DejaVu Sans, sans-serif;">✔</span>Pernafasan </td>
                <td style="width:80%;">: <b>{{ $data->pernafasan_1}}</b></td>
            </tr>
            <tr>
                <td style="width:20%;"><span style="font-family: DejaVu Sans, sans-serif;">✔</span>Skala nyeri   </td>
                <td style="width:80%;">: <b>{{ $data->skala_nyeri_1}}</b></td>
            </tr>
        </tbody>
    </table>

    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:100%;"></td>
            </tr>
            <tr>
                <td style="width:20%;"><span style="font-family: DejaVu Sans, sans-serif;">✔</span>Periksa kembali luka operasi</td>
                <td style="width:80%;"> <b>{{ $data->luka_operasi}}</b></td>
            </tr>
        </tbody>
    </table>

    <br>
    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td style="width:100%;"> NAMA DAN TANDA TANGAN :</td>
            </tr>
        </tbody>
    </table>


    <table class="table"  style="width:100%;">
        <tbody>
            <tr>
                <td colspan="4" style="text-align: right;">
                    Kab. Tangerang, {{ \Carbon\Carbon::parse($examination->examination_date)->locale('id')->format('d F Y') }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pukul {{ date('H:i:s')  }}
                </td>
            </tr>
            <br>
            <tr>
                <td colspan="2" style="text-align: center"></td>
                <td colspan="2" style="text-align: center">Dokter Pemeriksa</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center">
                    <br>
                    <b></b>
                    <br>
                    <b></b>
                </td>
                <td colspan="2" style="text-align: center">
                    @if(property_exists($data, 'signature') && !empty($data->signature))
                        <img src="{{ $data->signature }}" alt="Tanda Tangan" style="width: 100%; max-width: 300px; height: auto; max-height: 100px;">
                    @else
                        <p>No signature</p>
                    @endif
                    <br>
                    <b>{{ (!in_array($user->info->title_prefix, ['','-']) ? $user->info->title_prefix . '. ' : '') . $user->name . (!in_array($user->info->title_suffix, ['','-']) ? ', ' . $user->info->title_suffix : '') }}</b><br>
                </td>
            </tr>
        </tbody>
    </table>




</main>

<!--end::Text-->
</body>
</html>

