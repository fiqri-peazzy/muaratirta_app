<?php

/**
 * Chat Handler API
 * Endpoint untuk handle chat dengan Gemini AI
 */

require('../path.php');
require_once(ROOT_PATH . '/app/db/db.php');
require_once(ROOT_PATH . '/app/helpers/gemini_helper.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Method not allowed'
    ]);
    exit;
}

// Ambil data dari request
$input = json_decode(file_get_contents('php://input'), true);
$message = isset($input['message']) ? trim($input['message']) : '';
$sessionId = isset($input['session_id']) ? $input['session_id'] : session_id();

// Validasi input
if (empty($message)) {
    echo json_encode([
        'success' => false,
        'message' => 'Pesan tidak boleh kosong'
    ]);
    exit;
}

// Deteksi intent
$intent = detectIntent($message);

// Get AI context dari database
$context = getAIContext();

// Call Gemini AI
$aiResponse = callGeminiAI($message, $context);

if ($aiResponse['success']) {
    $response = [
        'success' => true,
        'message' => $aiResponse['text'],
        'intent' => $intent,
        'session_id' => $sessionId
    ];

    // Simpan history chat
    saveChatHistory($sessionId, $message, $aiResponse['text'], $intent);
} else {
    $response = [
        'success' => false,
        'message' => 'Maaf, saat ini sistem sedang mengalami gangguan. Silakan coba lagi atau hubungi customer service kami.',
        'error' => $aiResponse['message'],
    ];
}

echo json_encode($response);
