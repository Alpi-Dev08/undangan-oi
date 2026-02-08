<x-base-layout>
    {{-- Alert untuk pesan flash --}}
    @if (session('warning'))
        <div class="alert alert-warning alert-dismissible fade show mb-6" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-6" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Welcome Section --}}
    <div class="row mb-6">
        <div class="col-12">
            <div class="card bg-gradient-primary text-info">
                <div class="card-body p-8">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h1 class="text-info mb-2">Selamat Datang, {{ $user->name }}!</h1>
                            <p class="text-info-75 mb-0 fs-5">Dashboard Undangan Online Indonesia</p>
                            <small class="text-info-50">{{ now()->format('l, d F Y - H:i') }} WIB</small>
                        </div>
                        <div class="text-end">
                            <i class="fas fa-user fa-3x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (Auth::user()->hasRole(['admin', 'administrator', 'dokter']))
       
        {{-- Toast notifications --}}
        @if (session('error'))
            @push('customscript')
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        if (typeof toastr !== 'undefined') {
                            toastr.error("{{ session('error') }}", "Error", {
                                timeOut: 5000,
                                closeButton: true,
                                progressBar: true
                            });
                        }
                    });
                </script>
            @endpush
        @endif

        @if (session('success'))
            @push('customscript')
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        if (typeof toastr !== 'undefined') {
                            toastr.success("{{ session('success') }}", "Berhasil", {
                                timeOut: 5000,
                                closeButton: true,
                                progressBar: true
                            });
                        }
                    });
                </script>
            @endpush
        @endif
    @else
        {{-- Non-admin view --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center p-10">
                        <i class="fas fa-user-shield fa-4x text-muted mb-5"></i>
                        <h3 class="text-gray-800 mb-3">Akses Terbatas</h3>
                        <p class="text-gray-600 fs-5">Anda tidak memiliki akses untuk melihat dashboard administrator.
                        </p>
                        <p class="text-gray-500">Silakan hubungi administrator untuk informasi lebih lanjut.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-base-layout>
