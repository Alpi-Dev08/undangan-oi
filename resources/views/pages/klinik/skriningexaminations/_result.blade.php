@php use Carbon\Carbon; @endphp
<style>
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

    .link-input {
        width: 97%;
    }
</style>
<div class="mw-lg-950px mx-auto w-100 border border-3 border-klinik">
    <!-- Header -->
    <div class="border-bottom border-3 border-klinik px-5">
        <div class="col-12 row py-5">
            <div class="col-4">
                <img src="{{ asset('assets/media/logos/logo-klinik.png') }}" alt="Klinik Satriabudi Dharma Medika"
                    class="h-70px logo">
            </div>
            <div class="col-8 border-start border-3 border-klinik p-3" style="text-align:left">
                <p style="font-size: 16px;font-weight: bold">Ruko C-17, Pasar Modern Intermoda - BSD<br>Jl. Raya Cisauk
                    Lapan, Sampora, Cisauk, Tangerang, Banten.</p>
                <p style="font-size: 14px">
                    <i class="text-klinik fa-brands fa-whatsapp-square fa-lg"></i> 0896 5886 8769
                    <i class="text-klinik fa-solid fa-square-phone fa-lg"></i> 021 5569 8265
                    <i class="text-klinik fa-brands fa-chrome fa-lg"></i> kliniksatriabudi.com
                    <i class="text-klinik fa-brands fa-instagram-square fa-lg"></i> klinik.satriabudi
                </p>
            </div>
        </div>
    </div>
    <!-- Body -->
    <div class="p-5">
        <!-- Judul Tengah -->
        <div class="row gap-7 gap-md-10">
            <div class="row col-12 flex-root d-flex flex-row text-center justify-content-center">
                <h5 class="fw-bold">HASIL SKRINING EXAMINATION</h5>
            </div>
        </div>

        <!-- Baris 1: Nama - Tanggal Pemeriksaan -->
        <div class="row gap-7 gap-md-10">
            <div class="row col-6 flex-root d-flex flex-row">
                <div class="col-4">
                    <span class="fs-5">Nama</span>
                </div>
                <div class="col-8">
                    <span class="fs-5">: {{ $skrining->first_name }} {{ $skrining->last_name }}</span>
                </div>
            </div>
            <div class="row col-6 flex-root d-flex flex-row">
                <div class="col-5">
                    {{ $skrining->card_type == 'ktp' ? 'No. NIK' : 'No. BPJS' }}
                </div>
                <div class="col-7">
                    <span class="fs-5">: {{ $skrining->nik_bpjs }}</span>
                </div>
            </div>
        </div>

        <!-- Baris 2: Usia - Lokasi Pemeriksaan -->
        <div class="row gap-7 gap-md-10">
            <div class="row col-6 flex-root d-flex flex-row">
                <div class="col-4">
                    <span class="fs-5">Usia</span>
                </div>
                <div class="col-8">
                    <span class="fs-5">: {{ $skrining->age }}</span>
                </div>
            </div>
            <div class="row col-6 flex-root d-flex flex-row">
                <div class="col-5">
                    <span class="fs-5">Nomor Telepon</span>
                </div>
                <div class="col-7">
                    <span class="fs-5">: {{ $skrining->phone }}</span>
                </div>
            </div>
        </div>

        <!-- Baris 3: NIK - Nomor Telepon -->
        <div class="row gap-7 gap-md-10">
            <div class="row col-6 flex-root d-flex flex-row">
                <div class="col-4">
                    <span class="fs-5">Jenis Kelamin</span>
                </div>
                <div class="col-8">
                    <span class="fs-5">: {{ $skrining->gender->name ?? '-' }}</span>
                </div>
            </div>
            <div class="row col-6 flex-root d-flex flex-row">
                <div class="col-5">
                    <span class="fs-5">Tanggal Pemeriksaan</span>
                </div>
                <div class="col-7">
                    <span class="fs-5">:
                        {{ \Carbon\Carbon::parse($skrining->examination_date)->translatedFormat('d F Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Baris 4: NIK - Nomor Telepon -->
        <div class="row gap-7 gap-md-10">
            <div class="row col-6 flex-root d-flex flex-row">
                <div class="col-4">
                    <span class="fs-5">Alamat</span>
                </div>
                <div class="col-8">
                    <span class="fs-5">: {{ $skrining->address }}</span>
                </div>
            </div>
            <div class="row col-6 flex-root d-flex flex-row">
                <div class="col-5">
                    <span class="fs-5">Lokasi Pemeriksaan</span>
                </div>
                <div class="col-7">
                    <span class="fs-5">: {{ $skrining->location->name ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    <form id="skrining_form" method="POST" class="form"
        action="{{ route('skriningexaminations.result.update', ['skriningexaminations' => $skrining->id]) }}">
        @csrf
        @method('PUT')
        <table class="w-100 py-5">
            <thead class="bg-klinik text-white text-capitalize py-5">
                <tr>
                    <th width="20" class="px-5">Jenis Pemeriksaan</th>
                    <th width="25">Hasil Pemeriksaan</th>
                    <th width="25">Nilai Normal</th>
                    <th width="10">Satuan</th>
                    <th width="30">Keterangan</th>
                </tr>
            </thead>
            <tbody class="py-5">
                @if (!empty($result))
                    @foreach ($result as $key => $value)
                        <tr>
                            <td class="px-5">
                                {{ $value->ItemName }}
                                <input type="hidden" name="id[]" value="{{ $value->id }}">
                            </td>
                            <td>
                                <input type="text" class="form-control w-75 text-end" name="hasil[]"
                                    value="{{ $value->hasil }}">
                            </td>
                            <td>{{ $value->nilai_normal }}</td>
                            <td>
                                <input type="text" class="form-control w-75 text-end" name="satuan[]"
                                    value="{{ $value->satuan ?? '' }}" />
                            </td>
                            <td>
                                <input type="text" class="form-control w-75 text-end" name="keterangan[]"
                                    value="{{ $value->keterangan ?? '' }}">
                            </td>
                        </tr>
                    @endforeach
                @else
                    @foreach ($types as $key => $value)
                        <tr>
                            <td class="px-5">
                                {{ $value->name }}
                                <input type="hidden" name="id[]" value="{{ $value->id }}">
                            </td>
                            <td>
                                <input type="text" class="form-control w-75 text-end" name="hasil[]" value="">
                            </td>
                            <td>{!! $value->nilai_normal !!}</td>
                            <td>
                                <input type="text" class="form-control w-75 text-end" name="satuan[]"
                                    value="{{ $value->satuan ?? '' }}" />
                            </td>
                            <td>
                                <input type="text" class="form-control w-75 text-end" name="keterangan[]"
                                    value="">
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <!-- Kolom input link sebelum tombol submit -->
        <div class="row col-12 flex-root d-flex flex-row mb-3 mt-3">
            <div class="col-3">
                <span class="fs-5" style="margin-left: 1.2rem;">Deskripsi</span>
            </div>
            <div class="col-9">
                <textarea name="deskripsi" class="form-control link-input" id="deskripsi">{{ old('deskripsi', $skrining->deskripsi ?? '') }}</textarea>
            </div>
        </div>

        <div class="d-flex flex-stack flex-wrap mt-5 p-5">
            <button type="submit" class="btn btn-primary">
                Submit
            </button>
        </div>
    </form>

</div>
