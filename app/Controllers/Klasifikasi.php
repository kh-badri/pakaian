<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\CURLRequest;
use CodeIgniter\API\ResponseTrait;
use App\Models\PredictionHistoryModel; // Import model histori

class Klasifikasi extends BaseController
{
    use ResponseTrait; // Menggunakan ResponseTrait untuk kemudahan respons JSON

    // URL Backend Python untuk proyek klasifikasi
    protected $pythonBackendUrl = 'http://127.0.0.1:5001';

    /**
     * Constructor untuk inisialisasi dan pengecekan login.
     */
    public function __construct()
    {
        // Memastikan user sudah login sebelum mengakses halaman klasifikasi
        // Jika Anda menggunakan filter 'auth' di routes.php, ini bisa menjadi validasi tambahan.
        if (!session()->get('isLoggedIn')) {
            // Menggunakan redirect() dari helper URL untuk pengalihan yang lebih bersih
            header('Location: ' . base_url('login'));
            exit();
        }
    }

    /**
     * Menampilkan halaman utama untuk klasifikasi.
     * Metode ini hanya me-load view dan melewatkan data sesi.
     */
    public function index()
    {
        $data = [
            'title' => 'Klasifikasi Bahan Pakaian - SVM',
            'user_data' => [
                'username' => session()->get('username') ?? 'User' // Ambil username dari sesi
            ]
        ];

        return view('klasifikasi/index', $data);
    }

    //--------------------------------------------------------------------

    /**
     * Mengambil informasi model dan dataset dari backend Python.
     * Endpoint ini dipanggil oleh AJAX (fetch API) dari view 'klasifikasi/index'.
     */
    public function getModelInfo()
    {
        // Pastikan request datang dari AJAX untuk keamanan
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON(['message' => 'Akses tidak diizinkan.']);
        }

        $client = \Config\Services::curlrequest(); // Menggunakan CodeIgniter's CURLRequest
        $apiUrl = $this->pythonBackendUrl . '/info';

        try {
            // Mengirim permintaan GET ke endpoint /info Python
            $response = $client->get($apiUrl, [
                'timeout' => 10, // Batas waktu 10 detik
                'headers' => [
                    'X-Requested-With' => 'XMLHttpRequest', // Menandakan ini adalah AJAX request
                    'X-CSRF-TOKEN' => csrf_hash() // Mengirim CSRF token (penting untuk sesi CI4)
                ]
            ]);

            // Memeriksa status kode HTTP dari API Python
            if ($response->getStatusCode() === 200) {
                // Mengembalikan respons JSON langsung dari backend Python
                return $this->response->setJSON(json_decode($response->getBody(), true));
            } else {
                // Menangani jika API Python mengembalikan status error
                return $this->response->setStatusCode($response->getStatusCode())->setJSON([
                    'success' => false,
                    'message' => 'Gagal mendapatkan info model dari API Python.',
                    'raw_response' => $response->getBody() // Untuk debugging
                ]);
            }
        } catch (\Exception $e) {
            // Menangani error jaringan atau timeout
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memanggil API Python: ' . $e->getMessage()
            ]);
        }
    }

    //--------------------------------------------------------------------

    /**
     * Mengirim data input dari pengguna ke backend Python untuk prediksi.
     * Endpoint ini dipanggil oleh AJAX (fetch API) dari view 'klasifikasi/index'.
     */
    public function predict()
    {
        // Pastikan request datang dari AJAX dan menggunakan metode POST
        if (!$this->request->isAJAX() || $this->request->getMethod() !== 'post') {
            return $this->response->setStatusCode(403)->setJSON(['message' => 'Akses tidak diizinkan.']);
        }

        // Ambil data JSON dari body request
        $inputData = $this->request->getJSON(true);

        // Validasi input dasar
        if (!isset($inputData['Elastisitas']) || !isset($inputData['Tekstur']) || !isset($inputData['Ketebalan'])) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Data input tidak lengkap.'
            ]);
        }

        // Validasi rentang ketebalan
        $ketebalan = floatval($inputData['Ketebalan']);
        if ($ketebalan < 0.2 || $ketebalan > 2.0) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Ketebalan harus dalam rentang 0.2 - 2.0 mm.'
            ]);
        }

        $client = \Config\Services::curlrequest();
        $apiUrl = $this->pythonBackendUrl . '/predict';

        try {
            // Mengirim permintaan POST ke endpoint /predict Python
            $response = $client->post($apiUrl, [
                'json' => $inputData, // Mengirim data input dalam format JSON
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'X-Requested-With' => 'XMLHttpRequest', // Menandakan ini adalah AJAX request
                    'X-CSRF-TOKEN' => csrf_hash() // Mengirim CSRF token
                ],
                'timeout' => 15 // Batas waktu 15 detik untuk prediksi
            ]);

            // Memeriksa status kode HTTP dari API Python
            if ($response->getStatusCode() === 200) {
                // Mengembalikan respons JSON langsung dari backend Python
                return $this->response->setJSON(json_decode($response->getBody(), true));
            } else {
                // Menangani jika API Python mengembalikan status error
                return $this->response->setStatusCode($response->getStatusCode())->setJSON([
                    'success' => false,
                    'message' => 'Prediksi gagal. Respon dari API Python tidak valid.',
                    'raw_response' => $response->getBody() // Untuk debugging
                ]);
            }
        } catch (\Exception $e) {
            // Menangani error jaringan atau timeout
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memanggil API Python: ' . $e->getMessage()
            ]);
        }
    }

    //--------------------------------------------------------------------

    /**
     * Menyimpan hasil prediksi ke tabel histori `prediction_history`.
     * Endpoint ini dipanggil oleh AJAX (fetch API) dari view 'klasifikasi/index'.
     */
    public function saveHistory()
    {
        // Pastikan request datang dari AJAX dan menggunakan metode POST
        if (!$this->request->isAJAX() || $this->request->getMethod() !== 'post') {
            return $this->response->setStatusCode(403)->setJSON(['message' => 'Akses tidak diizinkan.']);
        }

        // Ambil data JSON dari body request
        $dataToSave = $this->request->getJSON(true);

        // Validasi data yang diterima dari frontend
        if (empty($dataToSave) || !isset($dataToSave['input']) || !isset($dataToSave['prediction'])) {
            return $this->failValidationError('Data yang dikirim tidak lengkap untuk disimpan.');
        }

        $historyModel = new PredictionHistoryModel();
        // Asumsi user ID disimpan di sesi setelah login
        $userId = session()->get('id');

        // Siapkan data untuk disimpan ke database
        $insertData = [
            'user_id' => $userId,
            'input_elastisitas' => $dataToSave['input']['elastisitas'] ?? null,
            'input_tekstur' => $dataToSave['input']['tekstur'] ?? null,
            'input_ketebalan' => $dataToSave['input']['ketebalan'] ?? null,
            'predicted_bahan_kain' => $dataToSave['prediction']['bahanKain'] ?? null,
            'predicted_jenis_pakaian' => $dataToSave['prediction']['jenisPakaian'] ?? null,
            'confidence_bahan_kain' => $dataToSave['prediction']['confidence']['bahanKain'] ?? null,
            'confidence_jenis_pakaian' => $dataToSave['prediction']['confidence']['jenisPakaian'] ?? null,
            // 'prediction_time' akan otomatis diisi oleh database karena DEFAULT CURRENT_TIMESTAMP
        ];

        try {
            // Lakukan insert data ke tabel histori
            if ($historyModel->insert($insertData)) {
                return $this->respondCreated(['success' => true, 'message' => 'Data histori berhasil disimpan.']);
            } else {
                // Jika insert gagal (misal karena validasi model atau error DB lain)
                return $this->fail('Gagal menyimpan data histori ke database.', 500);
            }
        } catch (\Exception $e) {
            // Tangani error level database
            return $this->fail('Terjadi kesalahan database saat menyimpan histori: ' . $e->getMessage(), 500);
        }
    }
}
