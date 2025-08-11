<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login - FabricScan AI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 min-h-screen flex flex-col items-center justify-center p-4 font-sans">

    <div class="w-full max-w-md">
        <div class="flex justify-center mb-5">
            <img src="<?= base_url('public/fabric.png') ?>" alt="Logo FabricScan AI" class="w-24 h-24">
        </div>

        <div class="bg-white p-8 rounded-2xl shadow-lg w-full">

            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-slate-800">Login Aplikasi</h1>
                <p class="text-slate-500 mt-2 text-sm">Masuk untuk memulai klasifikasi kain Anda.</p>
            </div>

            <form action="<?= base_url('/login') ?>" method="post" class="space-y-6">
                <div>
                    <label for="username" class="block text-sm font-medium text-slate-700 mb-2">Username</label>
                    <input type="text" id="username" name="username" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200"
                        placeholder="contoh: budi_pekerti">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200"
                        placeholder="••••••••">
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-colors duration-300 font-semibold text-base shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Masuk
                </button>
            </form>

            <div class="text-center mt-8">
                <p class="text-sm text-slate-600">
                    Belum punya akun?
                    <a href="<?= site_url('register') ?>" class="font-medium text-blue-600 hover:underline">
                        Daftar sekarang
                    </a>
                </p>
            </div>
        </div>
    </div>

    <?php
    // --- Blok PHP untuk notifikasi SweetAlert2 (TIDAK PERLU DIUBAH) ---
    $successMessage = session()->getFlashdata('success');
    if ($successMessage) : ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= esc($successMessage, 'js') ?>',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                window.location.href = "<?= base_url('/home') ?>";
            });
        </script>
    <?php endif; ?>

    <?php
    $errorMessage = session()->getFlashdata('error');
    if ($errorMessage) : ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                text: '<?= esc($errorMessage, 'js') ?>',
            });
        </script>
    <?php endif; ?>

</body>

</html>