<div class="card card-custom gutter-b shadow-sm mb-5">
    <div class="card-header bg-light">
        <h3 class="card-title">{{ $section['title'] }}</h3>
    </div>
    <div class="card-body">
        @foreach ($section['fields'] as $key => $field)
            <div class="row mb-5">
                <label class="col-md-3 col-form-label">{{ $field['label'] }}</label>
                <div class="col-md-9">
                    <div class="row g-5">
                        @foreach ($field['options'] as $index => $option)
                            <div class="col-md-4">
                                <label class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="radio"
                                        name="{{ $key }}"
                                        id="{{ $key }}_{{ $index }}"
                                        value="{{ $option }}"
                                        {{ isset($psikososial->$key) && $psikososial->$key == $option ? 'checked' : '' }}>
                                    <span class="form-check-label">{{ $option }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
