<?php

function getTagihanDetail($id_pel)
{
    $url = 'http://gorontalo.homeip.net/webapi/pelanggan/getTagihanDetail?token=5d659eef91487eb4d4c4181d51977mkm&nosamw=' . $id_pel;
    $headers = array(
        "Content-Type: application/json; charset=UTF-8"
    );

    if (function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($ch);
        curl_close($ch);
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
    }

    if ($response === false) {
        return ['status' => false, 'message' => 'Gagal menghubungi server API'];
    }

    return json_decode($response, true);
}