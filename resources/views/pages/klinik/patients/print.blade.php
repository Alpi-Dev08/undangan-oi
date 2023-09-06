<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
</head>
<body>
<div style="font-size:9px;height:2.3cm;width:6cm;border:1px solid black;padding: 5px;padding-top:2px;">
    <table style="width: 100%" cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="2" style="text-align: center;border-bottom: 1px solid black; font-weight: bold">KLINIK SATRIABUDI DHARMA MEDIKA</td>
        </tr>
        <tr>
            <td style="width: 35%;">Nama Dokter</td>
            <td style="width: 65%;">: {{ $dokter }}</td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>: {{ $examination->patient->user->name }}</td>
        </tr>
        <tr>
            <td>Nomor MR</td>
            <td>: {{ $examination->patient->user->mr->medical_record_code }}</td>
        </tr>
        <tr>
            <td>TTL</td>
            <td>: {{ \Carbon\Carbon::parse($examination->patient->user->info->date_of_birth)->locale('id')->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>: {{ $examination->patient->user->info->gender->name }}</td>
        </tr>
    </table>
</div>
</body>
<script>
    window.print();
</script>
</html>
