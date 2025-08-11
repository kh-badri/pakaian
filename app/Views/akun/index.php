<?= $this->extend('layout/layout'); ?>
<?= $this->section('content'); ?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Akun Saya</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="md:col-span-2">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Informasi Profil</h2>
                <form action="<?= site_url('akun/update_profil') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="flex items-center space-x-6 mb-6">
                        <img class="h-24 w-24 rounded-full object-cover" src="<?= base_url('/uploads/foto_profil/' . $user['foto']) ?>" alt="Foto Profil">
                        <div>
                            <label for="foto" class="block text-sm font-medium text-gray-700">Ganti Foto</label>
                            <input type="file" name="foto" id="foto" class="mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="text-xs text-gray-500 mt-1">PNG, JPG, JPEG (MAX. 1MB)</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="username" class="block text-gray-700">Username</label>
                        <input type="text" id="username" value="<?= esc($user['username']) ?>" class="w-full px-4 py-2 mt-2 border rounded-md bg-gray-100 cursor-not-allowed" disabled>
                    </div>
                    <div class="mb-4">
                        <label for="nama_lengkap" class="block text-gray-700">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" value="<?= esc($user['nama_lengkap']) ?>" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700">Email</label>
                        <input type="email" name="email" id="email" value="<?= esc($user['email']) ?>" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600">
                    </div>
                    <button type="submit" class="w-full bg-blue-700 text-white px-4 py-2 rounded-md hover:bg-blue-800">Simpan Perubahan Profil</button>
                </form>
            </div>
        </div>

        <div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Ganti Password</h2>
                <form action="<?= site_url('akun/update_sandi') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-4">
                        <label for="password_lama" class="block text-gray-700">Password Lama</label>
                        <input type="password" name="password_lama" id="password_lama" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600" required>
                    </div>
                    <div class="mb-4">
                        <label for="password_baru" class="block text-gray-700">Password Baru</label>
                        <input type="password" name="password_baru" id="password_baru" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600" required>
                    </div>
                    <div class="mb-4">
                        <label for="konfirmasi_password" class="block text-gray-700">Konfirmasi Password Baru</label>
                        <input type="password" name="konfirmasi_password" id="konfirmasi_password" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600" required>
                    </div>
                    <button type="submit" class="w-full bg-blue-700 text-white px-4 py-2 rounded-md hover:bg-blue-800">Ubah Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    <?php if (session()->getFlashdata('success')) : ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '<?= session()->getFlashdata('success') ?>',
        });
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')) : ?>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            html: '<ul><?php foreach (session()->getFlashdata('errors') as $error) : ?><li class="text-left"><?= esc($error) ?></li><?php endforeach ?></ul>',
        });
    <?php endif; ?>
</script>

<?= $this->endSection(); ?>