<?php
$url = 'http://127.0.0.1:5001/info';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($response === false) {
    echo "Gagal terhubung. Error cURL: " . $error;
} else {
    echo "Berhasil terhubung. HTTP Status Code: " . $httpcode . "<br>";
    echo "Response: " . $response;
}
