<div class="tooth-container">
    <label class="col-form-label fw-bold fs-6">{{ $tooth }}</label>
    <div>
        <img src="{{ asset('images/gigi.jpg') }}" alt="Gambar Odontogram {{ $tooth }}" class="img-fluid mb-2 custom-img" style="max-width: 40px;">
    </div>
    <div class="d-flex flex-column align-items-center">
        <div class="input-group input-group-solid has-validation mb-2" style="width: 100%;">
            <select name="odontogram_symbol_{{ $tooth }}" aria-label="{{ __('Odontogram Code') }}" data-control="select2" data-placeholder="{{ __('Select...') }}" class="form-select form-select-solid form-select-sm">
                <option value="">{{ __('Select...') }}</option>
                @foreach($odontogramsymbols as $odontogramsymbol)
                    <option value="{{ $odontogramsymbol->id }}">{{ $odontogramsymbol->code }}</option>
                @endforeach
            </select>
        </div>
        <div style="width: 100%;">
            <input type="text" name="keterangan_{{ $tooth }}" class="form-control form-control-solid form-control-sm mt-2" placeholder="Ket.">
        </div>
    </div>
</div>
