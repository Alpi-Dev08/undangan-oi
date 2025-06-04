 <div class="tab-pane active" id="skrining" role="tabpanel" aria-labelledby="all-tab"
     data-kt-timeline-widget-4-blockui="true">

     @php
         // Decode data skrining yang sudah tersimpan
         $skriningData = [];
         if (isset($vitalityexamination) && $vitalityexamination && $vitalityexamination->skrining) {
             $skriningData = json_decode($vitalityexamination->skrining, true) ?? [];
         }
     @endphp

     <form method="POST" class="form" action="{{ route('vitalityexaminations.skrining') }}">
         @method('POST')
         {{ csrf_field() }}
         <!--begin::Scroll-->
         <div class="row">
             <input type="hidden" name="examination_id" value="{{ $examination->id }}">
             <input type="hidden" name="user_id" value="{{ $user->id }}">

             <!--begin::Input group-->
             <div class="col-12 mb-6">
                 <div class="d-flex flex-row">
                     <div class="d-flex flex-column flex-row-auto w-200px">
                         <label for="pulse" class="form-label">Kesadaran</label>
                     </div>
                     <div class="d-flex flex-row flex-row-fluid">
                         <div class="form-check form-switch form-check-custom form-check-solid me-10">
                             <input value="Sadar Penuh" class="form-check-input h-20px w-30px me-5" type="radio"
                                 name="kesadaran" id="kesadaran_satu"
                                 {{ isset($skriningData['kesadaran']) && $skriningData['kesadaran'] == 'Sadar Penuh' ? 'checked' : '' }} />
                             <label class="form-check-label" for="kesadaran_satu">
                                 Sadar Penuh
                             </label>
                         </div>
                         <div class="form-check form-switch form-check-custom form-check-solid me-10">
                             <input value="Tampak mengantuk / gelisah bicara tidak jelas"
                                 class="form-check-input h-20px w-30px me-5" type="radio" name="kesadaran"
                                 id="kesadaran_dua"
                                 {{ isset($skriningData['kesadaran']) && $skriningData['kesadaran'] == 'Tampak mengantuk / gelisah bicara tidak jelas' ? 'checked' : '' }} />
                             <label class="form-check-label" for="kesadaran_dua">
                                 Tampak mengantuk / gelisah bicara tidak jelas
                             </label>
                         </div>
                         <div class="form-check form-switch form-check-custom form-check-solid me-10">
                             <input value="Tidak Sadar" class="form-check-input h-20px w-30px me-5" type="radio"
                                 name="kesadaran" id="kesadaran_tiga"
                                 {{ isset($skriningData['kesadaran']) && $skriningData['kesadaran'] == 'Tidak Sadar' ? 'checked' : '' }} />
                             <label class="form-check-label" for="kesadaran_tiga">
                                 Tidak Sadar
                             </label>
                         </div>
                     </div>
                 </div>

             </div>
             <!--end::Input group-->

             <!--begin::Input group-->
             <div class="col-12 mb-6">
                 <div class="d-flex flex-row">
                     <div class="d-flex flex-column flex-row-auto w-200px">
                         <label for="pulse" class="form-label">Pernafasan</label>
                     </div>
                     <div class="d-flex flex-row flex-row-fluid">
                         <div class="form-check form-switch form-check-custom form-check-solid me-10">
                             <input value="Nafas normal" class="form-check-input h-20px w-30px me-5" type="radio"
                                 name="pernafasan" id="pernafasan_satu"
                                 {{ isset($skriningData['pernafasan']) && $skriningData['pernafasan'] == 'Nafas normal' ? 'checked' : '' }} />
                             <label class="form-check-label" for="pernafasan_satu">
                                 Nafas normal
                             </label>
                         </div>
                         <div class="form-check form-switch form-check-custom form-check-solid me-10">
                             <input value="Tampak sesak" class="form-check-input h-20px w-30px me-5" type="radio"
                                 name="pernafasan" id="pernafasan_dua"
                                 {{ isset($skriningData['pernafasan']) && $skriningData['pernafasan'] == 'Tampak sesak' ? 'checked' : '' }} />
                             <label class="form-check-label" for="pernafasan_dua">
                                 Tampak sesak
                             </label>
                         </div>
                         <div class="form-check form-switch form-check-custom form-check-solid me-10">
                             <input value="Tidak bernapas" class="form-check-input h-20px w-30px me-5" type="radio"
                                 name="pernafasan" id="pernafasan_tiga"
                                 {{ isset($skriningData['pernafasan']) && $skriningData['pernafasan'] == 'Tidak bernapas' ? 'checked' : '' }} />
                             <label class="form-check-label" for="pernafasan_tiga">
                                 Tidak bernapas
                             </label>
                         </div>
                     </div>
                 </div>
             </div>
             <!--end::Input group-->

             <!--begin::Input group-->
             <div class="col-12 mb-6">
                 <div class="d-flex flex-row">
                     <div class="d-flex flex-column flex-row-auto w-200px">
                         <label for="pulse" class="form-label">Resiko Jatuh</label>
                     </div>
                     <div class="d-flex flex-row flex-row-fluid">
                         <div class="form-check form-switch form-check-custom form-check-solid me-10">
                             <input value="Resiko rendah" class="form-check-input h-20px w-30px me-5" type="radio"
                                 name="jatuh" id="jatuh_satu"
                                 {{ isset($skriningData['jatuh']) && $skriningData['jatuh'] == 'Resiko rendah' ? 'checked' : '' }} />
                             <label class="form-check-label" for="jatuh_satu">
                                 Resiko rendah
                             </label>
                         </div>
                         <div class="form-check form-switch form-check-custom form-check-solid me-10">
                             <input value="Resiko sedang" class="form-check-input h-20px w-30px me-5" type="radio"
                                 name="jatuh" id="jatuh_dua"
                                 {{ isset($skriningData['jatuh']) && $skriningData['jatuh'] == 'Resiko sedang' ? 'checked' : '' }} />
                             <label class="form-check-label" for="jatuh_dua">
                                 Resiko sedang
                             </label>
                         </div>
                         <div class="form-check form-switch form-check-custom form-check-solid me-10">
                             <input value="Resiko Tinggi" class="form-check-input h-20px w-30px me-5" type="radio"
                                 name="jatuh" id="jatuh_tiga"
                                 {{ isset($skriningData['jatuh']) && $skriningData['jatuh'] == 'Resiko Tinggi' ? 'checked' : '' }} />
                             <label class="form-check-label" for="jatuh_tiga">
                                 Resiko Tinggi
                             </label>
                         </div>
                     </div>
                 </div>
             </div>
             <!--end::Input group-->

             <!--begin::Input group-->
             <div class="col-12 mb-6">
                 <div class="d-flex flex-row">
                     <div class="d-flex flex-column flex-row-auto w-200px">
                         <label for="pulse" class="form-label">Nyeri Dada</label>
                     </div>
                     <div class="d-flex flex-row flex-row-fluid">
                         <div class="form-check form-switch form-check-custom form-check-solid me-10">
                             <input value="Tidak ada" class="form-check-input h-20px w-30px me-5" type="radio"
                                 name="nyeri" id="nyeri_satu"
                                 {{ isset($skriningData['nyeri']) && $skriningData['nyeri'] == 'Tidak ada' ? 'checked' : '' }} />
                             <label class="form-check-label" for="nyeri_satu">
                                 Tidak ada
                             </label>
                         </div>
                         <div class="form-check form-switch form-check-custom form-check-solid me-10">
                             <input value="Ada (Tingkat Sedang)" class="form-check-input h-20px w-30px me-5"
                                 type="radio" name="nyeri" id="nyeri_dua"
                                 {{ isset($skriningData['nyeri']) && $skriningData['nyeri'] == 'Ada (Tingkat Sedang)' ? 'checked' : '' }} />
                             <label class="form-check-label" for="nyeri_dua">
                                 Ada (Tingkat Sedang)
                             </label>
                         </div>
                         <div class="form-check form-switch form-check-custom form-check-solid me-10">
                             <input value="Nyeri dada kiri tembus punggung"
                                 class="form-check-input h-20px w-30px me-5" type="radio" name="nyeri"
                                 id="nyeri_tiga"
                                 {{ isset($skriningData['nyeri']) && $skriningData['nyeri'] == 'Nyeri dada kiri tembus punggung' ? 'checked' : '' }} />
                             <label class="form-check-label" for="nyeri_tiga">
                                 Nyeri dada kiri tembus punggung
                             </label>
                         </div>
                     </div>
                 </div>
             </div>
             <!--end::Input group-->

             <!--begin::Input group-->
             <div class="col-12 mb-6">
                 <div class="d-flex flex-row">
                     <div class="d-flex flex-column flex-row-auto w-200px">
                         <label for="pulse" class="form-label">Skala Nyeri</label>
                     </div>
                     <div class="d-flex flex-column">
                         <div class="d-flex flex-column flex-row-auto mb-5">
                             <img class="w-500px" src="http://127.0.0.1:8000/assets/media/misc/painscale.png"
                                 alt="">
                         </div>
                         <div class="d-flex flex-row flex-row-auto mb-5">
                             <label class="d-flex w-200px form-label">Lokasi : </label>
                             <input type="text" name="lokasi_nyeri"
                                 value="{{ $skriningData['lokasi_nyeri'] ?? '' }}"
                                 class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0">
                         </div>
                         <div class="d-flex flex-row flex-row-fluid mb-5">
                             <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                 <input value="1-3" class="form-check-input h-20px w-30px me-5" type="radio"
                                     name="skala" id="skala_satu"
                                     {{ isset($skriningData['skala']) && $skriningData['skala'] == '1-3' ? 'checked' : '' }} />
                                 <label class="form-check-label" for="skala_satu">
                                     1-3
                                 </label>
                             </div>
                             <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                 <input value="4-6" class="form-check-input h-20px w-30px me-5" type="radio"
                                     name="skala" id="skala_dua"
                                     {{ isset($skriningData['skala']) && $skriningData['skala'] == '4-6' ? 'checked' : '' }} />
                                 <label class="form-check-label" for="skala_dua">
                                     4-6
                                 </label>
                             </div>
                             <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                 <input value="6-10" class="form-check-input h-20px w-30px me-5" type="radio"
                                     name="skala" id="skala_tiga"
                                     {{ isset($skriningData['skala']) && $skriningData['skala'] == '6-10' ? 'checked' : '' }} />
                                 <label class="form-check-label" for="skala_tiga">
                                     6-10
                                 </label>
                             </div>
                         </div>
                     </div>

                 </div>
             </div>
             <!--end::Input group-->

             <!--begin::Input group-->
             <div class="col-12 mb-6">
                 <div class="d-flex flex-row">
                     <div class="d-flex flex-column flex-row-auto w-200px">
                         <label for="pulse" class="form-label">Batuk</label>
                     </div>
                     <div class="d-flex flex-row flex-row-fluid">
                         <div class="form-check form-switch form-check-custom form-check-solid me-10">
                             <input value="Tidak ada" class="form-check-input h-20px w-30px me-5" type="radio"
                                 name="batuk" id="batuk_satu"
                                 {{ isset($skriningData['batuk']) && $skriningData['batuk'] == 'Tidak ada' ? 'checked' : '' }} />
                             <label class="form-check-label" for="batuk_satu">
                                 Tidak ada
                             </label>
                         </div>
                         <div class="form-check form-switch form-check-custom form-check-solid me-10">
                             <input value="Batuk > 2 Minggu" class="form-check-input h-20px w-30px me-5"
                                 type="radio" name="batuk" id="batuk_dua"
                                 {{ isset($skriningData['batuk']) && $skriningData['batuk'] == 'Batuk > 2 Minggu' ? 'checked' : '' }} />
                             <label class="form-check-label" for="batuk_dua">
                                 Batuk > 2 Minggu
                             </label>
                         </div>
                     </div>
                 </div>
             </div>
             <!--end::Input group-->

             <!--begin::Input group-->
             <div class="col-12 mb-6">
                 <div class="d-flex flex-row">
                     <div class="d-flex flex-column flex-row-auto w-200px">
                         <label for="pulse" class="form-label">Keputusan</label>
                     </div>
                     <div class="d-flex flex-row flex-row-fluid">
                         <div class="form-check form-switch form-check-custom form-check-solid me-10">
                             <input value="Diterima" class="form-check-input h-20px w-30px me-5" type="radio"
                                 name="keputusan" id="keputusan_satu"
                                 {{ isset($skriningData['keputusan']) && $skriningData['keputusan'] == 'Diterima' ? 'checked' : '' }} />
                             <label class="form-check-label" for="keputusan_satu">
                                 Diterima
                             </label>
                         </div>
                         <div class="form-check form-switch form-check-custom form-check-solid me-10">
                             <input value="Di Dahulukan" class="form-check-input h-20px w-30px me-5" type="radio"
                                 name="keputusan" id="keputusan_dua"
                                 {{ isset($skriningData['keputusan']) && $skriningData['keputusan'] == 'Di Dahulukan' ? 'checked' : '' }} />
                             <label class="form-check-label" for="keputusan_dua">
                                 Di Dahulukan
                             </label>
                         </div>
                         <div class="form-check form-switch form-check-custom form-check-solid me-10">
                             <input value="Dirujuk" class="form-check-input h-20px w-30px me-5" type="radio"
                                 name="keputusan" id="keputusan_tiga"
                                 {{ isset($skriningData['keputusan']) && $skriningData['keputusan'] == 'Dirujuk' ? 'checked' : '' }} />
                             <label class="form-check-label" for="keputusan_tiga">
                                 Dirujuk
                             </label>
                         </div>
                     </div>
                 </div>
             </div>
             <!--end::Input group-->


         </div>
         <!--end::Scroll-->
         <!--begin::Actions-->
         <div class="text-center pt-15">
             <a href="{{ route('examinations.index') }}" class="btn btn-sm btn-light-primary">
                 <!--begin::Svg Icon | path: assets/media/icons/duotune/arrows/arr079.svg-->
                 <span class="svg-icon svg-icon-muted svg-icon-2hx">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                         fill="none">
                         <path opacity="0.5"
                             d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                             fill="currentColor" />
                         <path
                             d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                             fill="currentColor" />
                     </svg>
                 </span>
                 <!--end::Svg Icon-->
                 Cancel
             </a>
             <button type="submit" class="btn btn-primary" data-kt-examinations-modal-action="submit">
                 <span class="indicator-label">Submit</span>
                 <span class="indicator-progress">Please wait...
                     <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                 </span>
             </button>
         </div>
         <!--end::Actions-->
     </form>

 </div>
