<div class="card card-custom gutter-b shadow-sm mb-5">
    <div class="card-header bg-light">
        <h3 class="card-title">{{ $section['title'] }}</h3>
    </div>
    <div class="card-body">
        @foreach ($section['fields'] as $key => $field)
            <div class="row mb-5">
                <label class="col-md-3 col-form-label">{!! $field['label'] !!}</label>
                <div class="col-md-9">
                    <div class="row g-5">
                        @foreach ($field['options'] as $option)
                            <div class="col-md-4">
                                <label class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="radio"
                                        name="{{ strtolower($section['title']) }}[{{ $key }}]"
                                        value="{{ $option }}"
                                        {{ isset($psikososial->{strtolower(str_replace(' ', '_', $section['title']))}) &&
                                           isset($psikososial->{strtolower(str_replace(' ', '_', $section['title']))}->$key) &&
                                           $psikososial->{strtolower(str_replace(' ', '_', $section['title']))}->$key == $option ? 'checked' : '' }}>
                                    <span class="form-check-label">{{ $option }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>

                    @if(isset($field['detail_field']))
                        <div class="mt-2" id="{{ $key }}_detail"
                            style="{{ isset($psikososial->{strtolower(str_replace(' ', '_', $section['title']))}) &&
                                     isset($psikososial->{strtolower(str_replace(' ', '_', $section['title']))}->$key) &&
                                     $psikososial->{strtolower(str_replace(' ', '_', $section['title']))}->$key == $field['detail_trigger'] ? '' : 'display: none;' }}">
                            <input type="text" class="form-control" name="{{ $field['detail_field'] }}"
                                placeholder="{{ $field['detail_placeholder'] }}"
                                value="{{ isset($psikososial->{strtolower(str_replace(' ', '_', $section['title']))}) &&
                                         isset($psikososial->{strtolower(str_replace(' ', '_', $section['title']))}->$key) &&
                                         $psikososial->{strtolower(str_replace(' ', '_', $section['title']))}->$key == $field['detail_trigger'] ?
                                         ($psikososial->{$field['detail_field']} ?? '') : '' }}">
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
