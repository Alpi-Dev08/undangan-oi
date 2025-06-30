{{-- Pengukuran Tubuh --}}
<div class="col-12 mb-4 mt-4">
    <h5 class="text-primary fw-bold mb-3">Pengukuran Tubuh</h5>
</div>

{{-- Weight --}}
<div class="col-6 mb-6">
    <label for="weight" class="form-label">Weight (Berat Badan) (kg)</label>
    <input id="weight" name="weight" type="number" step="0.01"
        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('weight') is-invalid @enderror"
        placeholder="70.5" value="{{ $vitalityexamination->weight ?? '' }}"
        x-on:input="calculateBMI()" />
    @error('weight')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

{{-- Height --}}
<div class="col-6 mb-6">
    <label for="height" class="form-label">Height (Tinggi Badan) (cm)</label>
    <input id="height" name="height" type="number" step="0.01"
        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('height') is-invalid @enderror"
        placeholder="170" value="{{ $vitalityexamination->height ?? '' }}"
        x-on:input="calculateBMI()" />
    @error('height')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

{{-- Waist Circumference --}}
<div class="col-6 mb-6">
    <label for="waist_circumferennce" class="form-label">Waist Circumference (Lingkar Pinggang)</label>
    <input id="waist_circumferennce" name="waist_circumferennce" type="number" step="0.01"
        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('waist_circumferennce') is-invalid @enderror"
        placeholder="80.5 cm" value="{{ $vitalityexamination->waist_circumferennce ?? '' }}" />
    @error('waist_circumferennce')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

{{-- Neck Circumference --}}
<div class="col-6 mb-6">
    <label for="neck_circumference" class="form-label">Neck Circumference (Lingkar Leher)</label>
    <input id="neck_circumference" name="neck_circumference" type="number" step="0.01"
        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('neck_circumference') is-invalid @enderror"
        placeholder="35.5 cm" value="{{ $vitalityexamination->neck_circumference ?? '' }}" />
    @error('neck_circumference')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

{{-- Arm Circumference --}}
<div class="col-6 mb-6">
    <label for="arm_circumference" class="form-label">Arm Circumference (Lingkar Lengan)</label>
    <input id="arm_circumference" name="arm_circumference" type="number" step="0.01"
        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('arm_circumference') is-invalid @enderror"
        placeholder="30.5 cm" value="{{ $vitalityexamination->arm_circumference ?? '' }}" />
    @error('arm_circumference')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

{{-- Chest Size --}}
<div class="col-6 mb-6">
    <label for="chest_size" class="form-label">Chest Size (Ukuran Dada)</label>
    <input id="chest_size" name="chest_size" type="number" step="0.01"
        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('chest_size') is-invalid @enderror"
        placeholder="95.5 cm" value="{{ $vitalityexamination->chest_size ?? '' }}" />
    @error('chest_size')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

{{-- Abdominal Circumference --}}
<div class="col-6 mb-6">
    <label for="adbdominal_circumference" class="form-label">Abdominal Circumference (Lingkar Perut)</label>
    <input id="adbdominal_circumference" name="adbdominal_circumference" type="number" step="0.01"
        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('adbdominal_circumference') is-invalid @enderror"
        placeholder="85.5 cm" value="{{ $vitalityexamination->adbdominal_circumference ?? '' }}" />
    @error('adbdominal_circumference')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
