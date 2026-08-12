<?php

include(ROOT_PATH . '/app/db/db.php');

if (isset($_POST['add-gallery'])) {

    if (!empty($_FILES['image']['name'])) {
        $image = time() . "_" . $_FILES['image']['name'];
        $destination = ROOT_PATH . "/assets/galeri/" . $image;

        $results = move_uploaded_file($_FILES['image']['tmp_name'], $destination);

        if ($results) {
            $_POST['image'] = $image;
        }
    }

    $judul = $_POST['judul'];
    $img = $_POST['image'];

    if (!empty($judul) && !empty($img)) {
        $sql = "INSERT INTO galeri (judul,image) VALUES ('$judul','$img')";

        $conn->query($sql);

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
    $path = ROOT_PATH . '/assets/galeri/' . $g_info['image'];
    if (file_exists($path)) {
        unlink($path);
    }
    $count = deleteF('galeri', $_GET['hapus-img']);
    header('Location:' . BASE_URL . '/admin/galeri.php');
}