<?php

include(ROOT_PATH . '/app/db/db.php');
require_once(ROOT_PATH . '/app/helpers/r2_helper.php');

if (isset($_POST['add-gallery'])) {

    if (!empty($_FILES['image']['name'])) {
        $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $image = time() . "_" . uniqid() . "." . $extension;

        $results = uploadImageToR2($_FILES['image']['tmp_name'], 'galeri', $image);

        if ($results) {
            $_POST['image'] = $image;
        }
    }

    $judul = $_POST['judul'];
    $img = $_POST['image'] ?? '';

    if (!empty($judul) && !empty($img)) {
        create('galeri', [
            'judul' => $judul,
            'image' => $img,
        ]);

        $_SESSION['message'] = 'Berhasil Tambah data';
        $_SESSION['type'] = 'success';
        header('Location:' . BASE_URL . '/admin/galeri.php');
        exit();
    } else {
        $_SESSION['message'] = 'Gagal Tambah data';
        $_SESSION['type'] = 'error';
    }
}
if (isset($_GET['hapus-img'])) {

    $g_info = selectOne('galeri', ['id' => $_GET['hapus-img']]);
    if (!empty($g_info['image'])) {
        $legacyPath = ROOT_PATH . '/assets/galeri/' . $g_info['image'];
        if (file_exists($legacyPath)) {
            unlink($legacyPath);
        }
        deleteFromR2('galeri', $g_info['image']);
    }
    $count = deleteF('galeri', $_GET['hapus-img']);
    header('Location:' . BASE_URL . '/admin/galeri.php');
}