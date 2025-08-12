<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HistoryModel;

class History extends BaseController
{
    public function index()
    {
        $model = new HistoryModel();

        // pagination sederhana
        $perPage = (int) ($this->request->getGet('perPage') ?? 10);
        $page    = (int) ($this->request->getGet('page') ?? 1);

        $data = [
            'rows'      => $model->orderBy('created_at', 'DESC')->paginate($perPage, 'default', $page),
            'pager'     => $model->pager,
            'perPage'   => $perPage,
            'pageTitle' => 'Riwayat Klasifikasi',
        ];

        return view('history/index', $data);
    }

    public function update($id = null)
    {
        if (!$id) return $this->response->setStatusCode(400)->setJSON(['status' => 'error', 'message' => 'ID tidak valid', 'csrf' => csrf_hash()]);
        if (stripos($this->request->getHeaderLine('Content-Type'), 'application/json') === false) {
            return $this->response->setStatusCode(400)->setJSON(['status' => 'error', 'message' => 'Content-Type harus application/json', 'csrf' => csrf_hash()]);
        }
        $payload = $this->request->getJSON(true);
        if (!$payload) {
            return $this->response->setStatusCode(400)->setJSON(['status' => 'error', 'message' => 'Payload JSON tidak valid', 'csrf' => csrf_hash()]);
        }

        $data = [
            'elastisitas'        => trim($payload['elastisitas'] ?? ''),
            'tekstur'            => trim($payload['tekstur'] ?? ''),
            'ketebalan'          => (float) ($payload['ketebalan'] ?? 0),
            'bahan_kain'         => trim($payload['bahan_kain'] ?? ''),
            'jenis_pakaian'      => trim($payload['jenis_pakaian'] ?? ''),
            'conf_bahan_kain'    => isset($payload['conf_bahan_kain'])    ? (float) $payload['conf_bahan_kain']    : null,
            'conf_jenis_pakaian' => isset($payload['conf_jenis_pakaian']) ? (float) $payload['conf_jenis_pakaian'] : null,
        ];

        // validasi minimal
        foreach (['elastisitas', 'tekstur', 'bahan_kain', 'jenis_pakaian'] as $f) {
            if ($data[$f] === '') return $this->response->setStatusCode(422)->setJSON(['status' => 'error', 'message' => "$f wajib diisi", 'csrf' => csrf_hash()]);
        }
        if (!is_numeric($data['ketebalan']) || $data['ketebalan'] <= 0) {
            return $this->response->setStatusCode(422)->setJSON(['status' => 'error', 'message' => 'ketebalan tidak valid', 'csrf' => csrf_hash()]);
        }

        $model = new HistoryModel();
        if (!$model->find($id)) return $this->response->setStatusCode(404)->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan', 'csrf' => csrf_hash()]);

        try {
            $model->update($id, $data);
            return $this->response->setJSON(['status' => 'success', 'message' => 'Data berhasil diperbarui', 'csrf' => csrf_hash()]);
        } catch (\Throwable $e) {
            return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'message' => $e->getMessage(), 'csrf' => csrf_hash()]);
        }
    }

    public function delete($id = null)
    {
        if (!$id) return $this->response->setStatusCode(400)->setJSON(['status' => 'error', 'message' => 'ID tidak valid', 'csrf' => csrf_hash()]);
        $model = new HistoryModel();
        if (!$model->find($id)) return $this->response->setStatusCode(404)->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan', 'csrf' => csrf_hash()]);
        try {
            $model->delete($id);
            return $this->response->setJSON(['status' => 'success', 'message' => 'Data berhasil dihapus', 'csrf' => csrf_hash()]);
        } catch (\Throwable $e) {
            return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'message' => $e->getMessage(), 'csrf' => csrf_hash()]);
        }
    }
}
