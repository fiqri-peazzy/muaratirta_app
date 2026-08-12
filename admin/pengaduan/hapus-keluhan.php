<?php
require_once('../../path.php');
require_once(ROOT_PATH . '/app/db/db.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $keluhan_id = selectOne('pengaduan', ['id' => $id]);
    $path = ROOT_PATH . '/assets/keluhan/' . $keluhan_id['foto'];
    if (file_exists($path) && $keluhan_id['foto'] !== null) {
        unlink($path);
    }

    $hapus = deleteF('pengaduan', $id);
    if ($hapus) {
        echo "berhasil Hapus";
    }
} elseif (isset($_POST['id_p'])) {
    $id = $_POST['id_p'];

    $db_info = selectOne('pasang_baru', ['id' => $id]);
    $path_foto_ktp = ROOT_PATH . '/assets/daftar-baru/' . $db_info['foto_ktp'];
    $path_foto_rumah = ROOT_PATH . '/assets/daftar-baru/' . $db_info['foto_rumah'];
    if (file_exists($path_foto_ktp) && file_exists($path_foto_rumah)) {
        unlink($path_foto_ktp);
        unlink($path_foto_rumah);
    }
    $hapus = deleteF('pasang_baru', $id);
    if ($hapus) {
        echo "Berhasil Hapus";
    }
}
