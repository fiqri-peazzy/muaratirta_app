<?php

if (isset($_GET['lat']) && isset($_GET['long'])) {
    $lat = $_GET['lat'];
    $long = $_GET['long'];

    $url = "https://nominatim.openstreetmap.org/reverse?format=json&lat=" . $lat . "&lon=" . $long;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['User-Agent: my-application']);

    $response = curl_exec($ch);

    curl_close($ch);
    $data = json_decode($response, true);

    if (!empty($data)) {
        $address = isset($data['display_name']) ? $data['display_name'] : "Address not available";
        echo $address;
    } else {
        echo "null response";
    }
} else {
    echo "Invalid parameters";
}