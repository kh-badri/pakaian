<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= esc($title ?? 'Pola Tidur App') ?></title>

    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <style>
        #page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #ffffff;
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: opacity 0.3s, visibility 0.3s;
        }

        #page-loader.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .spinner {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #3b82f6;
            border-radius: 50%;
            width: 80px;
            height: 80px;
            animation: spin 1.5s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800">

    <div id="page-loader">
        <div class="spinner"></div>
    </div>

    <?= $this->include('layout/navbar') ?>
    <div class="flex flex-col min-h-screen">


        <div class="flex flex-1">
            <main class="flex-1 p-4 sm:p-6">
                <?= $this->renderSection('content') ?>
            </main>
        </div>

        <?= $this->include('layout/footer') ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Sembunyikan page loader setelah halaman dimuat
        window.addEventListener('load', function() {
            document.getElementById('page-loader').classList.add('hidden');
        });

        // Logika untuk notifikasi SweetAlert dari flashdata
        <?php if ($success = session()->getFlashdata('success')) : ?>
            Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: '<?= esc($success, 'js') ?>',
                timer: 2500,
                showConfirmButton: false
            });
        <?php endif; ?>
    </script>

</body>

</html>