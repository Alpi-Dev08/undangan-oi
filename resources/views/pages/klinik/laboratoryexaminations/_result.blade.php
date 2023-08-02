@php use Carbon\Carbon; @endphp
    <!-- begin::Wrapper-->
<style>
    .border-klinik{
        --bs-border-opacity: 1;
        border-color: #4874ac !important;
    }
    .text-klinik{
        color:#4874ac;
    }

    .bg-klinik{
        background-color:#4874ac;
    }
</style>
<div class="mw-lg-950px mx-auto w-100 border border-3 border-klinik">
    <!-- begin::Header-->
    <div class="border-bottom border-3 border-klinik px-5">
        <div class="col-12 row py-5">
            <div class="col-4">
                <img src="{{ asset('assets/media/logos/logo-klinik.png') }}" alt="Klinik Satriabudi Dharma Medika" class="h-70px logo">
            </div>
            <div class="col-8 border-start border-3 border-klinik p-3" style="text-align:left">
                <p style="font-size: 16px;font-weight: bold">Ruko C-17, Pasar Modern Intermoda - BSD<br>Jl. Raya Cisauk Lapan, Sampora, Cisauk, Tangerang, Banten.</p>
                <p style="font-size: 14px">
                    <i class="text-klinik fa-brands fa-whatsapp-square fa-lg"></i> 0896 5886 8769
                    <i class="text-klinik fa-solid fa-square-phone fa-lg"></i> 021 5569 8265
                    <i class="text-klinik fa-brands fa-chrome fa-lg"></i> kliniksatriabudi.com
                    <i class="text-klinik fa-brands fa-instagram-square fa-lg"></i> klinik.satriabudi</p>
            </div>
        </div>
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="p-5">
        <div class="row gap-7 gap-md-10">
            <div class="row col-12 flex-root d-flex flex-row text-center">
                <h5 class="fw-bold" >HASIL LABORATORIUM</h5>
            </div>
        </div>
        <div class="row gap-7 gap-md-10">
            <div class="row col-6 flex-root d-flex flex-row">
                <div class="col-4">
                    <span class="fs-5">Nama</span>
                </div>
                <div class="col-8">
                    <span class="fs-5">: {{ $user->name }}</span>
                </div>
            </div>
            <div class="row col-6 flex-root d-flex flex-row">
                <div class="col-4">
                    <span class="fs-5">Spesimen Diterima</span>
                </div>
                <div class="col-8">
                    <span class="fs-5">: {{ $laboratoryexaminations->created_at->locale('id')->translatedFormat('d F Y H:i:s') }}</span>
                </div>
            </div>
        </div>
        <div class="row gap-7 gap-md-10">
            <div class="row col-6 flex-root d-flex flex-row">
                <div class="col-4">
                    <span class="fs-5">Alamat</span>
                </div>
                <div class="col-8">
                    <span class="fs-5">: {{ $user->info->address }}</span>
                </div>
            </div>
            <div class="row col-6 flex-root d-flex flex-row">
                <div class="col-4">
                    <span class="fs-5">Pelaporan Hasil</span>
                </div>
                <div class="col-8">
                    <span class="fs-5">: {{ $laboratoryexaminations->updated_at->locale('id')->translatedFormat('d F Y H:i:s') }}</span>
                </div>
            </div>
        </div>
        <div class="row gap-7 gap-md-10">
            <div class="row col-6 flex-root d-flex flex-row">
                <div class="col-4">
                    <span class="fs-5">Tanggal Lahir </span>
                </div>
                <div class="col-8">
                    <span class="fs-5">: {{ $user->info->date_of_birth }}</span>
                </div>
            </div>
            <div class="row col-6 flex-root d-flex flex-row">
                <div class="col-4">
                    <span class="fs-5">Dokter Pengirim</span>
                </div>
                <div class="col-8">
                    <span class="fs-5">: {{ $laboratoryexaminations->laboratory_name }}</span>
                </div>
            </div>
        </div>
    </div>

    <form id="kt_invoice_form" method="POST" class="form" action="{{ route('result.update',['laboratoryexaminations' => $laboratoryexaminations->id]) }}">
        @csrf
        @method("PUT")
        <table class="w-100 py-5" data-kt-element="items">
            <thead class="bg-klinik border-bottom-1 border-top-1 border-klinik text-white text-capitalize py-5">
            <tr>
                <th width="20" class="px-5">Jenis Pemeriksaan</th>
                <th width="25">Hasil Pemeriksaan</th>
                <th width="25">Nilai Rujukan</th>
                <th width="10">Satuan</th>
                <th width="30">Keterangan</th>
            </tr>
            </thead>
            <tbody class="py-5">
            @if(!empty($result))
                @foreach($result as $key => $value)
                    @if($value->ItemName!='Hematologi')
                        <tr>
                            <td class="px-5">{{ $value->ItemName }}</td>
                            <td>
                                <input type="hidden" class="form-control text-end" name="id[]" value="{{ $value->id }}"/>
                                <input type="text" class="form-control w-75 text-end" name="hasil[]" value="{{ $value->hasil }}"/>
                            </td>
                            <td>{{ $value->nilai_rujukan }}</td>
                            <td>
                                <input type="text" class="form-control w-75  text-end" name="satuan[]" value="{{ $value->satuan ?? '' }}"/>
                            </td>
                            <td>
                                <input type="text" class="form-control w-75  text-end" name="keterangan[]" value="{{ $value->keterangan ?? '' }}"/>
                            </td>
                        </tr>
                    @endif
                @endforeach
            @else
                @foreach($type as $key => $value)
                    @if($value->ItemName!='Hematologi')
                        <tr>
                            <td class="px-5">{{ $value['name'] }}</td>
                            <td>
                                <input type="hidden" class="form-control text-end" name="id[]" value="{{ $value['id'] }}"/>
                                <input type="text" class="form-control w-75  text-end" name="hasil[]" value=""/>
                            </td>
                            <td>{{ $value['nilai_rujukan'] }}</td>
                            <td>
                                <input type="text" class="form-control w-75  text-end" name="satuan[]" value=""/>
                            </td>
                            <td>
                                <input type="text" class="form-control w-75  text-end" name="keterangan[]" value=""/>
                            </td>
                        </tr>
                    @endif
                @endforeach
            @endif
            </tbody>
        </table>

        <div class="d-flex flex-stack flex-wrap mt-lg-20 pt-13 d-print-none p-5">
            <!-- begin::Actions-->
            <div class="my-1 me-5">
                <button type="submit" class="btn btn-primary" data-kt-transactions-modal-action="submit">
                    <span class="indicator-label">Submit</span>
                    <span class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
            </div>
            <!-- end::Actions-->
        </div>
        <!-- end::Footer-->
    </form>
</div>
<!-- end::Wrapper-->
