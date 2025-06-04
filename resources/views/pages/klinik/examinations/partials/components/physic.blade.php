@php
    $vitalSigns = [
        ['label' => 'Weight', 'value' => $examination->vitality->weight ?? '-', 'unit' => 'Kg'],
        ['label' => 'Height', 'value' => $examination->vitality->height ?? '-', 'unit' => 'cm'],
        ['label' => 'Body Mass Index', 'value' => $examination->vitality->body_mass_index ?? '-', 'unit' => ''],
        ['label' => 'Ideal Weight', 'value' => $examination->vitality->ideal_weight ?? '-', 'unit' => 'Kg'],
        ['label' => 'Body Fat', 'value' => $examination->vitality->body_fat ?? '-', 'unit' => ''],
        ['label' => 'BMI Conclusion', 'value' => $examination->vitality->bmi_conclusion ?? '-', 'unit' => ''],
        ['label' => 'Arm Circumference', 'value' => $examination->vitality->arm_circumference ?? '-', 'unit' => ''],
        [
            'label' => 'Abdominal Circumference',
            'value' => $examination->vitality->abdominal_circumference ?? '-',
            'unit' => '',
        ],
    ];

    $vitalSigns2 = [
        ['label' => 'Blood Pressure', 'value' => $examination->vitality->blood_pressure ?? '-', 'unit' => ''],
        ['label' => 'Heart Rate', 'value' => $examination->vitality->heart_rate ?? '-', 'unit' => ''],
        ['label' => 'Respiratory Rate', 'value' => $examination->vitality->respiratory_rate ?? '-', 'unit' => ''],
        ['label' => 'Temperature', 'value' => $examination->vitality->temperature ?? '-', 'unit' => ''],
        ['label' => 'Oxygen Saturation', 'value' => $examination->vitality->oxygen_saturation ?? '-', 'unit' => ''],
        ['label' => 'Waist Circumference', 'value' => $examination->vitality->waist_circumference ?? '-', 'unit' => ''],
        ['label' => 'Neck Circumference', 'value' => $examination->vitality->neck_circumference ?? '-', 'unit' => ''],
        ['label' => 'Chest Size', 'value' => $examination->vitality->chest_size ?? '-', 'unit' => ''],
    ];

    $dentalCodes = [
        'C' => 'Karang Gigi',
        'X' => 'Gigi Tanggal',
        'D' => 'Gigi Berlubang',
        'F' => 'Tambalan Gigi',
        'MG' => 'Gigi Miring',
        'B' => 'Bridge',
        'PR' => 'Prothesa',
        'GP' => 'Gangren Pulpa',
        'CR' => 'Crown',
        'FR' => 'Fracture',
        'R' => 'Radix',
    ];
@endphp

<div class="tab-pane" id="physical" role="tabpanel" aria-labelledby="all-tab" data-kt-timeline-widget-4-blockui="true">
    <!--begin::details View-->
    <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
        <!--begin::Alert-->
        <div
            class="alert alert-dismissible bg-light-primary border border-primary d-flex flex-column flex-sm-row p-5 mb-10 row">
            <!--begin::Wrapper-->
            <div class="row col-12 pe-0 pe-sm-10">
                <!--begin::Title-->
                <h5 class="mb-1">Jenis Pemeriksaan</h5>
                <!--end::Title-->
                <div class="col-12">{{ $examination->service_category->name }}
                    <ul class="row">
                        @foreach (service_examination($examination->id) as $service)
                            <li class="col-4">{{ $service->service->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <!--end::Wrapper-->

            <div class="row col-12 pe-0 pe-sm-10">
                <h5 class="mb-1">Vital Sign & BMI</h5>
                <div class="row col-12">
                    <div class="row col-6">
                        @foreach ($vitalSigns as $vital)
                            <div class="col-12 row">
                                <div class="col-4">{{ $vital['label'] }}</div>
                                <div class="col-8">: {{ $vital['value'] }} {{ $vital['unit'] }}</div>
                            </div>
                        @endforeach
                        <div class="col-12">&nbsp;</div>
                    </div>

                    <div class="row col-6">
                        @foreach ($vitalSigns2 as $vital)
                            <div class="col-12 row">
                                <div class="col-4">{{ $vital['label'] }}</div>
                                <div class="col-8">: {{ $vital['value'] }} {{ $vital['unit'] }}</div>
                            </div>
                            @if ($loop->index == 4)
                                <div class="col-12">&nbsp;</div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!--end::Alert-->

        @if (isset($physicalexamination->id))
            <form id="kt_modal_add_examinations_form" method="POST" class="form"
                action="{{ route('physicalexaminations.update', ['physicalexamination' => $physicalexamination->id]) }}">
                @method('PUT')
                @csrf
            @else
                <form id="kt_modal_add_examinations_form" method="POST" class="form"
                    action="{{ route('physicalexaminations.store') }}">
                    @method('POST')
                    @csrf
        @endif

        <input type="hidden" name="examination_id" value="{{ $examination->id }}">

        @foreach ($physicalscategories as $physicalscategory)
            <h2 class="font-bold">{{ $physicalscategory->name }}</h2>
            <ol style="margin-left:-10px">
                @foreach (physicals($physicalscategory->id) as $physicals)
                    <li class="fw-normal text-base mb-6">
                        <div class="row">
                            <div class="col-4">
                                {{ $physicals->name }}
                                <input type="hidden" name="physical[{{ $physicals->id }}]">
                            </div>
                            <div class="col-8">
                                @php
                                    $options = json_decode($physicals->options);
                                    $option = [];
                                    if (isset($physicalexamination->id)) {
                                        $option = json_decode($physicalexamination->physical_value, true);
                                    }
                                @endphp

                                <div class="d-flex gap-3 flex-row flex-row-fluid justify-content-between w-100">
                                    @if (isset($options->radio))
                                        @foreach ($options->radio as $radio)
                                            @php
                                                $r = [];
                                                if (isset($option[$physicals->id]['radio'])) {
                                                    $r = $option[$physicals->id]['radio'];
                                                }

                                                $isChecked =
                                                    in_array($radio->id, $r) ||
                                                    in_array($radio->id, ['normal', 'good', 'no']);
                                            @endphp

                                            <div class="form-check form-check-custom form-check-solid w-200px">
                                                <input class="form-check-input" type="radio"
                                                    {{ $isChecked ? 'checked' : '' }}
                                                    name="physical[{{ $physicals->id }}][radio][]"
                                                    value="{{ $radio->id }}"
                                                    id="radio-{{ $physicals->id }}-{{ $radio->id }}" />
                                                <label class="form-check-label"
                                                    for="radio-{{ $physicals->id }}-{{ $radio->id }}">
                                                    {{ $radio->value }}
                                                </label>
                                            </div>
                                        @endforeach
                                    @endif

                                    @if (isset($options->additional))
                                        @foreach ($options->additional as $additional)
                                            @php
                                                $adt = [];
                                                if (isset($option[$physicals->id]['additional'])) {
                                                    $adt = $option[$physicals->id]['additional'];
                                                }
                                            @endphp

                                            @if ($additional->type == 'text')
                                                <input type="text" value="{{ $adt[$additional->name] ?? '' }}"
                                                    name="physical[{{ $physicals->id }}][additional][{{ $additional->name }}]"
                                                    class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                                                    placeholder="{{ ucwords($additional->name) }}" />
                                            @endif
                                        @endforeach
                                    @endif
                                </div>

                                @if ($physicals->id == 65)
                                    <!--begin::Alert-->
                                    <div
                                        class="alert alert-dismissible bg-light-info border border-info d-flex flex-column flex-sm-row p-5 mb-10 mt-10">
                                        <!--begin::Wrapper-->
                                        <div class="d-flex flex-column pe-0 pe-sm-10 w-100">
                                            <!--begin::Title-->
                                            <h5 class="mb-1">Keterangan</h5>
                                            <!--end::Title-->
                                            <div class="col-10 row w-100">
                                                @foreach ($dentalCodes as $code => $description)
                                                    <span class="col-2">{{ $code }}:
                                                        {{ $description }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
                                    <!--end::Alert-->
                                @endif
                            </div>
                        </div>
                    </li>
                @endforeach
            </ol>
        @endforeach

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

            <button type="submit" class="btn btn-primary" name="selesai" value="1"
                data-kt-examinations-modal-action="submit">
                <span class="indicator-label">Finish</span>
                <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button>

            <button type="submit" class="btn btn-info" name="continue" value="1"
                data-kt-examinations-modal-action="submit">
                <span class="indicator-label">Save</span>
                <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button>
        </div>
        <!--end::Actions-->
        </form>
    </div>
    <!--end::details View-->
</div>
