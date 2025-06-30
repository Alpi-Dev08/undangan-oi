{{-- Komposisi Tubuh --}}
<div class="col-12 mb-4 mt-4">
    <h5 class="text-primary fw-bold mb-3">Komposisi Tubuh</h5>
</div>

{{-- Body Mass Index --}}
<div class="col-6 mb-6">
    <label for="body_mass_index" class="form-label">Body Mass Index (Indeks Massa Tubuh)</label>
    <input id="body_mass_index" name="body_mass_index" type="number" step="0.01"
        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('body_mass_index') is-invalid @enderror"
        placeholder="22.5" value="{{ $vitalityexamination->body_mass_index ?? '' }}" readonly />
    @error('body_mass_index')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

{{-- Ideal Weight --}}
<div class="col-6 mb-6">
    <label for="ideal_weight" class="form-label">Ideal Weight (Berat Badan Ideal) (kg)</label>
    <input id="ideal_weight" name="ideal_weight" type="number" step="0.01"
        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('ideal_weight') is-invalid @enderror"
        placeholder="65.5" value="{{ $vitalityexamination->ideal_weight ?? '' }}" readonly />
    @error('ideal_weight')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

{{-- Body Fat --}}
<div class="col-6 mb-6">
    <label for="body_fat" class="form-label">Body Fat (Lemak Tubuh) (%)</label>
    <input id="body_fat" name="body_fat" type="number" step="0.01"
        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('body_fat') is-invalid @enderror"
        placeholder="15.5" value="{{ $vitalityexamination->body_fat ?? '' }}" />
    @error('body_fat')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

{{-- BMI Conclusion --}}
<div class="col-6 mb-6">
    <label for="bmi_conclusion" class="form-label">BMI Conclusion (Kesimpulan BMI)</label>
    <input id="bmi_conclusion" name="bmi_conclusion" type="text"
        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('bmi_conclusion') is-invalid @enderror"
        placeholder="Normal" value="{{ $vitalityexamination->bmi_conclusion ?? '' }}" readonly />
    @error('bmi_conclusion')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
