<?php

/** @var array $rows */ /** @var \CodeIgniter\Pager\Pager $pager */ ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($pageTitle ?? 'Riwayat Klasifikasi') ?></title>
    <meta name="csrf-name" content="<?= csrf_token() ?>">
    <meta name="csrf-hash" content="<?= csrf_hash() ?>">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.0/cdn.min.js" defer></script>

    <style>
        .container-wide {
            max-width: 1100px;
        }
    </style>
</head>

<body class="bg-slate-50" x-data="historyPage()" x-init="init()">

    <header class="bg-white border-b">
        <div class="container-wide mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="<?= base_url('/') ?>" class="text-blue-600 hover:text-blue-700">&larr; Beranda</a>
                <div class="h-6 w-px bg-gray-300"></div>
                <h1 class="text-xl font-semibold text-gray-800">Riwayat Klasifikasi</h1>
            </div>
            <a href="<?= base_url('Klasifikasi') ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">+ Klasifikasi Baru</a>
        </div>
    </header>

    <main class="container-wide mx-auto px-6 py-6">
        <div class="bg-white rounded-xl shadow">
            <div class="p-4 border-b flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">Data Tersimpan</h2>
                    <p class="text-sm text-gray-500">Edit atau hapus data hasil klasifikasi.</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-slate-100">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">#</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Input</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Prediksi</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Confidence</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Waktu</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        <?php if (empty($rows)): ?>
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-500">Belum ada data.</td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach ($rows as $i => $r): ?>
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 text-sm text-gray-600"><?= esc($r['id']) ?></td>
                                <td class="px-4 py-3 text-sm">
                                    <div class="text-gray-800">
                                        <span class="font-medium">Elastisitas:</span> <?= esc($r['elastisitas']) ?>,
                                        <span class="font-medium">Tekstur:</span> <?= esc($r['tekstur']) ?>,
                                        <span class="font-medium">Ketebalan:</span> <?= number_format((float)$r['ketebalan'], 2) ?> mm
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <div class="text-gray-800">
                                        <span class="font-medium">Bahan:</span> <?= esc($r['bahan_kain']) ?>,
                                        <span class="font-medium">Pakaian:</span> <?= esc($r['jenis_pakaian']) ?>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <div class="text-gray-700">
                                        <span class="mr-3">BK: <?= $r['conf_bahan_kain'] !== null ? round($r['conf_bahan_kain'] * 100, 1) . '%' : '-' ?></span>
                                        <span>JP: <?= $r['conf_jenis_pakaian'] !== null ? round($r['conf_jenis_pakaian'] * 100, 1) . '%' : '-' ?></span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600"><?= esc($r['created_at']) ?></td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-2">
                                        <button
                                            class="px-3 py-1.5 rounded-md text-sm bg-blue-600 hover:bg-blue-700 text-white"
                                            @click="openEdit(<?= (int)$r['id'] ?>, <?= htmlspecialchars(json_encode($r), ENT_QUOTES, 'UTF-8') ?>)">
                                            Edit
                                        </button>
                                        <button
                                            class="px-3 py-1.5 rounded-md text-sm bg-red-600 hover:bg-red-700 text-white"
                                            @click="confirmDelete(<?= (int)$r['id'] ?>)">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t">
                <?= $pager->links() ?>
            </div>
        </div>

        <!-- Toast -->
        <div x-show="toast.show" x-transition
            class="fixed bottom-6 right-6 bg-slate-900 text-white px-4 py-2 rounded-lg shadow-lg"
            x-text="toast.message"></div>

        <!-- Modal Edit -->
        <div x-show="modal.open" class="fixed inset-0 z-50 flex items-center justify-center" x-transition>
            <div class="absolute inset-0 bg-black/40" @click="modal.open=false"></div>
            <div class="relative bg-white rounded-xl shadow-xl w-full max-w-xl">
                <div class="px-5 py-4 border-b flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800">Edit Data #<span x-text="form.id"></span></h3>
                    <button class="text-gray-500 hover:text-gray-700" @click="modal.open=false">✕</button>
                </div>
                <div class="p-5 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Elastisitas</label>
                            <input type="text" class="mt-1 w-full border rounded-md px-3 py-2" x-model="form.elastisitas">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tekstur</label>
                            <input type="text" class="mt-1 w-full border rounded-md px-3 py-2" x-model="form.tekstur">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ketebalan (mm)</label>
                            <input type="number" step="0.01" class="mt-1 w-full border rounded-md px-3 py-2" x-model.number="form.ketebalan">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Bahan Kain</label>
                            <input type="text" class="mt-1 w-full border rounded-md px-3 py-2" x-model="form.bahan_kain">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jenis Pakaian</label>
                            <input type="text" class="mt-1 w-full border rounded-md px-3 py-2" x-model="form.jenis_pakaian">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Conf. Bahan Kain</label>
                            <input type="number" step="0.0001" class="mt-1 w-full border rounded-md px-3 py-2" x-model.number="form.conf_bahan_kain" placeholder="0..1">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Conf. Jenis Pakaian</label>
                            <input type="number" step="0.0001" class="mt-1 w-full border rounded-md px-3 py-2" x-model.number="form.conf_jenis_pakaian" placeholder="0..1">
                        </div>
                    </div>

                    <p x-show="formError" class="text-sm text-red-600" x-text="formError"></p>
                </div>
                <div class="px-5 py-4 border-t flex items-center justify-end gap-2">
                    <button class="px-4 py-2 rounded-md border" @click="modal.open=false">Batal</button>
                    <button class="px-4 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white" @click="submitEdit()" :disabled="saving">
                        <span x-show="!saving">Simpan</span>
                        <span x-show="saving">Menyimpan...</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Dialog Delete -->
        <div x-show="del.open" class="fixed inset-0 z-50 flex items-center justify-center" x-transition>
            <div class="absolute inset-0 bg-black/40" @click="del.open=false"></div>
            <div class="relative bg-white rounded-xl shadow-xl w-full max-w-md">
                <div class="px-5 py-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-800">Hapus Data</h3>
                </div>
                <div class="p-5">
                    <p class="text-gray-700">Yakin ingin menghapus data #<span x-text="del.id"></span>? Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="px-5 py-4 border-t flex items-center justify-end gap-2">
                    <button class="px-4 py-2 rounded-md border" @click="del.open=false">Batal</button>
                    <button class="px-4 py-2 rounded-md bg-red-600 hover:bg-red-700 text-white" @click="submitDelete()" :disabled="saving">
                        <span x-show="!saving">Hapus</span>
                        <span x-show="saving">Menghapus...</span>
                    </button>
                </div>
            </div>
        </div>
    </main>

    <script>
        function historyPage() {
            return {
                saving: false,
                formError: null,
                toast: {
                    show: false,
                    message: ''
                },
                modal: {
                    open: false
                },
                del: {
                    open: false,
                    id: null
                },
                form: {
                    id: null,
                    elastisitas: '',
                    tekstur: '',
                    ketebalan: 0,
                    bahan_kain: '',
                    jenis_pakaian: '',
                    conf_bahan_kain: null,
                    conf_jenis_pakaian: null
                },
                init() {},

                openEdit(id, row) {
                    this.formError = null;
                    this.form = {
                        id: id,
                        elastisitas: row.elastisitas ?? '',
                        tekstur: row.tekstur ?? '',
                        ketebalan: parseFloat(row.ketebalan ?? 0),
                        bahan_kain: row.bahan_kain ?? '',
                        jenis_pakaian: row.jenis_pakaian ?? '',
                        conf_bahan_kain: row.conf_bahan_kain !== null ? parseFloat(row.conf_bahan_kain) : null,
                        conf_jenis_pakaian: row.conf_jenis_pakaian !== null ? parseFloat(row.conf_jenis_pakaian) : null,
                    };
                    this.modal.open = true;
                },

                async submitEdit() {
                    // validasi ringan
                    if (!this.form.elastisitas || !this.form.tekstur || !this.form.bahan_kain || !this.form.jenis_pakaian) {
                        this.formError = 'Semua field teks wajib diisi.';
                        return;
                    }
                    if (!this.form.ketebalan || isNaN(this.form.ketebalan)) {
                        this.formError = 'Ketebalan tidak valid.';
                        return;
                    }

                    this.saving = true;
                    const csrfName = document.querySelector('meta[name="csrf-name"]').content;
                    let csrfHash = document.querySelector('meta[name="csrf-hash"]').content;

                    const payload = {
                        [csrfName]: csrfHash,
                        elastisitas: this.form.elastisitas,
                        tekstur: this.form.tekstur,
                        ketebalan: this.form.ketebalan,
                        bahan_kain: this.form.bahan_kain,
                        jenis_pakaian: this.form.jenis_pakaian,
                        conf_bahan_kain: this.form.conf_bahan_kain,
                        conf_jenis_pakaian: this.form.conf_jenis_pakaian
                    };

                    try {
                        const r = await fetch(`<?= base_url('history/update') ?>/${this.form.id}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify(payload)
                        });
                        let data = null,
                            text = '';
                        try {
                            data = await r.json();
                        } catch {
                            text = await r.text();
                        }

                        if (!r.ok) {
                            if (data?.csrf) document.querySelector('meta[name="csrf-hash"]').setAttribute('content', data.csrf);
                            throw new Error(data?.message || text?.slice(0, 200) || `HTTP ${r.status}`);
                        }

                        if (data?.csrf) document.querySelector('meta[name="csrf-hash"]').setAttribute('content', data.csrf);
                        this.modal.open = false;
                        this.showToast('Berhasil diperbarui. Muat ulang halaman untuk melihat perubahan.');
                    } catch (e) {
                        this.formError = e.message || 'Gagal menyimpan data.';
                    } finally {
                        this.saving = false;
                    }
                },

                confirmDelete(id) {
                    this.del = {
                        open: true,
                        id
                    };
                },

                async submitDelete() {
                    this.saving = true;
                    const csrfName = document.querySelector('meta[name="csrf-name"]').content;
                    let csrfHash = document.querySelector('meta[name="csrf-hash"]').content;

                    const payload = {
                        [csrfName]: csrfHash
                    };

                    try {
                        const r = await fetch(`<?= base_url('history/delete') ?>/${this.del.id}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify(payload)
                        });
                        let data = null,
                            text = '';
                        try {
                            data = await r.json();
                        } catch {
                            text = await r.text();
                        }

                        if (!r.ok) {
                            if (data?.csrf) document.querySelector('meta[name="csrf-hash"]').setAttribute('content', data.csrf);
                            throw new Error(data?.message || text?.slice(0, 200) || `HTTP ${r.status}`);
                        }

                        if (data?.csrf) document.querySelector('meta[name="csrf-hash"]').setAttribute('content', data.csrf);
                        this.del.open = false;
                        this.showToast('Berhasil dihapus. Memuat ulang...');
                        setTimeout(() => window.location.reload(), 800);
                    } catch (e) {
                        this.del.open = false;
                        this.showToast(e.message || 'Gagal menghapus data.');
                    } finally {
                        this.saving = false;
                    }
                },

                showToast(msg) {
                    this.toast.message = msg;
                    this.toast.show = true;
                    setTimeout(() => this.toast.show = false, 2500);
                },
            }
        }
    </script>
</body>

</html>