<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Klasifikasi Bahan Pakaian - SVM</title>

    <!-- CSRF (CodeIgniter 4) -->
    <meta name="csrf-name" content="<?= csrf_token() ?>">
    <meta name="csrf-hash" content="<?= csrf_hash() ?>">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.0/cdn.min.js" defer></script>

    <style>
        .gradient-bg {
            background: linear-gradient(to bottom right, rgb(239, 246, 255), rgb(224, 231, 255))
        }
    </style>
</head>

<body class="min-h-screen gradient-bg" x-data="klasifikasiApp()" x-init="init()">

    <!-- Loading model -->
    <div x-show="loadingModel" class="min-h-screen flex items-center justify-center">
        <div class="text-center">
            <div class="animate-spin rounded-full h-32 w-32 border-b-2 border-indigo-600 mx-auto"></div>
            <p class="mt-4 text-lg text-gray-600">Menghubungkan & memuat model SVM...</p>
        </div>
    </div>

    <!-- Error model -->
    <div x-show="!loadingModel && !modelInfo.success" class="min-h-screen bg-red-50 flex items-center justify-center p-4">
        <div class="bg-white p-8 rounded-lg shadow-lg text-center max-w-md">
            <h1 class="text-2xl font-bold text-red-700 mb-4">Gagal Terhubung ke Backend</h1>
            <p class="text-gray-600 mb-2">Tidak dapat memuat informasi model yang diperlukan.</p>
            <p class="text-sm text-gray-500 bg-red-100 p-3 rounded-md">
                <strong>Detail Error:</strong> <span x-text="modelInfo.error || 'Tidak ada pesan error.'"></span>
            </p>
            <div class="mt-6">
                <a href="<?= base_url('/') ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium transition-colors">← Kembali ke Beranda</a>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div x-show="!loadingModel && modelInfo.success">
        <header class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-6 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <a href="<?= base_url('/') ?>" class="text-blue-600 hover:text-blue-700 font-medium">← Beranda</a>
                        <div class="h-6 w-px bg-gray-300"></div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                                <span class="text-white font-bold text-sm">🧪</span>
                            </div>
                            <span class="font-semibold text-gray-800">Klasifikasi SVM</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <p class="text-sm text-gray-600">Sedang digunakan oleh:</p>
                            <p class="font-semibold text-gray-800"><?= session('username') ?? 'User' ?></p>
                        </div>
                        <a href="<?= base_url('logout') ?>" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-medium transition-colors">Logout</a>
                    </div>
                </div>
            </div>
        </header>

        <div class="py-8 px-4">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-gray-800 mb-4">Klasifikasi Bahan Pakaian</h1>
                    <p class="text-lg text-gray-600">Prediksi jenis bahan kain dan jenis pakaian menggunakan algoritma Support Vector Machine (SVM)</p>
                </div>

                <!-- Model info -->
                <div x-show="modelInfo.success" class="bg-white rounded-lg shadow-md p-6 mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Informasi Model & Dataset</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Total Data Training:</p>
                            <p class="text-lg font-semibold text-indigo-600" x-text="(modelInfo.datasetInfo?.totalRecords || 0) + ' records'"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Algoritma:</p>
                            <p class="text-lg font-semibold text-purple-600" x-text="modelInfo.modelInfo?.algorithm || 'SVM'"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Kernel:</p>
                            <p class="text-lg font-semibold text-blue-600" x-text="modelInfo.modelInfo?.kernelType || 'RBF'"></p>
                        </div>
                    </div>
                    <div x-show="modelInfo.modelInfo?.accuracy" class="mt-4 p-3 bg-green-50 rounded-lg">
                        <p class="text-sm text-gray-600">Akurasi Model:</p>
                        <p class="text-lg font-semibold text-green-700" x-text="modelInfo.modelInfo?.accuracy ? (modelInfo.modelInfo.accuracy * 100).toFixed(1) + '%' : ''"></p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Form -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Input Karakteristik Material</h2>

                        <form @submit.prevent="submitPrediction" class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Elastisitas Material</label>
                                <select x-model="form.elastisitas" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                                    <option value="">Pilih Tingkat Elastisitas</option>
                                    <template x-for="option in modelInfo.availableOptions?.elastisitas || []" :key="option">
                                        <option :value="option" x-text="option"></option>
                                    </template>
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Pilih tingkat elastisitas bahan</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tekstur Permukaan</label>
                                <select x-model="form.tekstur" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                                    <option value="">Pilih Jenis Tekstur</option>
                                    <template x-for="option in modelInfo.availableOptions?.tekstur || []" :key="option">
                                        <option :value="option" x-text="option"></option>
                                    </template>
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Pilih karakteristik tekstur permukaan</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ketebalan Material (mm)</label>
                                <input type="number" step="0.01" min="0.2" max="2.0" x-model="form.ketebalan" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Contoh: 1.2" required>
                                <p class="text-xs text-gray-500 mt-1">Masukkan ketebalan (0.2 - 2.0 mm)</p>
                            </div>

                            <div x-show="formError" class="p-3 bg-red-100 text-red-700 border border-red-300 rounded-md text-sm">
                                <span x-text="formError"></span>
                            </div>

                            <div class="pt-4 space-y-4">
                                <!-- Tombol Klasifikasi -->
                                <button type="submit" :disabled="loading"
                                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 px-4 rounded-md font-medium 
               transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500
               disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center">
                                    <span x-show="!loading">Klasifikasi dengan SVM</span>
                                    <span x-show="loading" class="flex items-center">
                                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 
                       5.291A7.962 7.962 0 014 12H0c0 
                       3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        Memproses...
                                    </span>
                                </button>

                                <!-- Tombol Simpan & Reset -->
                                <div class="flex gap-3">
                                    <button type="button" @click="saveResult()"
                                        :disabled="!result || !result.success || saving"
                                        class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md font-medium 
                   transition-colors focus:outline-none focus:ring-2 focus:ring-green-500
                   disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center">
                                        <span x-show="!saving">Simpan Hasil</span>
                                        <span x-show="saving" class="flex items-center">
                                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                    stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 
                           0 5.373 0 12h4zm2 
                           5.291A7.962 7.962 0 014 12H0c0 
                           3.042 1.135 5.824 3 
                           7.938l3-2.647z">
                                                </path>
                                            </svg>
                                            Menyimpan...
                                        </span>
                                    </button>

                                    <button type="button" @click="resetForm()"
                                        class="flex-1 border border-gray-300 text-gray-700 py-2 px-4 rounded-md font-medium 
                   transition-colors hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                        Reset
                                    </button>
                                </div>

                                <!-- Pesan Status -->
                                <div x-show="saveStatus.message"
                                    class="text-center text-sm p-2 rounded-md"
                                    :class="{ 'bg-green-100 text-green-800': saveStatus.success, 
                  'bg-red-100 text-red-800': !saveStatus.success }"
                                    x-text="saveStatus.message">
                                </div>

                                <a href="<?= base_url('history') ?>"
                                    class="flex items-center justify-center gap-2 bg-blue-500 hover:bg-blue-600 text-white py-2 px-6 rounded-md
           font-medium transition-colors shadow-sm">
                                    <!-- Icon Dokumen -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z" />
                                    </svg>
                                    Lihat Hasil Laporan
                                </a>
                            </div>

                        </form>
                    </div>

                    <!-- Result -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Hasil Prediksi SVM</h2>

                        <div x-show="!result" class="text-center py-12">
                            <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-500">Masukkan karakteristik material untuk mendapatkan prediksi</p>
                        </div>

                        <div x-show="result" class="space-y-4">
                            <template x-if="result?.success">
                                <div>
                                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                        <h3 class="font-semibold text-gray-800 mb-2">Data Input:</h3>
                                        <div class="space-y-1 text-sm">
                                            <p><span class="font-medium">Elastisitas:</span> <span x-text="result.input?.elastisitas"></span></p>
                                            <p><span class="font-medium">Tekstur:</span> <span x-text="result.input?.tekstur"></span></p>
                                            <p><span class="font-medium">Ketebalan:</span> <span x-text="result.input?.ketebalan"></span> mm</p>
                                        </div>
                                    </div>

                                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-3">
                                        <div class="flex justify-between items-start mb-2">
                                            <h3 class="font-semibold text-green-800">Prediksi Bahan Kain:</h3>
                                            <span x-show="result.prediction?.confidence?.bahanKain" :class="getConfidenceBadgeClass(result.prediction?.confidence?.bahanKain)" class="text-xs font-medium px-2 py-1 rounded">
                                                Confidence: <span x-text="getConfidenceLabel(result.prediction?.confidence?.bahanKain)"></span>
                                            </span>
                                        </div>
                                        <p class="text-lg font-bold text-green-700" x-text="result.prediction?.bahanKain"></p>
                                        <p x-show="result.prediction?.confidence?.bahanKain" :class="getConfidenceColor(result.prediction?.confidence?.bahanKain)" class="text-sm mt-1">
                                            Tingkat keyakinan: <span x-text="result.prediction?.confidence?.bahanKain ? (result.prediction.confidence.bahanKain * 100).toFixed(1) + '%' : ''"></span>
                                        </p>
                                    </div>

                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                        <div class="flex justify-between items-start mb-2">
                                            <h3 class="font-semibold text-blue-800">Prediksi Jenis Pakaian:</h3>
                                            <span x-show="result.prediction?.confidence?.jenisPakaian" :class="getConfidenceBadgeClass(result.prediction?.confidence?.jenisPakaian)" class="text-xs font-medium px-2 py-1 rounded">
                                                Confidence: <span x-text="getConfidenceLabel(result.prediction?.confidence?.jenisPakaian)"></span>
                                            </span>
                                        </div>
                                        <p class="text-lg font-bold text-blue-700" x-text="result.prediction?.jenisPakaian"></p>
                                        <p x-show="result.prediction?.confidence?.jenisPakaian" :class="getConfidenceColor(result.prediction?.confidence?.jenisPakaian)" class="text-sm mt-1">
                                            Tingkat keyakinan: <span x-text="result.prediction?.confidence?.jenisPakaian ? (result.prediction.confidence.jenisPakaian * 100).toFixed(1) + '%' : ''"></span>
                                        </p>
                                    </div>
                                </div>
                            </template>

                            <template x-if="result && !result.success">
                                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                    <h3 class="font-semibold text-red-800 mb-2">Prediksi Gagal:</h3>
                                    <p class="text-red-700" x-text="result.message"></p>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function klasifikasiApp() {
            return {
                BACKEND_URL: 'http://127.0.0.1:5001',
                loadingModel: true,
                loading: false,
                saving: false,
                formError: null,
                saveStatus: {
                    success: false,
                    message: ''
                },
                form: {
                    elastisitas: '',
                    tekstur: '',
                    ketebalan: ''
                },
                result: null,
                modelInfo: {
                    success: false
                },

                async init() {
                    this.loadModelInfo();
                },

                async loadModelInfo() {
                    this.loadingModel = true;
                    try {
                        const r = await fetch(`${this.BACKEND_URL}/info`);
                        const data = await r.json();
                        if (!r.ok) throw new Error(data.error || 'Gagal memuat info model dari backend.');
                        this.modelInfo = data;
                    } catch (e) {
                        this.modelInfo = {
                            success: false,
                            error: e.message
                        };
                        console.error('Error loading model info:', e);
                    } finally {
                        this.loadingModel = false;
                    }
                },

                async submitPrediction() {
                    this.formError = null;
                    this.saveStatus = {
                        success: false,
                        message: ''
                    };
                    this.loading = true;
                    this.result = null;

                    // guard ketebalan
                    const k = this.form.ketebalan;
                    if (!k || isNaN(parseFloat(k))) {
                        this.formError = 'Ketebalan harus angka yang valid.';
                        this.loading = false;
                        return;
                    }

                    try {
                        const r = await fetch(`${this.BACKEND_URL}/predict`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                Elastisitas: this.form.elastisitas,
                                Tekstur: this.form.tekstur,
                                Ketebalan: parseFloat(k),
                            }),
                        });
                        const data = await r.json();
                        if (!r.ok) throw new Error(data.message || 'Prediksi gagal.');
                        this.result = data;
                    } catch (e) {
                        this.result = {
                            success: false,
                            message: e.message
                        };
                        console.error('Error submitting prediction:', e);
                    } finally {
                        this.loading = false;
                    }
                },

                async saveResult() {
                    if (!this.result || !this.result.success) {
                        this.saveStatus = {
                            success: false,
                            message: 'Tidak ada hasil valid untuk disimpan.'
                        };
                        return;
                    }
                    this.saving = true;
                    this.saveStatus = {
                        success: false,
                        message: ''
                    };

                    // Normalisasi input (jaga-jaga beda kapital dari backend Python)
                    const input = this.result.input ?? {};
                    const normalizedInput = {
                        elastisitas: input.elastisitas ?? input.Elastisitas ?? '',
                        tekstur: input.tekstur ?? input.Tekstur ?? '',
                        ketebalan: input.ketebalan ?? input.Ketebalan ?? null,
                    };

                    // CSRF
                    const csrfName = document.querySelector('meta[name="csrf-name"]')?.content;
                    let csrfHash = document.querySelector('meta[name="csrf-hash"]')?.content;

                    const payload = {
                        [csrfName]: csrfHash,
                        input: normalizedInput,
                        prediction: this.result.prediction
                    };

                    try {
                        const r = await fetch('<?= base_url('klasifikasi/simpan') ?>', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(payload)
                        });

                        // coba parse JSON; jika gagal, ambil text utk debug
                        let data = null,
                            rawText = '';
                        try {
                            data = await r.json();
                        } catch {
                            rawText = await r.text();
                        }

                        if (!r.ok) {
                            // update token jika server mengirimkan
                            if (data && data.csrf) {
                                csrfHash = data.csrf;
                                document.querySelector('meta[name="csrf-hash"]')?.setAttribute('content', csrfHash);
                            }
                            const msg = data?.messages?.error ??
                                (data && Object.values(data.messages || {})[0]) ??
                                rawText?.slice(0, 200) ??
                                `HTTP ${r.status}`;
                            throw new Error(msg || 'Gagal menyimpan data.');
                        }

                        // sukses — refresh token jika ada
                        if (data && data.csrf) {
                            document.querySelector('meta[name="csrf-hash"]')?.setAttribute('content', data.csrf);
                        }
                        this.saveStatus = {
                            success: true,
                            message: data?.message ?? 'Berhasil disimpan.'
                        };

                    } catch (e) {
                        console.error('Error saving result:', e);
                        this.saveStatus = {
                            success: false,
                            message: e.message || 'Gagal menyimpan data.'
                        };
                    } finally {
                        this.saving = false;
                    }
                },

                resetForm() {
                    this.form = {
                        elastisitas: '',
                        tekstur: '',
                        ketebalan: ''
                    };
                    this.result = null;
                    this.formError = null;
                    this.saveStatus = {
                        success: false,
                        message: ''
                    };
                },

                getConfidenceColor(c) {
                    if (!c) return '';
                    if (c >= 0.8) return 'text-green-600';
                    if (c >= 0.6) return 'text-yellow-600';
                    return 'text-red-600';
                },
                getConfidenceLabel(c) {
                    if (!c) return '';
                    if (c >= 0.8) return 'Tinggi';
                    if (c >= 0.6) return 'Sedang';
                    return 'Rendah';
                },
                getConfidenceBadgeClass(c) {
                    if (!c) return '';
                    if (c >= 0.8) return 'bg-green-100 text-green-700';
                    if (c >= 0.6) return 'bg-yellow-100 text-yellow-700';
                    return 'bg-red-100 text-red-700';
                },
            }
        }
    </script>
</body>

</html>