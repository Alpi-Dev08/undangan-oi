{{-- Physical Findings Section --}}
<div class="col-12 mb-4">
    <h5 class="text-primary fw-bold mb-3">Temuan Fisik</h5>
</div>

{{-- Head Findings --}}
<div class="col-6 mb-6">
    <label for="head_findings" class="form-label">Temuan Kepala</label>
    <input type="text" id="head_findings" name="head_findings"
        class="form-control form-control-solid border border-gray-300 @error('head_findings') is-invalid @enderror"
        placeholder="Masukkan temuan fisik kepala..." value="{{ $vitalityexamination->head_findings ?? '' }}">
    @error('head_findings')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

{{-- Eye Findings --}}
<div class="col-6 mb-6">
    <label for="eye_findings" class="form-label">Temuan Mata</label>
    <input type="text" id="eye_findings" name="eye_findings"
        class="form-control form-control-solid border border-gray-300 @error('eye_findings') is-invalid @enderror"
        placeholder="Masukkan temuan fisik mata..." value="{{ $vitalityexamination->eye_findings ?? '' }}">
    @error('eye_findings')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

{{-- Ear Findings --}}
<div class="col-6 mb-6">
    <label for="ear_findings" class="form-label">Temuan Telinga</label>
    <input type="text" id="ear_findings" name="ear_findings"
        class="form-control form-control-solid border border-gray-300 @error('ear_findings') is-invalid @enderror"
        placeholder="Masukkan temuan fisik telinga..." value="{{ $vitalityexamination->ear_findings ?? '' }}">
    @error('ear_findings')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

{{-- Nose Findings --}}
<div class="col-6 mb-6">
    <label for="nose_findings" class="form-label">Temuan Hidung</label>
    <input type="text" id="nose_findings" name="nose_findings"
        class="form-control form-control-solid border border-gray-300 @error('nose_findings') is-invalid @enderror"
        placeholder="Masukkan temuan fisik hidung..." value="{{ $vitalityexamination->nose_findings ?? '' }}">
    @error('nose_findings')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

{{-- Throat Findings --}}
<div class="col-6 mb-6">
    <label for="throat_findings" class="form-label">Temuan Tenggorokan</label>
    <input type="text" id="throat_findings" name="throat_findings"
        class="form-control form-control-solid border border-gray-300 @error('throat_findings') is-invalid @enderror"
        placeholder="Masukkan temuan fisik tenggorokan..." value="{{ $vitalityexamination->throat_findings ?? '' }}">
    @error('throat_findings')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

{{-- Chest Findings --}}
<div class="col-6 mb-6">
    <label for="chest_findings" class="form-label">Temuan Dada</label>
    <input type="text" id="chest_findings" name="chest_findings"
        class="form-control form-control-solid border border-gray-300 @error('chest_findings') is-invalid @enderror"
        placeholder="Masukkan temuan fisik dada..." value="{{ $vitalityexamination->chest_findings ?? '' }}">
    @error('chest_findings')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

{{-- Abdomen Findings --}}
<div class="col-6 mb-6">
    <label for="abdomen_findings" class="form-label">Temuan Perut</label>
    <input type="text" id="abdomen_findings" name="abdomen_findings"
        class="form-control form-control-solid border border-gray-300 @error('abdomen_findings') is-invalid @enderror"
        placeholder="Masukkan temuan fisik perut..." value="{{ $vitalityexamination->abdomen_findings ?? '' }}">
    @error('abdomen_findings')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

{{-- Back Findings --}}
<div class="col-6 mb-6">
    <label for="back_findings" class="form-label">Temuan Punggung</label>
    <input type="text" id="back_findings" name="back_findings"
        class="form-control form-control-solid border border-gray-300 @error('back_findings') is-invalid @enderror"
        placeholder="Masukkan temuan fisik punggung..." value="{{ $vitalityexamination->back_findings ?? '' }}">
    @error('back_findings')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
