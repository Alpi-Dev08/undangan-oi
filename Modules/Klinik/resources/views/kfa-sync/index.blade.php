@extends('klinik::layouts.app')

@section('title', 'Sinkronisasi KFA - Drugs')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="syncController()">
    <!-- Header -->
    <div class="bg-white shadow rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6">
            <h1 class="text-2xl font-bold text-gray-900">Sinkronisasi KFA - Drugs</h1>
            <p class="mt-1 text-sm text-gray-500">
                Sinkronisasi data drugs dengan KFA menggunakan fuzzy string matching
            </p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">Total Drugs</dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900" x-text="stats.total_drugs">0</dd>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">Sudah Sync</dt>
                <dd class="mt-1 text-3xl font-semibold text-green-600" x-text="stats.synced_drugs">0</dd>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">Belum Sync</dt>
                <dd class="mt-1 text-3xl font-semibold text-red-600" x-text="stats.pending_drugs">0</dd>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">Persentase</dt>
                <dd class="mt-1 text-3xl font-semibold text-blue-600" x-text="stats.sync_percentage + '%'">0%</dd>
            </div>
        </div>
    </div>

    <!-- Progress Bar -->
    <div x-show="isSyncing" class="bg-white shadow rounded-lg mb-6">
        <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-lg font-medium text-gray-900">Proses Sinkronisasi</h3>
                <span class="text-sm text-gray-500" x-text="progress.current + ' / ' + progress.total">0 / 0</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-300" 
                     :style="`width: ${progress.percentage}%`"></div>
            </div>
            <div class="mt-2 text-sm text-gray-600" x-text="progress.message">Memproses...</div>
        </div>
    </div>

    <!-- Control Panel -->
    <div class="bg-white shadow rounded-lg mb-6">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Panel Kontrol</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Threshold Similarity (%)
                    </label>
                    <input type="number" 
                           x-model="syncOptions.threshold" 
                           min="0" max="100" 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                </div>
                <div class="flex items-end space-x-2">
                    <button @click="startSync()" 
                            :disabled="isSyncing"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50">
                        <svg x-show="!isSyncing" class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <svg x-show="isSyncing" class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span x-text="isSyncing ? 'Menyinkronkan...' : 'Mulai Sinkronisasi'"></span>
                    </button>
                    <button @click="resetSync()" 
                            :disabled="isSyncing"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50">
                        Reset
                    </button>
                </div>
            </div>
            <div class="mt-4 flex items-center space-x-4">
                <label class="flex items-center">
                    <input type="checkbox" x-model="syncOptions.dry_run" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-700">Mode dry-run (simulasi)</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" x-model="syncOptions.reset" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-700">Reset semua sync</span>
                </label>
            </div>
        </div>
    </div>

    <!-- Results Panel -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Hasil Sinkronisasi</h3>
            
            <!-- Tabs -->
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <button @click="activeTab = 'pending'" 
                            :class="activeTab === 'pending' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="py-2 px-1 border-b-2 font-medium text-sm">
                        Belum Sync (<span x-text="pendingDrugs.length">0</span>)
                    </button>
                    <button @click="activeTab = 'synced'" 
                            :class="activeTab === 'synced' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="py-2 px-1 border-b-2 font-medium text-sm">
                        Sudah Sync (<span x-text="syncedDrugs.length">0</span>)
                    </button>
                </nav>
            </div>

            <!-- Content -->
            <div class="mt-4">
                <!-- Pending Drugs -->
                <div x-show="activeTab === 'pending'" class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <template x-for="drug in pendingDrugs" :key="drug.id">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" x-text="drug.name"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" x-text="new Date(drug.created_at).toLocaleDateString()"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button @click="syncSingleDrug(drug.id)" class="text-blue-600 hover:text-blue-900">Sinkronkan</button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <!-- Synced Drugs -->
                <div x-show="activeTab === 'synced'" class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">KFA Code</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Manufacturer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Sync</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <template x-for="drug in syncedDrugs" :key="drug.id">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" x-text="drug.name"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" x-text="drug.kfa_code"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" x-text="drug.manufacturer || '-'"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" x-text="drug.similarity_score + '%'"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" x-text="new Date(drug.last_sync_attempt).toLocaleDateString()"></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function syncController() {
    return {
        stats: {
            total_drugs: 0,
            synced_drugs: 0,
            pending_drugs: 0,
            sync_percentage: 0
        },
        isSyncing: false,
        progress: {
            current: 0,
            total: 0,
            percentage: 0,
            message: ''
        },
        syncOptions: {
            threshold: 70,
            dry_run: false,
            reset: false,
            limit: null
        },
        activeTab: 'pending',
        pendingDrugs: [],
        syncedDrugs: [],

        init() {
            this.loadStatistics();
            this.loadPendingDrugs();
            this.loadSyncedDrugs();
        },

        async loadStatistics() {
            try {
                const response = await fetch('/kfa-sync/statistics');
                const data = await response.json();
                if (data.success) {
                    this.stats = data.data;
                }
            } catch (error) {
                console.error('Error loading statistics:', error);
            }
        },

        async loadPendingDrugs() {
            try {
                const response = await fetch('/kfa-sync/pending');
                const data = await response.json();
                if (data.success) {
                    this.pendingDrugs = data.data;
                }
            } catch (error) {
                console.error('Error loading pending drugs:', error);
            }
        },

        async loadSyncedDrugs() {
            try {
                const response = await fetch('/kfa-sync/synced');
                const data = await response.json();
                if (data.success) {
                    this.syncedDrugs = data.data;
                }
            } catch (error) {
                console.error('Error loading synced drugs:', error);
            }
        },

        async startSync() {
            this.isSyncing = true;
            this.progress = { current: 0, total: 0, percentage: 0, message: 'Memulai sinkronisasi...' };

            try {
                const params = new URLSearchParams({
                    threshold: this.syncOptions.threshold,
                    dry_run: this.syncOptions.dry_run,
                    reset: this.syncOptions.reset
                });

                if (this.syncOptions.limit) {
                    params.append('limit', this.syncOptions.limit);
                }

                const response = await fetch(`/kfa-sync/sync?${params}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();
                
                if (data.success) {
                    this.$dispatch('notify', {
                        type: 'success',
                        message: 'Sinkronisasi selesai!'
                    });
                    
                    // Reload data
                    this.loadStatistics();
                    this.loadPendingDrugs();
                    this.loadSyncedDrugs();
                } else {
                    this.$dispatch('notify', {
                        type: 'error',
                        message: data.message || 'Terjadi kesalahan'
                    });
                }
            } catch (error) {
                this.$dispatch('notify', {
                    type: 'error',
                    message: 'Terjadi kesalahan koneksi'
                });
            } finally {
                this.isSyncing = false;
            }
        },

        async resetSync() {
            if (!confirm('Apakah Anda yakin ingin reset semua sinkronisasi?')) return;

            try {
                const response = await fetch('/kfa-sync/reset', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();
                
                if (data.success) {
                    this.$dispatch('notify', {
                        type: 'success',
                        message: 'Reset berhasil!'
                    });
                    
                    this.loadStatistics();
                    this.loadPendingDrugs();
                    this.loadSyncedDrugs();
                } else {
                    this.$dispatch('notify', {
                        type: 'error',
                        message: data.message || 'Terjadi kesalahan'
                    });
                }
            } catch (error) {
                this.$dispatch('notify', {
                    type: 'error',
                    message: 'Terjadi kesalahan koneksi'
                });
            }
        },

        async syncSingleDrug(drugId) {
            try {
                const params = new URLSearchParams({
                    threshold: this.syncOptions.threshold,
                    dry_run: this.syncOptions.dry_run
                });

                const response = await fetch(`/kfa-sync/match/${drugId}?${params}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();
                
                if (data.success) {
                    this.$dispatch('notify', {
                        type: 'success',
                        message: 'Sinkronisasi drug berhasil!'
                    });
                    
                    this.loadStatistics();
                    this.loadPendingDrugs();
                    this.loadSyncedDrugs();
                } else {
                    this.$dispatch('notify', {
                        type: 'error',
                        message: data.message || 'Terjadi kesalahan'
                    });
                }
            } catch (error) {
                this.$dispatch('notify', {
                    type: 'error',
                    message: 'Terjadi kesalahan koneksi'
                });
            }
        }
    }
}
</script>
@endsection