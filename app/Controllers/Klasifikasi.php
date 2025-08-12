<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\HistoryModel; // ganti model agar sesuai tabel tanpa user_id

class Klasifikasi extends BaseController
{
    use ResponseTrait;

    protected $pythonBackendUrl = 'http://127.0.0.1:5001';

    public function index()
    {
        $data = [
            'title' => 'Klasifikasi Bahan Pakaian - SVM'
        ];
        return view('klasifikasi/index', $data);
    }

    public function getModelInfo()
    {
        if (!$this->request->isAJAX()) {
            return $this->failForbidden('Akses tidak diizinkan.');
        }
        try {
            $client = \Config\Services::curlrequest();
            $response = $client->get($this->pythonBackendUrl . '/info', ['timeout' => 10]);
            return $this->response->setJSON($response->getBody());
        } catch (\Exception $e) {
            log_message('error', '[Klasifikasi API Error] getModelInfo: ' . $e->getMessage());
            return $this->failServerError('Tidak dapat terhubung ke server klasifikasi.');
        }
    }

    public function predict()
    {
        if (!$this->request->isAJAX() || $this->request->getMethod() !== 'post') {
            return $this->failForbidden('Akses tidak diizinkan.');
        }

        $inputData = $this->request->getJSON(true);

        try {
            $client = \Config\Services::curlrequest();
            $response = $client->post($this->pythonBackendUrl . '/predict', [
                'json' => $inputData,
                'timeout' => 15
            ]);
            return $this->response->setJSON($response->getBody());
        } catch (\Exception $e) {
            log_message('error', '[Klasifikasi API Error] predict: ' . $e->getMessage());
            return $this->failServerError('Gagal melakukan prediksi. Tidak dapat terhubung ke server.');
        }
    }


    public function simpan()
    {
        // Wajib JSON
        if (stripos($this->request->getHeaderLine('Content-Type') ?? '', 'application/json') === false) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'messages' => ['error' => 'Content-Type harus application/json'],
                'csrf' => csrf_hash()
            ]);
        }

        $payload = $this->request->getJSON(true); // assoc array
        if (!$payload) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'messages' => ['error' => 'Payload JSON tidak valid'],
                'csrf' => csrf_hash()
            ]);
        }

        $input      = $payload['input']      ?? [];
        $prediction = $payload['prediction'] ?? [];
        $conf       = $prediction['confidence'] ?? [];

        // Validasi minimal
        $errors = [];
        if (empty($input['elastisitas']))  $errors['elastisitas']   = 'Elastisitas wajib diisi.';
        if (empty($input['tekstur']))      $errors['tekstur']       = 'Tekstur wajib diisi.';
        if ($input['ketebalan'] === null || $input['ketebalan'] === '' || !is_numeric($input['ketebalan']))
            $errors['ketebalan'] = 'Ketebalan wajib angka.';
        if (empty($prediction['bahanKain']))    $errors['bahan_kain']    = 'Prediksi bahan kain kosong.';
        if (empty($prediction['jenisPakaian'])) $errors['jenis_pakaian'] = 'Prediksi jenis pakaian kosong.';

        if ($errors) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'error',
                'messages' => $errors,
                'csrf' => csrf_hash()
            ]);
        }

        $data = [
            'elastisitas'        => (string) $input['elastisitas'],
            'tekstur'            => (string) $input['tekstur'],
            'ketebalan'          => (float)  $input['ketebalan'],
            'bahan_kain'         => (string) $prediction['bahanKain'],
            'jenis_pakaian'      => (string) $prediction['jenisPakaian'],
            'conf_bahan_kain'    => isset($conf['bahanKain'])    ? (float) $conf['bahanKain']    : null,
            'conf_jenis_pakaian' => isset($conf['jenisPakaian']) ? (float) $conf['jenisPakaian'] : null,
            'raw_json'           => json_encode($payload, JSON_UNESCAPED_UNICODE),
        ];

        $model = new HistoryModel();
        try {
            $model->insert($data);
        } catch (\Throwable $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'messages' => ['error' => 'Gagal menyimpan ke database: ' . $e->getMessage()],
                'csrf' => csrf_hash()
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Hasil klasifikasi berhasil disimpan ke history.',
            'csrf' => csrf_hash() // kirim token baru
        ]);
    }
}
