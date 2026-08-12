<?php
require_once('../../path.php');
require_once(ROOT_PATH . '/app/db/db.php');
require_once(ROOT_PATH . '/app/helpers/r2_helper.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $keluhan_id = selectOne('pengaduan', ['id' => $id]);
    if (!empty($keluhan_id['foto'])) {
        foreach (['assets/keluhan', 'image/pengaduan'] as $legacyDir) {
            $legacyPath = ROOT_PATH . '/' . $legacyDir . '/' . $keluhan_id['foto'];
            if (file_exists($legacyPath)) {
                unlink($legacyPath);
            }
        }
        deleteFromR2('pengaduan', $keluhan_id['foto']);
    }

    $hapus = deleteF('pengaduan', $id);
    if ($hapus) {
        echo "berhasil Hapus";
    }
} elseif (isset($_POST['id_p'])) {
    $id = $_POST['id_p'];

    $db_info = selectOne('pasang_baru', ['id' => $id]);
    foreach (['foto_ktp', 'foto_rumah'] as $field) {
        if (!empty($db_info[$field])) {
            $legacyPath = ROOT_PATH . '/assets/daftar-baru/' . $db_info[$field];
            if (file_exists($legacyPath)) {
                unlink($legacyPath);
            }
            deleteFromR2('daftar-baru', $db_info[$field]);
        }
    }
    $hapus = deleteF('pasang_baru', $id);
    if ($hapus) {
        echo "Berhasil Hapus";
    }
}
