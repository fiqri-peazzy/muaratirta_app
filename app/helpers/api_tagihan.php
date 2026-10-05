<?php

function getTagihanDetail($id_pel)
{
    $baseUrl = $_ENV['TAGIHAN_API_URL'] ?? 'http://gorontalo.homeip.net/webapi/pelanggan/getTagihanDetail';
    return callPelangganApi($baseUrl, $id_pel, 'getTagihanDetail');
}

/**
 * Ambil nilai retribusi pelanggan. Retribusi adalah nilai tersendiri
 * (tidak termasuk di TAGIHAN), jadi harus ditambahkan ke total tagihan.
 *
 * @return int|null Nilai retribusi, atau null jika gagal diambil dari API
 */
function getRetribusiPelanggan($id_pel)
{
    $baseUrl = $_ENV['RETRIBUSI_API_URL'] ?? 'http://103.133.223.242/webapinew/pelanggan/getRetribusiPelanggan';
    $data = callPelangganApi($baseUrl, $id_pel, 'getRetribusiPelanggan');

    if (($data['status'] ?? null) !== 'true') {
        return null;
    }

    return (int) ($data['pelanggan'][0]['RETRIB'] ?? 0);
}

function callPelangganApi($baseUrl, $id_pel, $label)
{
    // Validasi ketat: fungsi ini menyusun URL ke API eksternal, jadi $id_pel wajib
    // numeric saja sebelum dipakai (menutup celah injeksi parameter/URL sekalipun
    // pemanggil saat ini sudah validasi juga - defense in depth).
    if (!is_numeric($id_pel)) {
        return ['status' => false, 'message' => 'No Sambung tidak valid'];
    }

    $token = $_ENV['TAGIHAN_API_TOKEN'] ?? '';
    $url = $baseUrl . '?token=' . urlencode($token) . '&nosamw=' . urlencode($id_pel);
    $headers = array(
        "Content-Type: application/json; charset=UTF-8"
    );

    if (function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($response === false) {
            error_log($label . ' curl error: ' . $curlError);
            return ['status' => false, 'message' => 'Gagal menghubungi server API'];
        }
        if ($httpCode < 200 || $httpCode >= 300) {
            error_log($label . ' HTTP ' . $httpCode . ' for id_pel=' . $id_pel);
            return ['status' => false, 'message' => 'Server API mengembalikan error'];
        }
    } else {
        // Fallback using file_get_contents if cURL is disabled
        $options = [
            'http' => [
                'method' => 'GET',
                'header' => implode("\r\n", $headers),
                'timeout' => 10
            ]
        ];
        $response = @file_get_contents($url, false, stream_context_create($options));

        if ($response === false) {
            return ['status' => false, 'message' => 'Gagal menghubungi server API'];
        }
    }

    $decoded = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log($label . ' invalid JSON response for id_pel=' . $id_pel);
        return ['status' => false, 'message' => 'Respon server API tidak valid'];
    }

    return $decoded;
}
