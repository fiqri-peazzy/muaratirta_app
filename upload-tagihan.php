<?php
require_once(__DIR__ . '/path.php');
require_once(ROOT_PATH . '/app/helpers/r2_helper.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['tagihan_image'])) {
    $file = $_FILES['tagihan_image'];

    $validationError = validateImageUpload($file, ['png'], 5 * 1024 * 1024);
    if ($validationError !== null) {
        echo json_encode([
            'success' => false,
            'message' => $validationError
        ]);
        exit;
    }

    $fileName = 'tagihan_' . time() . '_' . uniqid() . '.png';

    if (uploadImageToR2($file['tmp_name'], 'tagihan', $fileName)) {
        echo json_encode([
            'success' => true,
            'url' => getR2Url('tagihan', $fileName),
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
