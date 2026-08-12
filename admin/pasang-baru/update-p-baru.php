<?php
require_once('../../path.php');
require_once(ROOT_PATH . '/app/db/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $update = update('pasang_baru', $id, ['tindak_lanjut' => 1]);
    if ($update) {
        $pasang_baru = selectOne('pasang_baru', ['id' => $id]);
        $newStatus =  $pasang_baru['tindak_lanjut'];
        $response = array('success' => 1, 'msg' => 'Sukses, Status Berhasil Di perbarui', 'status' => $newStatus);
        echo json_encode($response);
    } else {
        $response = array('success' => 0, 'msg' => 'Gagal Perbarui Status', 'status' => $newStatus);
        echo json_encode($response);
    }
} else {
    $response = array('success' => 0, 'error' => 'Permintaan tidak valid.');
    echo json_encode($response);
}