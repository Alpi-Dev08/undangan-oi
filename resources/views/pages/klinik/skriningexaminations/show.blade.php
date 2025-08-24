<x-base-layout>
    <!-- Main Card -->
    <div class="card card-custom shadow-sm">
        <div class="card-header">
            <h3 class="card-title">Detail Skrining</h3>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-4">Nama Lengkap</dt>
                <dd class="col-sm-8">{{ $skrining->nama_lengkap }}</dd>

                <dt class="col-sm-4">No. NIK / BPJS</dt>
                <dd class="col-sm-8">{{ $skrining->no_identitas }}</dd>

                <dt class="col-sm-4">Usia</dt>
                <dd class="col-sm-8">{{ $skrining->usia }}</dd>

                <dt class="col-sm-4">Telepon</dt>
                <dd class="col-sm-8">{{ $skrining->telepon }}</dd>

                <dt class="col-sm-4">Gender</dt>
                <dd class="col-sm-8">{{ $skrining->gender }}</dd>

                <dt class="col-sm-4">Tanggal Pemeriksaan</dt>
                <dd class="col-sm-8">{{ $skrining->tanggal_pemeriksaan }}</dd>

                <dt class="col-sm-4">Alamat</dt>
                <dd class="col-sm-8">{{ $skrining->alamat }}</dd>
            </dl>
        </div>
    </div>
</x-base-layout>
