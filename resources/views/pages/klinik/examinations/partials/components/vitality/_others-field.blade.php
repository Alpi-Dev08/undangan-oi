{{-- Field Lainnya --}}
<div class="col-12 mb-4 mt-4">
    <h5 class="text-primary fw-bold mb-3">Informasi Tambahan</h5>
</div>

<div class="col-12 mb-6">
    <label for="others" class="form-label">Others (Lainnya)</label>
    <textarea id="others" name="others" rows="3"
        class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0 @error('others') is-invalid @enderror"
        placeholder="Catatan tambahan pemeriksaan vitality...">{{ $vitalityexamination->others ?? '' }}</textarea>
    @error('others')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
