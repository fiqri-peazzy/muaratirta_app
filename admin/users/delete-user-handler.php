<?php
include "../../path.php";
require_once(ROOT_PATH . '/app/helpers/middleware.php');
$me = adminAjaxOnly([1]);
require_once(ROOT_PATH . '/app/db/db.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === "GET" && !empty($_GET['id'])) {
    $id = (int) $_GET['id'];
    if ($id === (int) $me['id']) {
        echo json_encode(['status' => 0, 'msg' => 'Anda tidak bisa menghapus akun yang sedang dipakai.']);
        exit;
    }
    $delete = deleteF('users', $id);
    echo json_encode($delete
        ? ['status' => 1, 'msg' => 'Akun berhasil dihapus.']
        : ['status' => 0, 'msg' => 'Gagal menghapus akun.']);
    exit;
}

echo json_encode(['status' => 0, 'msg' => 'Permintaan tidak valid.']);
