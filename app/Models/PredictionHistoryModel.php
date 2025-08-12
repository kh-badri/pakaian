<?php

namespace App\Models;

use CodeIgniter\Model;

class PredictionHistoryModel extends Model
{
    protected $table            = 'prediction_history';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    // Pastikan semua kolom ini SAMA PERSIS dengan di tabel database Anda
    protected $allowedFields    = [
        'user_id',
        'input_elastisitas',
        'input_tekstur',
        'input_ketebalan',
        'predicted_bahan_kain',
        'confidence_bahan_kain',
        'predicted_jenis_pakaian',
        'confidence_jenis_pakaian',
    ];

    // Konfigurasi Timestamps
    protected $useTimestamps = false; // Kita menggunakan default dari database
}
