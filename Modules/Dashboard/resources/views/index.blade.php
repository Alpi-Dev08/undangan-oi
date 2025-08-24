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
                            <p class="text-info-75 mb-0 fs-5">Dashboard Sistem Informasi Klinik</p>
                            <small class="text-info-50">{{ now()->format('l, d F Y - H:i') }} WIB</small>
                        </div>
                        <div class="text-end">
                            <i class="fas fa-user-md fa-3x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (Auth::user()->hasRole(['admin', 'administrator', 'dokter']))
        {{-- Quick Stats Cards --}}
        <div class="row g-5 mb-6" x-data="dashboardStats()">
            {{-- Row 1: Total Pasien & Pasien Baru --}}
            <div class="col-xl-6 col-lg-6 col-md-12">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="card card-flush h-100 hover-elevate-up">
                            <div class="card-body d-flex align-items-center p-6">
                                <div class="symbol symbol-45px me-4">
                                    <div class="symbol-label bg-light-primary">
                                        <i class="fas fa-users text-primary fs-2"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="text-gray-400 fw-semibold d-block fs-7">Total Pasien</span>
                                    <span class="text-gray-800 fw-bold d-block fs-2" x-text="stats.patients">-</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card card-flush h-100 hover-elevate-up">
                            <div class="card-body d-flex align-items-center p-6">
                                <div class="symbol symbol-45px me-4">
                                    <div class="symbol-label bg-light-success">
                                        <i class="fas fa-user-plus text-success fs-2"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="text-gray-400 fw-semibold d-block fs-7">Pasien Baru</span>
                                    <span class="text-gray-800 fw-bold d-block fs-2"
                                        x-text="stats.new_patients">-</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Row 2: Pemeriksaan & Antrian --}}
            <div class="col-xl-6 col-lg-6 col-md-12">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="card card-flush h-100 hover-elevate-up">
                            <div class="card-body d-flex align-items-center p-6">
                                <div class="symbol symbol-45px me-4">
                                    <div class="symbol-label bg-light-info">
                                        <i class="fas fa-stethoscope text-info fs-2"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="text-gray-400 fw-semibold d-block fs-7">Pemeriksaan</span>
                                    <span class="text-gray-800 fw-bold d-block fs-2"
                                        x-text="stats.examinations">-</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card card-flush h-100 hover-elevate-up">
                            <div class="card-body d-flex align-items-center p-6">
                                <div class="symbol symbol-45px me-4">
                                    <div class="symbol-label bg-light-warning">
                                        <i class="fas fa-calendar-check text-warning fs-2"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="text-gray-400 fw-semibold d-block fs-7">Antrian Aktif</span>
                                    <span class="text-gray-800 fw-bold d-block fs-2" x-text="stats.queue">-</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Row 3: Pending Payment (Full Width) --}}
            <div class="col-6">
                <div class="card card-flush h-100 hover-elevate-up bg-gradient-warning">
                    <div class="card-body d-flex align-items-center justify-content-center p-6">
                        <div class="symbol symbol-50px me-5">
                            <div class="symbol-label bg-white bg-opacity-20">
                                <i class="fas fa-clock text-warning fs-1"></i>
                            </div>
                        </div>
                        <div class="text-center">
                            <span class="text-warning fw-semibold d-block fs-6 opacity-75">Pending Payment Hari
                                Ini</span>
                            <span class="text-warning fw-bold d-block fs-1"
                                x-text="formatCurrency(stats.pending_payment)">-</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Row 4: Pendapatan (Full Width) --}}
            <div class="col-6">
                <div class="card card-flush h-100 hover-elevate-up bg-gradient-primary">
                    <div class="card-body d-flex align-items-center justify-content-center p-6">
                        <div class="symbol symbol-50px me-5">
                            <div class="symbol-label bg-white bg-opacity-20">
                                <i class="fas fa-money-bill-wave text-primary fs-1"></i>
                            </div>
                        </div>
                        <div class="text-center">
                            <span class="text-primary fw-semibold d-block fs-6 opacity-75">Pendapatan Hari Ini</span>
                            <span class="text-primary fw-bold d-block fs-1"
                                x-text="formatCurrency(stats.revenue)">-</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-5">
            {{-- Get Up and Go Test Form --}}
            <div class="col-xl-8">
                <div class="card card-flush h-xl-100 shadow-sm">
                    <div class="card-header pt-7 border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-40px me-4">
                                <div class="symbol-label bg-light-primary">
                                    <i class="fas fa-walking text-primary fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h3 class="card-title align-items-start flex-column mb-0">
                                    <span class="card-label fw-bold text-dark fs-3">Formulir Skala Get Up and Go
                                        Test</span>
                                    <span class="text-muted mt-1 fw-semibold fs-7">Evaluasi risiko jatuh pasien dengan
                                        metode standar</span>
                                </h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-body pt-6" x-data="getUpGoTest">
                        <form id="gotest" method="POST" class="form" action="{{ route('patients.pretest') }}">
                            @csrf

                            {{-- Kriteria 1 --}}
                            <div class="mb-8">
                                <div class="bg-light-primary rounded p-6">
                                    <div class="d-flex align-items-start">
                                        <div class="symbol symbol-30px me-4 mt-1">
                                            <div class="symbol-label bg-primary">
                                                <span class="text-white fw-bold fs-6">1</span>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <label class="form-label fw-bold fs-6 mb-3">Keseimbangan Pasien</label>
                                            <p class="text-gray-700 fs-6 mb-4">Apakah pasien tampak tidak seimbang atau
                                                menggunakan alat bantu saat berdiri atau berjalan?</p>

                                            <div class="form-check form-switch form-check-custom form-check-solid">
                                                <input class="form-check-input h-20px w-40px" type="checkbox"
                                                    value="ya" name="kriteria_satu" id="kriteria_satu"
                                                    x-model="criteria.one" @change="handleCriteriaChange()" />
                                                <label class="form-check-label fw-semibold ms-3" for="kriteria_satu">
                                                    <span
                                                        x-text="criteria.one ? 'Ya, pasien tidak seimbang' : 'Tidak, pasien seimbang'"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Kriteria 2 --}}
                            <div class="mb-8">
                                <div class="bg-light-info rounded p-6">
                                    <div class="d-flex align-items-start">
                                        <div class="symbol symbol-30px me-4 mt-1">
                                            <div class="symbol-label bg-info">
                                                <span class="text-white fw-bold fs-6">2</span>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <label class="form-label fw-bold fs-6 mb-3">Penggunaan Bantuan</label>
                                            <p class="text-gray-700 fs-6 mb-4">Apakah pasien memegang benda atau
                                                menggunakan alat bantu untuk berjalan?</p>

                                            <div class="form-check form-switch form-check-custom form-check-solid">
                                                <input class="form-check-input h-20px w-40px" type="checkbox"
                                                    value="ya" name="kriteria_dua" id="kriteria_dua"
                                                    x-model="criteria.two" @change="handleCriteriaChange()" />
                                                <label class="form-check-label fw-semibold ms-3" for="kriteria_dua">
                                                    <span
                                                        x-text="criteria.two ? 'Ya, menggunakan bantuan' : 'Tidak, tidak menggunakan bantuan'"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Hidden inputs --}}
                            <input type="hidden" name="interpretasi" x-model="result.interpretation">
                            <input type="hidden" name="tindakan" x-model="result.action">

                            {{-- Hasil Evaluasi --}}
                            <div class="border border-dashed border-gray-300 rounded p-6 mb-6"
                                x-bind:class="{
                                    'bg-light-success border-success': result.severity === 'success',
                                    'bg-light-warning border-warning': result.severity === 'warning',
                                    'bg-light-danger border-danger': result.severity === 'danger',
                                    'bg-light-secondary border-secondary': result.severity === 'secondary'
                                }">
                                <div class="d-flex align-items-start">
                                    <div class="symbol symbol-40px me-4">
                                        <div class="symbol-label"
                                            x-bind:class="{
                                                'bg-success': result.severity === 'success',
                                                'bg-warning': result.severity === 'warning',
                                                'bg-danger': result.severity === 'danger',
                                                'bg-secondary': result.severity === 'secondary'
                                            }">
                                            <i class="fas fa-clipboard-check text-white fs-5"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h4 class="fw-bold mb-3">Hasil Evaluasi Risiko Jatuh</h4>
                                        <div class="mb-3">
                                            <span class="text-gray-600 fs-6">Interpretasi: </span>
                                            <span class="fw-bold fs-6"
                                                x-bind:class="{
                                                    'text-success': result.severity === 'success',
                                                    'text-warning': result.severity === 'warning',
                                                    'text-danger': result.severity === 'danger',
                                                    'text-secondary': result.severity === 'secondary'
                                                }"
                                                x-text="result.interpretation"></span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600 fs-6">Tindakan yang Diperlukan: </span>
                                            <span class="fw-semibold fs-6 text-gray-800"
                                                x-text="result.action"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary btn-lg" id="kt_assessment_submit"
                                    x-bind:disabled="result.severity === 'secondary'">
                                    <span class="indicator-label">
                                        <i class="fas fa-save me-2"></i>Simpan Hasil Evaluasi
                                    </span>
                                    <span class="indicator-progress">
                                        <span class="spinner-border spinner-border-sm align-middle me-2"></span>
                                        Menyimpan...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Satu Sehat Integration --}}
            <div class="col-xl-4">
                <div class="row g-5">
                    {{-- Satu Sehat Card --}}
                    <div class="col-12">
                        <div class="card card-flush h-100 shadow-sm">
                            <div class="card-body d-flex flex-column p-8 text-center">
                                <div class="mb-6">
                                    <img src="{{ asset('assets/media/illustrations/satusehat.png') }}"
                                        class="mw-100 mh-150px mx-auto" alt="Satu Sehat Logo">
                                </div>

                                <h3 class="text-dark mb-4 fw-bold">Verifikasi Satu Sehat Mobile</h3>

                                <div class="fs-6 text-gray-600 mb-6 text-start">
                                    <ul class="list-unstyled">
                                        <li class="d-flex align-items-center mb-2">
                                            <i class="fas fa-check text-success me-3"></i>
                                            <span>Integrasi dengan sistem nasional</span>
                                        </li>
                                        <li class="d-flex align-items-center mb-2">
                                            <i class="fas fa-shield-alt text-primary me-3"></i>
                                            <span>Keamanan data terjamin</span>
                                        </li>
                                        <li class="d-flex align-items-center">
                                            <i class="fas fa-sync text-info me-3"></i>
                                            <span>Sinkronisasi real-time</span>
                                        </li>
                                    </ul>
                                </div>

                                @if (isset($kyc_iframe))
                                    <a href="{{ route('kycurl') }}" class="btn btn-primary btn-lg w-100"
                                        target="_blank">
                                        <i class="fas fa-external-link-alt me-2"></i>
                                        Verifikasi Sekarang
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Quick Actions --}}
                    <div class="col-12">
                        <div class="card card-flush shadow-sm">
                            <div class="card-header">
                                <h3 class="card-title fw-bold">Aksi Cepat</h3>
                            </div>
                            <div class="card-body p-6">
                                <div class="d-grid gap-3">
                                    <a href="{{ route('patients.create') }}" class="btn btn-light-primary">
                                        <i class="fas fa-user-plus me-2"></i>Daftar Pasien Baru
                                    </a>
                                    <a href="{{ route('examinations.index') }}" class="btn btn-light-success">
                                        <i class="fas fa-stethoscope me-2"></i>Pemeriksaan
                                    </a>
                                    <a href="{{ route('transactions.index') }}" class="btn btn-light-warning">
                                        <i class="fas fa-receipt me-2"></i>Transaksi
                                    </a>
                                    <a href="#" class="btn btn-light-info" disabled>
                                        <i class="fas fa-chart-bar me-2"></i>Lihat Laporan
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @push('customscript')
            <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
            <script>
                // Pastikan Alpine.js sudah loaded
                document.addEventListener('alpine:init', () => {
                    // Update bagian Alpine.js component untuk dashboard stats
                    Alpine.data('dashboardStats', () => ({
                        stats: {
                            patients: 0,
                            new_patients: 0,
                            examinations: 0,
                            queue: 0,
                            revenue: 0,
                            pending_payment: 0
                        },
                        dailyStats: [],
                        monthlyStats: [],
                        comprehensiveStats: null,
                        loading: false,

                        init() {
                            this.loadStats();
                            this.loadDailyStats();
                            this.loadMonthlyStats();
                            this.loadComprehensiveStats();
                        },

                        async loadStats() {
                            try {
                                this.loading = true;
                                const response = await fetch('{{ route('dashboard.stats') }}');
                                const result = await response.json();

                                if (result.success) {
                                    this.stats = result.data;
                                } else {
                                    console.error('Failed to load stats:', result.message);
                                    toastr.error('Gagal memuat statistik dashboard');
                                }
                            } catch (error) {
                                console.error('Error loading stats:', error);
                                toastr.error('Terjadi kesalahan saat memuat statistik');
                            } finally {
                                this.loading = false;
                            }
                        },

                        async loadDailyStats() {
                            try {
                                const response = await fetch(
                                    '{{ route('dashboard.stats.daily-patients') }}');
                                const result = await response.json();

                                if (result.success) {
                                    this.dailyStats = result.data;
                                }
                            } catch (error) {
                                console.error('Error loading daily stats:', error);
                            }
                        },

                        async loadMonthlyStats() {
                            try {
                                const response = await fetch(
                                    '{{ route('dashboard.stats.monthly-patients') }}');
                                const result = await response.json();

                                if (result.success) {
                                    this.monthlyStats = result.data;
                                }
                            } catch (error) {
                                console.error('Error loading monthly stats:', error);
                            }
                        },

                        async loadComprehensiveStats() {
                            try {
                                const response = await fetch(
                                    '{{ route('dashboard.stats.comprehensive') }}');
                                const result = await response.json();

                                if (result.success) {
                                    this.comprehensiveStats = result.data;
                                }
                            } catch (error) {
                                console.error('Error loading comprehensive stats:', error);
                            }
                        },

                        formatCurrency(amount) {
                            return new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR'
                            }).format(amount || 0);
                        },

                        getGrowthIcon() {
                            if (!this.comprehensiveStats) return 'fas fa-minus';
                            const growth = this.comprehensiveStats.month.growth_percentage;
                            return growth > 0 ? 'fas fa-arrow-up text-success' :
                                growth < 0 ? 'fas fa-arrow-down text-danger' :
                                'fas fa-minus text-muted';
                        },

                        getGrowthText() {
                            if (!this.comprehensiveStats) return '0%';
                            const growth = this.comprehensiveStats.month.growth_percentage;
                            return Math.abs(growth) + '%';
                        }
                    }));

                    // Alpine.js component untuk Get Up and Go Test
                    Alpine.data('getUpGoTest', () => ({
                        criteria: {
                            one: false,
                            two: false
                        },

                        result: {
                            interpretation: 'Belum ada evaluasi',
                            action: 'Silakan pilih kriteria untuk memulai evaluasi',
                            severity: 'secondary'
                        },

                        init() {
                            console.log('Get Up and Go Test initialized');
                            this.updateAssessment();
                        },

                        updateAssessment() {
                            console.log('Updating assessment with criteria:', this.criteria);

                            if (this.criteria.one && this.criteria.two) {
                                this.setAssessment(
                                    'Berisiko Tinggi',
                                    'Pemberian gelang kuning, edukasi komprehensif, pendampingan ketat, dan penyediaan fasilitas bantuan (kursi roda, tripod, handrail)',
                                    'danger'
                                );
                            } else if (this.criteria.one || this.criteria.two) {
                                this.setAssessment(
                                    'Berisiko Rendah',
                                    'Edukasi pasien dan keluarga tentang pencegahan jatuh, monitoring berkala',
                                    'warning'
                                );
                            } else {
                                this.setAssessment(
                                    'Tidak Berisiko Jatuh',
                                    'Tidak diperlukan tindakan khusus, lanjutkan perawatan standar',
                                    'success'
                                );
                            }
                        },
                        setAssessment(interpretation, action, severity) {
                            this.result = {
                                interpretation,
                                action,
                                severity
                            };
                            console.log('Assessment result:', this.result);
                        },

                        // Method untuk handle perubahan checkbox dengan debounce
                        handleCriteriaChange() {
                            this.$nextTick(() => {
                                this.updateAssessment();
                            });
                        },

                        // Method untuk toggle criteria
                        toggleCriteria(criteriaKey) {
                            this.criteria[criteriaKey] = !this.criteria[criteriaKey];
                            this.handleCriteriaChange();
                        }
                    }));
                });

                // Form submission dengan loading indicator
                document.addEventListener('DOMContentLoaded', function() {
                    const form = document.getElementById('gotest');
                    const submitButton = document.getElementById('kt_assessment_submit');

                    if (form && submitButton) {
                        form.addEventListener('submit', function(e) {
                            e.preventDefault();

                            // Show loading state
                            submitButton.setAttribute('data-kt-indicator', 'on');
                            submitButton.disabled = true;

                            // Submit after delay
                            setTimeout(function() {
                                form.submit();
                            }, 1500);
                        });
                    }
                });
            </script>
        @endpush

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
