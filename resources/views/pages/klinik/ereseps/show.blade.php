<x-base-layout>
    <div class="card card-xxl-stretch mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                Detail E-resep ID: {{ $eresep->id }}
            </h3>
        </div>
        <div class="card-body pt-6">
            <p><strong>ID:</strong> {{ $eresep->id }}</p>
            <p><strong>Examination ID:</strong> {{ $eresep->examination_id }}</p>
            <p><strong>Eresep Number:</strong> {{ $eresep->eresep_number }}</p>

            <a href="{{ route('ereseps.index') }}" class="btn btn-secondary">Kembali ke Daftar E-resep</a>
        </div>
    </div>
</x-base-layout>
