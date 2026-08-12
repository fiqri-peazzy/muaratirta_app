<?php

include(ROOT_PATH . '/app/db/db.php');

if (isset($_POST['add-bagian'])) {
    unset($_POST['add-bagian']);
    $errors = [];
    $is_exist = [];

    $unique_number = rand(1000, 9999);
    $bagian = selectAll('jabatan');

    foreach ($bagian as $bgn) {
        $is_exist[] = $bgn['bagian'];
    }
    if (empty($_POST['bagian']) || $_POST['bagian'] == '') {
        $errors['bagian'] = 'Bagian Tidak Boleh Kosong';
    }

    if (in_array($_POST['bagian'], $is_exist)) {
        $errors['bagian'] = 'Bagian Telah ada !';
    }

    if (count($errors) === 0) {
        $add = create('jabatan', ['kd_bagian' => 'BGN-' . $unique_number, 'bagian' => $_POST['bagian']]);


        $_SESSION['message'] = 'Berhasil Tambah Bagian';
        $_SESSION['type'] = 'success';
        header('Location:' . BASE_URL . '/admin/struktur-organisasi/add-bagian.php');
        exit();
    } else {
        $_SESSION['message'] = $errors['bagian'];
        $_SESSION['type'] = 'error';
        header('Location:' . BASE_URL . '/admin/struktur-organisasi/add-bagian.php');
        exit();
    }
}

if (isset($_POST['edit-bagian'])) {
    unset($_POST['edit-bagian']);
    $kd_bagian = $_POST['kd_bagian'];

    $errors = [];
    $is_exist = [];

    $bagian = selectAll('jabatan');



    foreach ($bagian as $bgn) {
        $is_exist[] = $bgn['bagian'];
    }
    if (empty($_POST['bagian']) || $_POST['bagian'] === '') {
        $errors['bagian'] = 'Bagian Wajib di isi';
    }
    $bgn = selectOne('jabatan', ['kd_bagian' => $kd_bagian]);

    if ($_POST['bagian'] !== $bgn['bagian']) {
        if (in_array($_POST['bagian'], $is_exist)) {
            $errors['bagian'] = 'Bagian Telah ada';
        }
    }

    if ($_POST['bagian'] == $bgn['bagian']) {
        $errors['bagian'] = 'Something Went Wrong';
    }

    if (count($errors) === 0) {
        $edit = update('jabatan', $bgn['id'], ['bagian' => $_POST['bagian']]);


        $_SESSION['message'] = 'Berhasil Update Bagian';
        $_SESSION['type'] = 'success';
        header('Location:' . BASE_URL . '/admin/struktur-organisasi/edit-bagian.php?id=' . $bgn['kd_bagian']);
        exit();
    } else {
        $_SESSION['message'] = $errors['bagian'];
        $_SESSION['type'] = 'error';
        header('Location:' . BASE_URL . '/admin/struktur-organisasi/edit-bagian.php?id=' . $bgn['kd_bagian']);
        exit();
    }
}