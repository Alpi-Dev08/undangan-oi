{{-- ID Card Section --}}
<div class="row mb-6">
    <label class="col-lg-4 required col-form-label fw-bold fs-6">{{ __('ID Card') }}</label>

    <div class="col-lg-8">
        <div class="row">
            {{-- Card Type --}}
            <div class="col-lg-4 fv-row">
                <select id="card_type_id"
                        name="card_type_id"
                        aria-label="{{ __('Select a Card Type') }}"
                        data-control="select2"
                        data-placeholder="{{ __('Select a Card...') }}"
                        class="form-select form-select-solid form-select-lg fw-bold"
                        x-model="cardType">
                    @foreach($cards as $card)
                        <option value="{{ $card->id }}" {{ isset($info) && $info->card_type_id == $card->id ? 'selected' : '' }}>{{ $card->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Card Number --}}
            <div class="col-lg-8 fv-row">
                <input type="text"
                       required
                       name="card_number"
                       id="card_number"
                       class="form-control form-control-lg form-control-solid border border-gray-300"
                       placeholder="{{ __('Card Number') }}"
                       x-model="cardNumber"
                       value="{{ isset($info) ? $info->card_number : '' }}"/>
                <input type="hidden" name="his_number" id="his_number" value="{{ isset($info) ? $info->his_number : '' }}"/>
                <div id="error-message" class="text-danger" style="display: none;">
                    {{ __('Card Number is required.') }}
                </div>
            </div>
        </div>
    </div>
</div>
