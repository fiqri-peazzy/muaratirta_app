<?php
$noSambung = $_GET['id'] ?? '';
$url = "http://103.133.223.242/sister-gto/api/uploads/rumah/" . urlencode($noSambung) . ".jpg";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$data = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode == 200 && $data) {
    header("Content-Type: image/jpeg");
    echo $data;
} else {
    http_response_code(404);
    echo "Not Found";
}
?>
