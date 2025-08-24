<div class="card-header position-relative py-0 border-bottom-1">
    <h3 class="card-title text-gray-800 fw-bold">
        {{ __('Pilih Jenis Layanan') }}
    </h3>

    <ul class="nav nav-stretch nav-pills nav-pills-custom d-flex mt-4">
        @include('pages.klinik.examinations.partials._nav-item', [
            'id' => 'user',
            'title' => 'Patient Profile',
            'active' => false
        ])

        @include('pages.klinik.examinations.partials._nav-item', [
            'id' => 'medicalrecord',
            'title' => 'Medical Record',
            'active' => false
        ])

        @include('pages.klinik.examinations.partials._nav-item', [
            'id' => 'examination',
            'title' => 'Services',
            'active' => true
        ])
    </ul>
</div>
