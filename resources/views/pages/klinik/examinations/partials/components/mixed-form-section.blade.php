<div class="card card-custom gutter-b shadow-sm mb-5">
    <div class="card-header bg-light">
        <h3 class="card-title">{{ $section['title'] }}</h3>
    </div>
    <div class="card-body">
        @foreach ($section['fields'] as $key => $field)
            @if ($field['type'] === 'radio_with_detail')
                {{-- Radio with Detail Input --}}
                <div class="row mb-5">
                    <label class="col-md-3 col-form-label">{{ $field['label'] }}</label>
                    <div class="col-md-9">
                        <div class="row g-5">
                            @foreach ($field['options'] as $option)
                                <div class="col-md-4">
                                    <label class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="radio"
                                            name="riwayat_kesehatan[{{ $key }}]"
                                            id="{{ $key }}_{{ strtolower(str_replace(' ', '_', $option)) }}"
                                            value="{{ $option }}"
                                            {{ isset($psikososial->riwayat_kesehatan) && isset($psikososial->riwayat_kesehatan->$key) && $psikososial->riwayat_kesehatan->$key == $option ? 'checked' : '' }}>
                                        <span class="form-check-label">{{ $option }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        @if (isset($field['detail_field']))
                            <div class="mt-2" id="{{ $key }}_detail"
                                style="{{ isset($psikososial->riwayat_kesehatan) && isset($psikososial->riwayat_kesehatan->$key) && $psikososial->riwayat_kesehatan->$key == $field['detail_trigger'] ? '' : 'display: none;' }}">
                                <input type="text" class="form-control" name="{{ $field['detail_field'] }}"
                                    placeholder="{{ $field['detail_placeholder'] }}"
                                    value="{{ isset($psikososial->riwayat_kesehatan) && isset($psikososial->riwayat_kesehatan->$key) && $psikososial->riwayat_kesehatan->$key == $field['detail_trigger'] ? $psikososial->{$field['detail_field']} ?? '' : '' }}">
                            </div>
                        @endif
                    </div>
                </div>
            @elseif($field['type'] === 'select_multiple')
                {{-- Multiple Select Dropdown --}}
                <div class="row mb-5">
                    <label class="col-md-3 col-form-label">{{ $field['label'] }}</label>
                    <div class="col-md-9">
                        <select class="form-select form-select-solid" data-control="select2"
                            data-placeholder="Pilih {{ $field['label'] }}" data-allow-clear="true" multiple="multiple"
                            name="riwayat_kesehatan[{{ $key }}][]" id="{{ $key }}">
                            <option></option>
                            @if ($field['data_source'] === 'personaldiseasehistories')
                                @foreach ($personaldiseasehistories as $disease)
                                    <option value="{{ $disease->code }}"
                                        {{ (is_array($psikososial->riwayat_kesehatan->$key ?? null) &&
                                            in_array($disease->code, $psikososial->riwayat_kesehatan->$key)) ||
                                        ($psikososial->riwayat_kesehatan->$key ?? '') == $disease->code
                                            ? 'selected'
                                            : '' }}>
                                        {{ $disease->name }}
                                    </option>
                                @endforeach
                            @elseif($field['data_source'] === 'familydiseasehistories')
                                @foreach ($familydiseasehistories as $disease)
                                    <option value="{{ $disease->code }}"
                                        {{ (is_array($psikososial->riwayat_kesehatan->$key ?? null) &&
                                            in_array($disease->code, $psikososial->riwayat_kesehatan->$key)) ||
                                        ($psikososial->riwayat_kesehatan->$key ?? '') == $disease->code
                                            ? 'selected'
                                            : '' }}>
                                        {{ $disease->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
