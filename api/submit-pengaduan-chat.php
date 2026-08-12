<?php

/**
 * Submit Pengaduan dari Chat
 * Endpoint untuk menyimpan pengaduan ke database
 */

require('../path.php');
require_once(ROOT_PATH . '/app/db/db.php');
require_once(ROOT_PATH . '/app/helpers/r2_helper.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Method not allowed'
    ]);
    exit;
}

$errors = [];

// Validasi input
$id_pel = isset($_POST['id_pel']) ? trim($_POST['id_pel']) : '';
$nm_lengkap = isset($_POST['nm_lengkap']) ? trim($_POST['nm_lengkap']) : '';
$alamat = isset($_POST['alamat']) ? trim($_POST['alamat']) : '';
$no_hp = isset($_POST['no_hp']) ? trim($_POST['no_hp']) : '';
$isi_pengaduan = isset($_POST['isi_pengaduan']) ? trim($_POST['isi_pengaduan']) : '';

// Validasi field wajib
if (empty($id_pel)) {
    $errors[] = 'Nomor Pelanggan wajib diisi';
}

if (empty($nm_lengkap)) {
    $errors[] = 'Nama Lengkap wajib diisi';
}

if (empty($alamat)) {
    $errors[] = 'Alamat wajib diisi';
}

if (empty($no_hp)) {
    $errors[] = 'Nomor HP wajib diisi';
}

if (empty($isi_pengaduan)) {
    $errors[] = 'Isi Pengaduan wajib diisi';
}

// Handle upload foto (opsional)
$foto = null;
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    $maxSize = 5 * 1024 * 1024; // 5MB

    if (!in_array($_FILES['foto']['type'], $allowedTypes)) {
        $errors[] = 'Format foto harus JPG, JPEG, atau PNG';
    }

    if ($_FILES['foto']['size'] > $maxSize) {
        $errors[] = 'Ukuran foto maksimal 5MB';
    }

    if (count($errors) == 0) {
        $extension = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $filename = 'pengaduan_' . time() . '_' . uniqid() . '.' . $extension;

        if (uploadToR2($_FILES['foto']['tmp_name'], 'pengaduan', $filename)) {
            $foto = $filename;
        } else {
            $errors[] = 'Gagal upload foto';
        }
    }
}

// Jika ada error, return error
if (count($errors) > 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Validasi gagal',
        'errors' => $errors
    ]);
    exit;
}

// Simpan ke database menggunakan tabel pengaduan yang sudah ada
$data = [
    'id_pel' => $id_pel,
    'nm_lengkap' => $nm_lengkap,
    'alamat' => $alamat,
    'no_hp' => $no_hp,
    'isi_pengaduan' => $isi_pengaduan,
    'status' => '0' // Status default: belum diproses
];

if ($foto) {
    $data['foto'] = $foto;
}

$insertId = create('pengaduan', $data);

if ($insertId) {
    echo json_encode([
        'success' => true,
        'message' => 'Pengaduan berhasil dikirim. Tim kami akan segera menindaklanjuti.',
        'id' => $insertId
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Gagal menyimpan pengaduan. Silakan coba lagi.'
    ]);
}