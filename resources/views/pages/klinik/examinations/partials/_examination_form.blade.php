<div class="card shadow-sm">
    <div class="card-body">
        <h5 class="card-title mb-4">
            <i class="fas fa-stethoscope me-2"></i>Form Pemeriksaan
        </h5>

        <form id="kt_modal_add_examinations_form" method="POST" class="form"
            action="{{ route('examinations.update', ['examination' => $examination->id]) }}">
            @method('PUT')
            {{ csrf_field() }}

            <div class="row g-3">
                <!-- Health Professional -->
                <div class="col-12">
                    <label class="form-label fw-bold">{{ __('Dokter') }}</label>
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <input type="hidden" name="health_profesional_id"
                        value="{{ $examination->health_profesional_id }}">
                    <p class="form-control-plaintext">
                        @if (isset($examination->health_profesional->user->info))
                            {{ ($examination->health_profesional->user->info->title_prefix != '' ? $examination->health_profesional->user->info->title_prefix . '. ' : '') . $examination->health_profesional->user->name . ($examination->health_profesional->user->info->title_suffix != '' ? ', ' . $examination->health_profesional->user->info->title_suffix : '') }}
                        @else
                            {{ $examination->health_profesional?->user?->name }}
                        @endif
                    </p>
                </div>

                <!-- Subjective -->
                <div class="col-12">
                    <label class="form-label fw-bold">Subjective</label>
                    <textarea name="subjective" class="form-control @error('subjective') is-invalid @enderror" placeholder="Subjective">{{ $examination->subjective }}</textarea>
                    @error('subjective')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Objective -->
                <div class="col-12">
                    <label class="form-label fw-bold">Objective</label>
                    <textarea name="objective" class="form-control @error('objective') is-invalid @enderror" placeholder="Objective">{{ $examination->objective }}</textarea>
                    @error('objective')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Odontogram -->
                @include('pages.klinik.examinations.partials._odontogram')

                <!-- Assessment -->
                <div class="col-12">
                    <label class="form-label fw-bold">Assessment</label>
                    <select id="icdtens" aria-label="{{ __('Select a Diagnosa') }}" data-control="select2"
                        data-placeholder="{{ __('Select a Diagnosa...') }}" class="form-select mb-2">
                    </select>
                    <textarea name="assessment" id="assessment" class="form-control @error('assessment') is-invalid @enderror"
                        placeholder="Assessment">{{ $examination->assessment }}</textarea>
                    @error('assessment')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Plan -->
                <div class="col-12">
                    <label class="form-label fw-bold">{{ __('Plan') }}</label>
                    <select name="plan_id" aria-label="{{ __('Select a Plan') }}" data-control="select2"
                        data-placeholder="{{ __('Select a Plan...') }}" class="form-select">
                        <option value="">{{ __('Select a Plan...') }}</option>
                        @foreach ($plans as $plan)
                            <option value="{{ $plan->id }}"
                                {{ $plan->id === old('plan_id', $examination->plan_id ?? '') ? 'selected' : '' }}>
                                {{ $plan->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    @php
                        $resep = json_decode($examination->resep);
                        $obat = $resep->obat ?? [];
                        $keterangan = $resep->keterangan ?? [];
                        $qty = $resep->qty ?? [];
                        $hasResep = is_array($obat) && count($obat) > 0;

                        // Ambil status pembayaran transaksi terbaru berdasarkan examination_id
                        $latestTransaction = \App\Models\Klinik\Transaction::where('examination_id', $examination->id)
                            ->latest()
                            ->first();
                        $isPaid = $latestTransaction && $latestTransaction->status === 'paid';
                    @endphp

                    @if ($hasResep)
                        <label class="form-label fw-bold">Resep</label>
                        <div id="resepContainer">
                            @foreach ($obat as $key => $value)
                                <div class="row mb-2 align-items-center resep-row">
                                    <div class="col-md-5 col-sm-12 mb-2 mb-md-0">
                                        <select name="resep[obat][]" class="form-select" data-control="select2"
                                            data-placeholder="{{ __('Pilih Obat...') }}">
                                            <option value="">{{ __('Pilih Obat...') }}</option>
                                            @foreach ($drugs as $drug)
                                                <option value="{{ $drug->id }}"
                                                    {{ $drug->id == $value ? 'selected' : '' }}>{{ $drug->name }}
                                                    {{ $drug->kfa_code ? '| KFA-' . $drug->kfa_code : '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 col-sm-8 mb-2 mb-md-0">
                                        <input placeholder="Keterangan" name="resep[keterangan][]" class="form-control"
                                            type="text" value="{{ $keterangan[$key] ?? '' }}">
                                    </div>
                                    <div class="col-md-3 col-sm-3 mb-2 mb-md-0">
                                        <input placeholder="Qty" name="resep[qty][]" class="form-control" type="number"
                                            min="1" value="{{ $qty[$key] ?? '' }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if (!$isPaid)
                            <button type="button" class="btn btn-sm btn-light-primary mt-2" id="tambah_obat">
                                <i class="fas fa-plus me-2"></i>Tambah Obat
                            </button>
                        @endif
                    @endif
                </div>

                <!-- Saran -->
                <div class="col-12">
                    <label class="form-label fw-bold">Saran</label>
                    <textarea name="saran" class="form-control @error('saran') is-invalid @enderror" placeholder="Saran">{{ $examination->saran }}</textarea>
                    @error('saran')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="col-12 text-end">
                    <a href="{{ route('examinations.index') }}" class="btn btn-light me-2">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary" data-kt-examinations-modal-action="submit">
                        <i class="fas fa-save me-2"></i>Submit
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('customscript')
    <script>
        $(document).ready(function() {
            $('#tambah_obat').click(function() {
                var newRow = `
                <div class="row mb-2 align-items-center resep-row">
                    <div class="col-md-5 col-sm-12 mb-2 mb-md-0">
                        <select name="resep[obat][]" class="form-select" data-control="select2" data-placeholder="{{ __('Pilih Obat...') }}">
                            <option value="">{{ __('Pilih Obat...') }}</option>
                            @foreach ($drugs as $drug)
                                <option value="{{ $drug->id }}">{{ $drug->name }} {{ $drug->kfa_code ? '| KFA-' . $drug->kfa_code : '' }}</option>
                            @endforeach
                </select>
            </div>
            <div class="col-md-4 col-sm-8 mb-2 mb-md-0">
                <input placeholder="Keterangan" name="resep[keterangan][]" class="form-control" type="text">
            </div>
            <div class="col-md-2 col-sm-3 mb-2 mb-md-0">
                <input placeholder="Qty" name="resep[qty][]" class="form-control" type="number" min="1">
            </div>
            <div class="col-md-1 col-sm-1">
                <button type="button" class="btn btn-sm btn-icon btn-light-danger remove-resep">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        </div>
`;
                $('#resepContainer').append(newRow);
                $('select[data-control="select2"]').select2();
            });

            $(document).on('click', '.remove-resep', function() {
                $(this).closest('.resep-row').remove();
            });
        });
    </script>
@endpush
