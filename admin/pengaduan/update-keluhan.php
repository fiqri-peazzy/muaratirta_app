<?php
require_once('../../path.php');
require_once(ROOT_PATH . '/app/db/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $update = update('pengaduan', $id, ['status' => 1]);
    if ($update) {
        $pengaduan = selectOne('pengaduan', ['id' => $id]);
        $newStatus =  $pengaduan['status'];
        $response = array('success' => 1, 'msg' => 'Sukses, Status Keluhan Berhasil Di perbarui', 'status' => $newStatus);
        echo json_encode($response);
    } else {
        $response = array('success' => 0, 'msg' => 'Gagal Perbarui Status Keluhan', 'status' => $newStatus);
        echo json_encode($response);
    }
} else {
    $response = array('success' => 0, 'error' => 'Permintaan tidak valid.');
    echo json_encode($response);
}