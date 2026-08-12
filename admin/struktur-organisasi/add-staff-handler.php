<?php


include('../../path.php');

require_once(ROOT_PATH . '/app/db/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    $is_exist = [];
    foreach (selectAll('staff') as $i) {
        $is_exist[] = $i['nm_lengkap'];
    }

    if (empty($_POST['nm_lengkap'])) {
        $errors['nm_lengkap'] = 'Nama Wajib Di isi';
    } elseif (in_array($_POST['nm_lengkap'], $is_exist)) {
        $errors['nm_lengkap'] = 'Nama ' . $_POST['nm_lengkap'] . ' Telah Ada';
    }

    if (empty($_POST['kd_bagian'])) {
        $errors['kd_bagian'] = 'Mohon Pilih Salah Satu Bagian';
    }

    if (empty($_POST['jabatan'])) {
        $errors['jabatan'] = 'Jabatan Wajib diisi';
    }


    if (!empty($_FILES['profile_pict']['name'])) {
        $allowed_extensions = array('jpg', 'jpeg', 'png');

        $file_extension = strtolower(pathinfo($_FILES['profile_pict']['name'], PATHINFO_EXTENSION));

        if (!in_array($file_extension, $allowed_extensions)) {
            $errors['profile_pict'] = 'Upload file image (.jpg, .png)';
        } else {
            $image = "UIMG_" . time() . '_' . $_FILES['profile_pict']['name'];
            $path = ROOT_PATH . '/assets/staff/';
            $destination = $path . $image;
            if (move_uploaded_file($_FILES['profile_pict']['tmp_name'], $destination)) {
                $_POST['profile_pict'] = $image;
            }
        }
    }

    if (count($errors) === 0) {
        $create = create('staff', $_POST);
        if ($create) {
            echo json_encode(['status' => 1, 'msg' => 'Sukses, Berhasil Tambah Staff']);
        } else {
            echo json_encode(['status' => 0, 'msg' => 'Somethin Went Wrong']);
        }
    } else {
        echo json_encode(['status' => 0, 'error' => $errors]);
    }
}