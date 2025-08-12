<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- RUTE YANG WAJIB LOGIN (Dijaga oleh 'auth') ---
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Home::index');
    $routes->get('home', 'Home::index');

    // Rute untuk halaman Klasifikasi
    $routes->get('Klasifikasi', 'Klasifikasi::index');
    $routes->post('Klasifikasi/proxy', 'Klasifikasi::proxy'); // Proxy untuk backend jika diperlukan
    $routes->get('Klasifikasi/model-info', 'Klasifikasi::getModelInfo'); // Get model info
    $routes->post('Klasifikasi/predict', 'Klasifikasi::predict'); // Predict endpoint

    // PERBAIKAN: Ganti saveHistory menjadi simpan
    $routes->post('klasifikasi/simpan', 'Klasifikasi::simpan'); // <-- DIPERBAIKI DI SINI

    // Alternative: Jika ingin tetap pakai saveHistory, pastikan method ada di controller
    // $routes->post('klasifikasi/saveHistory', 'Klasifikasi::saveHistory');
    $routes->get('history', 'History::index');
    $routes->post('history/update/(:num)', 'History::update/$1');  // via AJAX JSON
    $routes->post('history/delete/(:num)', 'History::delete/$1');  // via AJAX JSON

    // Rute untuk halaman Akun
    $routes->get('akun', 'Akun::index');
    $routes->post('akun/update_profil', 'Akun::updateProfil');
    $routes->post('akun/update_sandi', 'Akun::updateSandi');

    // --- RUTE UNTUK ANALISIS DATA ---
    $routes->get('analisis', 'AnalisisController::index', ['as' => 'analisis.index']);
    $routes->post('analisis/perform', 'AnalisisController::performAnalysis', ['as' => 'analisis.perform']);
});

// --- RUTE UNTUK TAMU (Dijaga oleh 'guest') ---
$routes->group('', ['filter' => 'guest'], function ($routes) {
    $routes->get('login', 'Auth::index');
    $routes->get('register', 'Auth::register');
});

// --- RUTE AKSI PUBLIK (Proses Login, Register, Logout) ---
$routes->post('login', 'Auth::login');
$routes->post('register', 'Auth::processRegister');
$routes->get('logout', 'Auth::logout');
