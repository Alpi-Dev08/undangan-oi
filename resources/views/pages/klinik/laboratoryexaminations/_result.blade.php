@php use Carbon\Carbon; @endphp
    <!-- begin::Wrapper-->
<div class="mw-lg-950px mx-auto w-100 border border-3 border-primary" id="printableArea">
    <!-- begin::Header-->
    <div class="border-bottom border-5 border-primary px-5">
        <div class="col-12 row py-5">
            <div class="col-4">
                <img src="{{ asset('assets/media/logos/logo-klinik.png') }}" alt="Klinik Satriabudi Dharma Medika" class="h-70px logo">
            </div>
            <div class="col-8 border-start border-5 border-primary" style="text-align: left">
                <p style="font-size: 16px;font-weight: bold">Alamat : Ruko C-17, Pasar Modern Intermoda - BSD, Jl. Raya Cisauk Lapan, Sampora, Cisauk, Tangerang, Banten.</p>
                <p style="font-size: 14px">
                    <i class="fa-brands fa-whatsapp fa-lg"></i> 0896 5886 8769
                    <i class="fa-solid fa-square-phone fa-lg"></i> 021 5569 8265
                    <i class="fa-brands fa-chrome fa-lg"></i> kliniksatriabudi.com
                    <i class="fa-brands fa-instagram fa-lg"></i> klinik.satriabudi</p>
            </div>
        </div>
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="p-5">
        <div class="row gap-7 gap-md-10">
            <div class="row col-6 flex-root d-flex flex-row">
                <div class="col-4">
                    <span class="fs-5">Nama</span>
                </div>
                <div class="col-8">
                    <span class="fs-5">: {{ $user->name }}</span>
                </div>
            </div>
            <div class="row col-3 flex-root d-flex flex-row">
                <div class="col-3">
                    <span class="fs-5">RM</span>
                </div>
                <div class="col-9">
                    <span class="fs-5">: {{ $user->mr->medical_record_code }}</span>
                </div>
            </div>
            <div class="row col-3 flex-root d-flex flex-row">
                <div class="col-4">
                    <span class="fs-5">T. Kunj</span>
                </div>
                <div class="col-8">
                    <span class="fs-5">: {{ $laboratoryexaminations->created_at->format('d M Y') }}</span>
                </div>
            </div>
            <div class="row col-3 flex-root d-flex flex-row">
                <div class="col-4">
                    <span class="fs-5">Lab</span>
                </div>
                <div class="col-8">
                    <span class="fs-5">: {{ $laboratoryexaminations->laboratory_name }}</span>
                </div>
            </div>
        </div>
        <div class="row gap-7 gap-md-10">
            <div class="row col-6 flex-root d-flex flex-row">
                <div class="col-4">
                    <span class="fs-5">Alamat </span>
                </div>
                <div class="col-8">
                    <span class="fs-5">: {{ $user->info->address }}</span>
                </div>
            </div>
            <div class="row col-3 flex-root d-flex flex-row">
                <div class="col-4">
                    <span class="fs-5">JK</span>
                </div>
                <div class="col-8">
                    <span class="fs-5">:{{ $user->info->gender->name }}</span>
                </div>
            </div>
            <div class="row col-3 flex-root d-flex flex-row">
                <div class="col-4">
                    <span class="fs-5">T.Lahir</span>
                </div>
                <div class="col-8">
                    <span class="fs-5">:{{ $user->info->date_of_birth }}</span>
                </div>
            </div>
        </div>
    </div>
    <form id="kt_invoice_form" method="POST" class="form" action="{{ route('result.update',['laboratoryexaminations' => $laboratoryexaminations->id]) }}">
        @csrf
        @method("PUT")
        <table class="w-100 py-5" data-kt-element="items">
            <thead class="bg-primary border-bottom-1 border-top-1 border-primary text-white text-capitalize py-5">
            <tr>
                <th class="px-5">Jenis Pemeriksaan</th>
                <th>Hasil Pemeriksaan</th>
                <th>Nilai Rujukan</th>
            </tr>
            </thead>
            <tbody class="py-5">
            @if(!empty($result))
                @foreach($result as $key => $value)
                    <tr>
                        <td class="px-5">{{ $value->ItemName }}</td>
                        <td>
                            <input type="hidden" class="form-control w-50 text-end" name="id[]" value="{{ $value->id }}"/>
                            <input type="text" class="form-control w-50 text-end" name="hasil[]" value="{{ $value->hasil }}"/>
                        </td>
                        <td>{{ $value->nilai_rujukan }}</td>
                    </tr>

                @endforeach
            @else
                @foreach($type as $key => $value)
                    <tr>
                        <td class="px-5">{{ $value['name'] }}</td>
                        <td>
                            <input type="hidden" class="form-control w-50 text-end" name="id[]" value="{{ $value['id'] }}"/>
                            <input type="text" class="form-control w-50 text-end" name="hasil[]" value=""/>
                        </td>
                        <td>{{ $value['nilai_rujukan'] }}</td>
                    </tr>

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
                </button>

                <!-- begin::Pint-->
                <button type="button" class="btn btn-success my-1 me-12" onclick="printDiv('printableArea');">Print Result</button>
                <!-- end::Pint-->
            </div>
            <!-- end::Actions-->
        </div>
        <!-- end::Footer-->
    </form>
</div>
<!-- end::Wrapper-->

@push('customscript')
    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
@endpush
