<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - FabricScan AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 min-h-screen flex flex-col items-center justify-center p-4 font-sans">

    <div class="w-full max-w-md">
        <div class="bg-white p-8 rounded-2xl shadow-lg w-full">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-slate-800">Buat Akun Baru</h2>
                <p class="text-slate-500 mt-2 text-sm">Daftar untuk mendapatkan akses penuh.</p>
            </div>

            <?php
            $validation = \Config\Services::validation();
            if ($validation->getErrors()) :
            ?>
                <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 mb-6 rounded-md" role="alert">
                    <p class="font-bold mb-1">Terjadi Kesalahan</p>
                    <ul class="list-disc list-inside text-sm">
                        <?php foreach ($validation->getErrors() as $error) : ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('register') ?>" method="post" class="space-y-5">
                <?= csrf_field() ?>

                <div>
                    <label for="username" class="block text-sm font-medium text-slate-700 mb-2">Username</label>
                    <input type="text" name="username" id="username" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                    <input type="password" name="password" id="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required>
                </div>

                <div>
                    <label for="password_confirm" class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirm" id="password_confirm" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-colors duration-300 font-semibold text-base shadow-md hover:shadow-lg">
                    Daftar
                </button>
            </form>

            <div class="text-center mt-8">
                <p class="text-sm text-slate-600">
                    Sudah punya akun?
                    <a href="<?= site_url('login') ?>" class="font-medium text-blue-600 hover:underline">
                        Login di sini
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>

</html>