<x-base-layout>
   @if(Auth::user()->hasRole(['admin','administrator']))
    <!--begin::Card-->
    <div class="card card-lg-stretch mb-5 mb-xl-8">
        <form id="gotest" method="POST" class="form" action="{{ route('patients.pretest') }}">
            {{ csrf_field() }}
        <!--begin::Card body-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                Formulir Skala Get Up and Go Test
            </h3>
        </div>
        <div class="card-body pt-6">

                <!--begin::Scroll-->
                <div class="d-flex flex-column flex-row-fluid" id="kt_modal_add_user_scroll" data-kt-scroll="true"
                     data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                     data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll"
                     data-kt-scroll-offset="300px">
                    <!--begin::Input group-->
                    <div class="row fv-row">
                        <div class="fv-row col-1 mb-7">
                            <p>1.</p>
                        </div>
                        <div class="fv-row col-6 mb-7">
                            <p>Perhatikan cara berjalan pasien saat akan
                            duduk di kursi. Apakah pasien tampak
                            tidak seimbang (sempoyongan / limbung)</p>
                            <p>Atau pasien jalan menggunakan alat bantu
                            (kruk, tripot, kursi roda, orang lain)</p>
                        </div>
                        <div class="fv-row col-5 mb-7 text-left">
                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input value="ya" class="form-check-input h-20px w-30px me-5" type="checkbox" name="kriteria_satu" id="kriteria_satu"/>
                                <label class="form-check-label" for="kriteria_satu">
                                    Ya/Tidak
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row fv-row">
                        <div class="fv-row col-1 mb-7">
                            <p>2.</p>
                        </div>
                        <div class="fv-row col-6 mb-7">
                            <p>Apakah pasien memegang pinggiran kursi
                                / meja/ benda pada saat berjalan</p>
                        </div>
                        <div class="fv-row col-5 mb-7 text-left">
                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input  value="ya" class="form-check-input h-20px w-30px me-5" type="checkbox" name="kriteria_dua" id="kriteria_dua"/>
                                <label class="form-check-label" for="kriteria_dua">
                                    Ya/Tidak
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="interpretasi" id="_interpretasi">
                <input type="hidden" name="tindakan" id="_tindakan">


            <div id="keterangan">
                <p>Interpretasi : <em id="interpretasi"></em></p>
                <p>Tindakan : <em id="tindakan"></em></p>
            </div>
        </div>
        <!--end::Card body-->
        <!--begin::Actions-->
        <div class="card-footer d-flex justify-content-end py-6 px-9">
            <button type="submit" class="btn btn-primary">
                @include('partials.general._button-indicator', ['label' => __('Save')])
            </button>
        </div>
        <!--end::Actions-->
        </form>
    </div>
    <!--end::Card-->
    @push('customscript')
        <script>
            $(function () {

                $("#interpretasi").text('Tidak Beresiko Jatuh').css({color:'green','font-weight':'bold'});
                $("#_interpretasi").val('Tidak Beresiko Jatuh');

                $("#tindakan").text('-').css({color:'green','font-weight':'bold'});
                $("#_tindakan").val('-');

                $("#kriteria_satu").change(function () {
                    if (this.checked && $('#kriteria_dua').is(':checked')) {
                        $("#interpretasi").text('Berisiko Tinggi').css({color:'red','font-weight':'bold'});
                        $("#_interpretasi").val('Berisiko Tinggi');

                        $("#tindakan").text('pemberian gelang kuning, edukasi, pendampingan dan pemberian fasilitas (kursi roda, tripod)').css({color:'red','font-weight':'bold'});
                        $("#_tindakan").val('pemberian gelang kuning, edukasi, pendampingan dan pemberian fasilitas (kursi roda, tripod)');
                    } else  if (this.checked || $('#kriteria_dua').is(':checked')) {
                        $("#interpretasi").text('Berisiko Rendah').css({color:'orange','font-weight':'bold'});
                        $("#_interpretasi").val('Berisiko Rendah');


                        $("#tindakan").text('edukasi pasien dan / atau keluarga').css({color:'orange','font-weight':'bold'});
                        $("#_tindakan").val('edukasi pasien dan / atau keluarga');
                    } else {
                        $("#interpretasi").text('Tidak Beresiko Jatuh').css({color:'green','font-weight':'bold'});
                        $("#_interpretasi").val('Tidak Beresiko Jatuh');

                        $("#tindakan").text('-').css({color:'green','font-weight':'bold'});
                        $("#_tindakan").val('-');
                    }
                });
                $("#kriteria_dua").change(function () {
                    if (this.checked && $('#kriteria_satu').is(':checked')) {
                        $("#interpretasi").text('Berisiko Tinggi').css({color:'red','font-weight':'bold'});
                        $("#_interpretasi").val('Berisiko Tinggi');
                        $("#tindakan").text('pemberian gelang kuning, edukasi, pendampingan dan pemberian fasilitas (kursi roda, tripod)').css({color:'red','font-weight':'bold'});
                    } else  if (this.checked || $('#kriteria_satu').is(':checked')) {
                        $("#interpretasi").text('Berisiko Rendah').css({color:'orange','font-weight':'bold'});
                        $("#_interpretasi").val('Berisiko Rendah');
                        $("#tindakan").text('edukasi pasien dan / atau keluarga').css({color:'orange','font-weight':'bold'});
                    } else {
                        $("#interpretasi").text('Tidak Beresiko Jatuh').css({color:'green','font-weight':'bold'});
                        $("#_interpretasi").val('Tidak Beresiko Jatuh');
                        $("#tindakan").text('-').css({color:'green','font-weight':'bold'});
                    }
                });
            })
        </script>
    @endpush
	@endif
</x-base-layout>
