 <div class="tab-pane" id="vitality-examination" role="tabpanel" aria-labelledby="all-tab"
     data-kt-timeline-widget-4-blockui="true">
     @if (isset($vitalityexamination->id))
         <form id="kt_modal_add_examinations_form" method="POST" class="form"
             action="{{ route('vitalityexaminations.update', ['vitalityexamination' => $vitalityexamination->id]) }}">
             @method('PUT')
         @else
             <form id="kt_modal_add_examinations_form" method="POST" class="form"
                 action="{{ route('vitalityexaminations.store') }}">
                 @method('POST')
     @endif
     {{ csrf_field() }}
     <!--begin::Scroll-->
     <div class="row">
         <input type="hidden" name="examination_id" value="{{ $examination->id }}">
         <input type="hidden" name="user_id" value="{{ $user->id }}">

         <!--begin::Input group-->
         <div class="col-6 mb-6">
             <label for="blood_pressure" class="form-label">Blood Pressure (Tekanan Darah)</label>
             <input id="blood_pressure" name="blood_pressure" type="text"
                 class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('blood_pressure') is-invalid @enderror"
                 placeholder="Blood Pressure" value="{{ $vitalityexamination->blood_pressure ?? '' }}" />
             @error('blood_pressure')
                 <div class="text-danger">{{ $message }}</div>
             @enderror
         </div>
         <!--end::Input group-->

         <!--begin::Input group-->
         <div class="col-6 mb-6">
             <label for="pulse" class="form-label">Heart Rate (Detak Jantung)</label>
             <input id="heart_rate" name="heart_rate" type="text"
                 class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('heart_rate') is-invalid @enderror"
                 placeholder="Heart Rate" value="{{ $vitalityexamination->heart_rate ?? '' }}" />
             @error('heart_rate')
                 <div class="text-danger">{{ $message }}</div>
             @enderror
         </div>
         <!--end::Input group-->

         <!--begin::Input group-->
         <div class="col-6 mb-6">
             <label for="respiratory_rate" class="form-label">Respiratory Rate (Laju Pernapasan)</label>
             <input id="respiratory_rate" name="respiratory_rate" type="text"
                 class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('respiratory_rate') is-invalid @enderror"
                 placeholder="Respiratory Rate" value="{{ $vitalityexamination->respiratory_rate ?? '' }}" />
             @error('respiratory_rate')
                 <div class="text-danger">{{ $message }}</div>
             @enderror
         </div>
         <!--end::Input group-->

         <!--begin::Input group-->
         <div class="col-6 mb-6">
             <label for="temperature" class="form-label">Temperature (Suhu)</label>
             <input id="temperature" name="temperature" type="text"
                 class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('temperature') is-invalid @enderror"
                 placeholder="Temperature" value="{{ $vitalityexamination->temperature ?? '' }}" />
             @error('temperature')
                 <div class="text-danger">{{ $message }}</div>
             @enderror
         </div>
         <!--end::Input group-->

         <!--begin::Input group-->
         <div class="col-6 mb-6">
             <label for="oxygen_saturation" class="form-label">Oxygen Saturation (Saturasi Oksigen)</label>
             <input id="oxygen_saturation" name="oxygen_saturation" type="text"
                 class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('oxygen_saturation') is-invalid @enderror"
                 placeholder="Oxygen Saturation" value="{{ $vitalityexamination->oxygen_saturation ?? '' }}" />
             @error('oxygen_saturation')
                 <div class="text-danger">{{ $message }}</div>
             @enderror
         </div>
         <!--end::Input group-->

         <!--begin::Input group-->
         <div class="col-6 mb-6">
             <label for="waist_circumferennce" class="form-label">Waist Circumference (Lingkar
                 Pinggang)</label>
             <input id="waist_circumferennce" name="waist_circumferennce" type="number" step=".01"
                 class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('waist_circumferennce') is-invalid @enderror"
                 placeholder="Waist Circumference" value="{{ $vitalityexamination->waist_circumferennce ?? '' }}" />
             @error('waist_circumferennce')
                 <div class="text-danger">{{ $message }}</div>
             @enderror
         </div>
         <!--end::Input group-->

         <!--begin::Input group-->
         <div class="col-6 mb-6">
             <label for="neck_circumference" class="form-label">Neck Circumference (Lingkar Leher)</label>
             <input id="neck_circumference" name="neck_circumference" type="text"
                 class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('neck_circumference') is-invalid @enderror"
                 placeholder="Neck Circumference" value="{{ $vitalityexamination->neck_circumference ?? '' }}" />
             @error('neck_circumference')
                 <div class="text-danger">{{ $message }}</div>
             @enderror
         </div>
         <!--end::Input group-->

         <!--begin::Input group-->
         <div class="col-6 mb-6">
             <label for="arm_circumference" class="form-label">Arm Circumference (Lingkar Lengan)</label>
             <input id="arm_circumference" name="arm_circumference" type="number" step=".01"
                 class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('arm_circumference') is-invalid @enderror"
                 placeholder="Arm Circumference" value="{{ $vitalityexamination->arm_circumference ?? '' }}" />
             @error('arm_circumference')
                 <div class="text-danger">{{ $message }}</div>
             @enderror
         </div>
         <!--end::Input group-->

         <!--begin::Input group-->
         <div class="col-6 mb-6">
             <label for="chest_size" class="form-label">Chest Size (Ukuran Dada)</label>
             <input id="chest_size" name="chest_size" type="number" step=".01"
                 class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('chest_size') is-invalid @enderror"
                 placeholder="Chest Size" value="{{ $vitalityexamination->chest_size ?? '' }}" />
             @error('chest_size')
                 <div class="text-danger">{{ $message }}</div>
             @enderror
         </div>
         <!--end::Input group-->

         <!--begin::Input group-->
         <div class="col-6 mb-6">
             <label for="adbdominal_circumference" class="form-label">Abdominal Circumference (Lingkar
                 Perut)</label>
             <input id="adbdominal_circumference" name="adbdominal_circumference" type="number" step=".01"
                 class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('adbdominal_circumference') is-invalid @enderror"
                 placeholder="Abdominal Circumference"
                 value="{{ $vitalityexamination->adbdominal_circumference ?? '' }}" />
             @error('adbdominal_circumference')
                 <div class="text-danger">{{ $message }}</div>
             @enderror
         </div>
         <!--end::Input group-->

         <!--begin::Input group-->
         <div class="col-6 mb-6">
             <label for="weight" class="form-label">Weight (Berat Badan) (kg)</label>
             <input id="weight" name="weight" type="number" step=".01"
                 class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('weight') is-invalid @enderror"
                 placeholder="Weight" value="{{ $vitalityexamination->weight ?? '' }}" />
             @error('weight')
                 <div class="text-danger">{{ $message }}</div>
             @enderror
         </div>
         <!--end::Input group-->

         <!--begin::Input group-->
         <div class="col-6 mb-6">
             <label for="height" class="form-label">Height (Tinggi Badan) (cm)</label>
             <input id="height" name="height" type="number" step=".01"
                 class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('height') is-invalid @enderror"
                 placeholder="Height" value="{{ $vitalityexamination->height ?? '' }}" />
             @error('height')
                 <div class="text-danger">{{ $message }}</div>
             @enderror
         </div>
         <!--end::Input group-->

         <!--begin::Input group-->
         <div class="col-6 mb-6">
             <label for="body_mass_index" class="form-label">Body Mass Index (Indeks Massa Tubuh)</label>
             <input id="body_mass_index" name="body_mass_index" type="number" step=".01"
                 class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('body_mass_index') is-invalid @enderror"
                 placeholder="Body Mass Index" value="{{ $vitalityexamination->body_mass_index ?? '' }}" />
             @error('body_mass_index')
                 <div class="text-danger">{{ $message }}</div>
             @enderror
         </div>
         <!--end::Input group-->

         <!--begin::Input group-->
         <div class="col-6 mb-6">
             <label for="ideal_weight" class="form-label">Ideal Weight (Berat Badan Ideal) (kg)</label>
             <input id="ideal_weight" name="ideal_weight" type="number" step=".01"
                 class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('ideal_weight') is-invalid @enderror"
                 placeholder="Ideal Weight" value="{{ $vitalityexamination->ideal_weight ?? '' }}" />
             @error('ideal_weight')
                 <div class="text-danger">{{ $message }}</div>
             @enderror
         </div>
         <!--end::Input group-->

         <!--begin::Input group-->
         <div class="col-6 mb-6">
             <label for="body_fat" class="form-label">Body Fat (Lemak Tubuh)</label>
             <input id="body_fat" name="body_fat" type="number" step=".01"
                 class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('body_fat') is-invalid @enderror"
                 placeholder="Body Fat" value="{{ $vitalityexamination->body_fat ?? '' }}" />
             @error('body_fat')
                 <div class="text-danger">{{ $message }}</div>
             @enderror
         </div>
         <!--end::Input group-->
         <!--begin::Input group-->
         <div class="col-6 mb-6">
             <label for="bmi_conclusion" class="form-label">BMI Conclusion (Kesimpulan BMI)</label>
             <input id="bmi_conclusion" name="bmi_conclusion" type="text"
                 class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('bmi_conclusion') is-invalid @enderror"
                 placeholder="BMI Conclusion" value="{{ $vitalityexamination->bmi_conclusion ?? '' }}" />
             @error('bmi_conclusion')
                 <div class="text-danger">{{ $message }}</div>
             @enderror
         </div>
         <!--end::Input group-->

         <!--begin::Input group-->
         <div class="col-12 mb-6">
             <label for="others" class="form-label">Others (Lainnya)</label>
             <input id="others" name="others" type="text"
                 class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('others') is-invalid @enderror"
                 placeholder="Others" value="{{ $vitalityexamination->others ?? '' }}" />
             @error('others')
                 <div class="text-danger">{{ $message }}</div>
             @enderror
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
