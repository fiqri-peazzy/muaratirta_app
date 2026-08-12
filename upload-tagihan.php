<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['tagihan_image'])) {
    $uploadDir = 'uploads/tagihan/';

    // Buat folder jika belum ada
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $file = $_FILES['tagihan_image'];
    $fileName = 'tagihan_' . time() . '_' . uniqid() . '.png';
    $filePath = $uploadDir . $fileName;

    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        $fileUrl = 'https://' . $_SERVER['HTTP_HOST'] . '/' . $filePath;

        echo json_encode([
            'success' => true,
            'url' => $fileUrl,
            'fileName' => $fileName
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Gagal upload gambar'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request'
    ]);
}
