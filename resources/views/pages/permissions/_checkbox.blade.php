<td>
    @php
        $color = [
	        'badge-white',
	        'badge-light-primary',#
	        'badge-light-dark',#
	        'badge-secondary',
	        'badge-light-success',#
	        'badge-light-info',#
	        'badge-light-warning',#
	        'badge-light-danger'#
        ];

        $i = 1;

    @endphp
    @foreach($role as $row)
        <a href="javascript:;" class="text-capitalize badge {{ $color[$row->id]  }} fs-7 m-1">{{ $row->name }}</a>
        @php $i++ @endphp
    @endforeach
</td>
