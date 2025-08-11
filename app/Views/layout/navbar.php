<header class="w-full bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-4">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold text-sm">📊</span>
                </div>
                <span class="font-semibold text-gray-800">
                    Sistem Klasifikasi
                </span>
            </div>

            <div class="hidden md:flex items-center">
                <a href="<?= base_url('/') ?>"
                    class="font-semibold px-4 py-1 rounded-full hover:bg-blue-700 hover:text-white transition">
                    Home
                </a>
                <a href="<?= base_url('/Klasifikasi') ?>"
                    class="font-semibold px-4 py-1 rounded-full hover:bg-blue-700 hover:text-white transition">
                    Klasifikasi
                </a>
                <a href="<?= base_url('/laporan') ?>"
                    class="font-semibold px-4 py-1 rounded-full hover:bg-blue-700 hover:text-white transition">
                    Laporan
                </a>
            </div>

            <div class="flex items-center gap-4">
                <a href="<?= base_url('/akun') ?>"
                    class="font-semibold px-4 py-1 rounded-full hover:bg-blue-700 hover:text-white transition">
                    Profile
                </a>
                <a href="<?= site_url('logout') ?>" class="px-4 py-1 rounded-full font-bold text-red-600 hover:bg-red-700 hover:text-white transition">
                    Logout
                </a>
            </div>
        </div>
    </div>
</header>