<div class="card card-custom gutter-b shadow-sm mb-5">
    <div class="card-header bg-light">
        <h3 class="card-title">{{ $section['title'] }}</h3>
    </div>
    <div class="card-body">
        <div class="row g-5">
            @foreach ($section['options'] as $index => $option)
                <div class="col-md-3">
                    <label class="form-check form-check-custom form-check-solid">
                        <input class="form-check-input" type="radio" name="{{ $section['name'] }}"
                            value="{{ $option }}"
                            {{ isset($psikososial->{$section['name']}) && $psikososial->{$section['name']} == $option ? 'checked' : '' }}>
                        <span class="form-check-label">{{ $option }}</span>
                    </label>
                </div>
            @endforeach

            @if(isset($section['other_field']))
                <div class="col-md-6" id="{{ $section['other_field'] }}-text"
                    style="display: {{ isset($psikososial->{$section['name']}) && $psikososial->{$section['name']} == $section['other_trigger'] ? 'block' : 'none' }}">
                    <div class="input-group">
                        <span class="input-group-text">{{ $section['other_trigger'] }}:</span>
                        <input type="text" class="form-control" name="{{ $section['other_field'] }}"
                            value="{{ isset($psikososial->{$section['name']}) && $psikososial->{$section['name']} == $section['other_trigger'] ? ($psikososial->{$section['other_field']} ?? '') : '' }}">
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
