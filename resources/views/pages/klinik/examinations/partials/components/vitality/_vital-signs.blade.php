{{-- Tanda-tanda Vital --}}
<div class="col-12 mb-4">
    <h5 class="text-primary fw-bold mb-3">Tanda Vital</h5>
</div>

{{-- Blood Pressure --}}
<div class="col-6 mb-6">
    <label for="blood_pressure" class="form-label">Blood Pressure (Tekanan Darah)</label>
    <input id="blood_pressure" name="blood_pressure" type="text"
        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('blood_pressure') is-invalid @enderror"
        placeholder="120/80 mmHg" value="{{ $vitalityexamination->blood_pressure ?? '' }}" />
    @error('blood_pressure')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

{{-- Heart Rate --}}
<div class="col-6 mb-6">
    <label for="heart_rate" class="form-label">Heart Rate (Detak Jantung)</label>
    <input id="heart_rate" name="heart_rate" type="number"
        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('heart_rate') is-invalid @enderror"
        placeholder="80 bpm" value="{{ $vitalityexamination->heart_rate ?? '' }}" />
    @error('heart_rate')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

{{-- Respiratory Rate --}}
<div class="col-6 mb-6">
    <label for="respiratory_rate" class="form-label">Respiratory Rate (Laju Pernapasan)</label>
    <input id="respiratory_rate" name="respiratory_rate" type="number"
        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('respiratory_rate') is-invalid @enderror"
        placeholder="16 /min" value="{{ $vitalityexamination->respiratory_rate ?? '' }}" />
    @error('respiratory_rate')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

{{-- Temperature --}}
<div class="col-6 mb-6">
    <label for="temperature" class="form-label">Temperature (Suhu)</label>
    <input id="temperature" name="temperature" type="number" step="0.1"
        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('temperature') is-invalid @enderror"
        placeholder="36.5 °C" value="{{ $vitalityexamination->temperature ?? '' }}" />
    @error('temperature')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

{{-- Oxygen Saturation --}}
<div class="col-6 mb-6">
    <label for="oxygen_saturation" class="form-label">Oxygen Saturation (Saturasi Oksigen)</label>
    <input id="oxygen_saturation" name="oxygen_saturation" type="number"
        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('oxygen_saturation') is-invalid @enderror"
        placeholder="98 %" value="{{ $vitalityexamination->oxygen_saturation ?? '' }}" />
    @error('oxygen_saturation')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
