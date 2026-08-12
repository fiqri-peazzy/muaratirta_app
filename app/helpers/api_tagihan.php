<?php

function getTagihanDetail($id_pel)
{
    // Validasi ketat: fungsi ini menyusun URL ke API eksternal, jadi $id_pel wajib
    // numeric saja sebelum dipakai (menutup celah injeksi parameter/URL sekalipun
    // pemanggil saat ini sudah validasi juga - defense in depth).
    if (!is_numeric($id_pel)) {
        return ['status' => false, 'message' => 'No Sambung tidak valid'];
    }

    $baseUrl = $_ENV['TAGIHAN_API_URL'] ?? 'http://gorontalo.homeip.net/webapi/pelanggan/getTagihanDetail';
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
            error_log('getTagihanDetail curl error: ' . $curlError);
            return ['status' => false, 'message' => 'Gagal menghubungi server API'];
        }
        if ($httpCode < 200 || $httpCode >= 300) {
            error_log('getTagihanDetail HTTP ' . $httpCode . ' for id_pel=' . $id_pel);
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
        error_log('getTagihanDetail invalid JSON response for id_pel=' . $id_pel);
        return ['status' => false, 'message' => 'Respon server API tidak valid'];
    }

    return $decoded;
}