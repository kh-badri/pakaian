<?= $this->extend('layout/layout'); ?>

<?= $this->section('content'); ?>

<!-- Catatan: Animasi (framer-motion, Typewriter) di sini tidak akan berfungsi karena ini adalah HTML statis yang dirender oleh PHP. -->
<!-- Untuk fungsionalitas animasi, Anda perlu mengimplementasikan JavaScript secara terpisah di sisi klien. -->

<!-- Header dengan info user -->

<style>
    @keyframes floatY {
        0% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(0.2cm);
        }

        100% {
            transform: translateY(0);
        }
    }

    .float-animation {
        animation: floatY 2s ease-in-out infinite;
    }
</style>
<!-- Bagian Hero -->
<section class="flex flex-col-reverse md:flex-row items-center justify-between max-w-7xl mx-auto px-6 py-16">
    <!-- Kolom Teks -->
    <div
        class="md:w-xl text-center ml-0 md:text-left"
        style="opacity: 1; transform: translateY(0px);">
        <h1 id="typewriter" class="text-4xl md:text-5xl font-bold mb-2 text-blue-600">Klasifikasi Bahan Pakaian</h1>
        <p class="text-lg md:text-xl text-gray-600 mb-6">
            Aplikasi ini membantu Anda mengenali jenis bahan pakaian seperti
            katun, linen, poliester, dan lainnya secara otomatis dan cepat.
        </p>
        <!-- Tombol Aksi -->
        <div class="flex flex-col sm:flex-row gap-4 mt-8">
            <a
                href="<?= base_url('/Klasifikasi') ?>"
                class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors duration-200 text-center">
                🚀 Mulai Klasifikasi
            </a>
            <button id="btn-lebih-lanjut" class="border border-gray-300 hover:bg-gray-50 text-gray-700 px-8 py-3 rounded-lg font-semibold transition-colors duration-200">
                📖 Pelajari Lebih Lanjut
            </button>
        </div>
    </div>

    <!-- Kolom Gambar dengan Animasi Melayang (Diganti Gambar Statis) -->
    <div class="md:w-1/2 mb-8 md:mb-0 flex justify-center">
        <img
            src="<?= base_url('public/fabric.png') ?>"
            alt="Contoh Bahan Pakaian"
            width="400"
            height="400"
            class="rounded-lg float-animation"
            loading="lazy" />
    </div>
</section>

<!-- Garis pemisah -->
<hr class="max-w-7xl mx-auto my-12 border-gray-300" />

<!-- Bagian Elastisitas Bahan Pakaian -->
<!-- Bagian Elastisitas Bahan Pakaian -->
<section id="elastisitas" class="max-w-7xl mx-auto px-6 py-12">

    <div
        style="opacity: 1; transform: translateY(0px);">
        <h2 class="text-3xl md:text-4xl font-bold mb-8 text-blue-600 text-center">
            Elastisitas Bahan Pakaian
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Elastisitas Rendah -->
            <div class="bg-white shadow-lg rounded-lg p-6 text-center transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <img
                    src="<?= base_url('public/kaintenun.png') ?>"
                    alt="Elastisitas Rendah"
                    width="300"
                    height="350"
                    class="mx-auto mb-4 object-cover rounded-md"
                    loading="lazy" />
                <h3 class="text-xl font-semibold mb-2 text-gray-800">
                    Rendah
                </h3>
                <p class="text-md text-gray-700">
                    Sulit melar, kembali ke bentuk asli perlahan. Contoh: Linen,
                    Katun (tenun), Denim. Cocok untuk struktur kuat.
                </p>
            </div>

            <!-- Elastisitas Sedang -->
            <div class="bg-white shadow-lg rounded-lg p-6 text-center transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <img
                    src="<?= base_url('public/kainwol.png') ?>"
                    alt="Elastisitas Sedang"
                    width="300"
                    height="350"
                    class="mx-auto mb-4 object-cover rounded-md"
                    loading="lazy" />
                <h3 class="text-xl font-semibold mb-2 text-gray-800">
                    Sedang
                </h3>
                <p class="text-md text-gray-700">
                    Melar sedikit, nyaman digerakkan. Contoh: Katun (rajut), Wol,
                    Rayon. Fleksibel untuk pakaian sehari-hari.
                </p>
            </div>

            <!-- Elastisitas Tinggi -->
            <div class="bg-white shadow-lg rounded-lg p-6 text-center transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <img
                    src="<?= base_url('public/kainjaring.png') ?>"
                    alt="Elastisitas Tinggi"
                    width="300"
                    height="350"
                    class="mx-auto mb-4 object-cover rounded-md"
                    loading="lazy" />
                <h3 class="text-xl font-semibold mb-2 text-gray-800">
                    Tinggi
                </h3>
                <p class="text-md text-gray-700">
                    Sangat melar, mengikuti bentuk tubuh. Contoh: Spandex/Lycra,
                    Karet, Kain jaring. Ideal untuk olahraga dan pakaian ketat.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Garis pemisah -->
<hr class="max-w-7xl mx-auto my-12 border-gray-300" />

<!-- Bagian Tekstur Bahan Pakaian -->
<section class="max-w-7xl mx-auto px-6 py-12">
    <div
        style="opacity: 1; transform: translateY(0px);">
        <h2 class="text-3xl md:text-4xl font-bold mb-8 text-blue-600 text-center">
            Tekstur Bahan Pakaian
        </h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6">
            <!-- Tekstur Halus -->
            <div class="bg-white shadow-lg rounded-lg p-4 text-center transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <img
                    src="<?= base_url('public/kainsutra.png') ?>"
                    alt="Tekstur Halus"
                    width="150"
                    height="130"
                    class="mx-auto mb-3 object-cover rounded-md"
                    loading="lazy" />
                <h3 class="text-lg font-semibold mb-1 text-gray-800">
                    Halus
                </h3>
                <p class="text-sm text-gray-700">
                    Permukaan licin dan rata. Contoh: Sutra, Katun Sateen. Nyaman di
                    kulit.
                </p>
            </div>

            <!-- Tekstur Licin -->
            <div class="bg-white shadow-lg rounded-lg p-4 text-center transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <img
                    src="<?= base_url('public/kainnilon.png') ?>"
                    alt="Tekstur Licin"
                    width="150"
                    height="130"
                    class="mx-auto mb-3 object-cover rounded-md"
                    loading="lazy" />
                <h3 class="text-lg font-semibold mb-1 text-gray-800">
                    Licin
                </h3>
                <p class="text-sm text-gray-700">
                    Cenderung tidak menempel, mudah jatuh. Contoh: Poliester, Nilon.
                    Tahan air.
                </p>
            </div>

            <!-- Tekstur Lembut -->
            <div class="bg-white shadow-lg rounded-lg p-4 text-center transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <img
                    src="<?= base_url('public/kainwol2.png') ?>"
                    alt="Tekstur Lembut"
                    width="150"
                    height="130"
                    class="mx-auto mb-3 object-cover rounded-md"
                    loading="lazy" />
                <h3 class="text-lg font-semibold mb-1 text-gray-800">
                    Lembut
                </h3>
                <p class="text-sm text-gray-700">
                    Nyaman disentuh, sering berbulu halus. Contoh: Wol, Fleece,
                    Beludru. Hangat dan empuk.
                </p>
            </div>

            <!-- Tekstur Berpori -->
            <div class="bg-white shadow-lg rounded-lg p-4 text-center transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <img
                    src="<?= base_url('public/kainkatun.png') ?>"
                    alt="Tekstur Berpori"
                    width="150"
                    height="130"
                    class="mx-auto mb-3 object-cover rounded-md"
                    loading="lazy" />
                <h3 class="text-lg font-semibold mb-1 text-gray-800">
                    Berpori
                </h3>
                <p class="text-sm text-gray-700">
                    Ada rongga kecil, sirkulasi udara baik. Contoh: Katun, Linen,
                    Jaring. Menyerap keringat.
                </p>
            </div>

            <!-- Tekstur Kasar -->
            <div class="bg-white shadow-lg rounded-lg p-4 text-center transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <img
                    src="<?= base_url('public/kaindenim.png') ?>"
                    alt="Tekstur Kasar"
                    width="150"
                    height="130"
                    class="mx-auto mb-3 object-cover rounded-md"
                    loading="lazy" />
                <h3 class="text-lg font-semibold mb-1 text-gray-800">
                    Kasar
                </h3>
                <p class="text-sm text-gray-700">
                    Permukaan tidak rata, terasa bertekstur. Contoh: Denim, Goni,
                    Corduroy. Kuat dan tahan lama.
                </p>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const texts = [
            "Klasifikasi Bahan Pakaian",
            "Deteksi Katun, Linen, Poliester, dan Lainnya",
            "Cepat, Akurat, dan Otomatis"
        ];
        const speed = 100; // kecepatan ketik (ms)
        const eraseSpeed = 50; // kecepatan hapus (ms)
        const delayBetween = 1500; // jeda sebelum hapus (ms)

        let textIndex = 0;
        let charIndex = 0;
        let isDeleting = false;
        const typewriterElement = document.getElementById("typewriter");

        function typeEffect() {
            const currentText = texts[textIndex];

            if (isDeleting) {
                typewriterElement.textContent = currentText.substring(0, charIndex - 1);
                charIndex--;
                if (charIndex === 0) {
                    isDeleting = false;
                    textIndex = (textIndex + 1) % texts.length; // pindah teks berikutnya
                }
            } else {
                typewriterElement.textContent = currentText.substring(0, charIndex + 1);
                charIndex++;
                if (charIndex === currentText.length) {
                    isDeleting = true;
                    setTimeout(typeEffect, delayBetween);
                    return;
                }
            }
            setTimeout(typeEffect, isDeleting ? eraseSpeed : speed);
        }

        typeEffect();
    });

    document.getElementById("btn-lebih-lanjut").addEventListener("click", function() {
        document.getElementById("elastisitas").scrollIntoView({
            behavior: "smooth"
        });
    });
</script>


<?= $this->endSection(); ?>