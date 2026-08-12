<?php

include('../../path.php');
require_once(ROOT_PATH . '/app/db/db.php');
require_once(ROOT_PATH . '/app/helpers/r2_helper.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $errors = [];
    $is_exist = [];
    foreach (selectAll('staff') as $i) {
        $is_exist[] = $i['nm_lengkap'];
    }

    if (empty($_POST['nm_lengkap'])) {
        $errors['nm_lengkap'] = 'Nama Wajib Di isi';
    }

    if (selectOne('staff', ['id' => $id])['nm_lengkap'] !== $_POST['nm_lengkap']) {
        if (in_array($_POST['nm_lengkap'], $is_exist)) {
            $errors['nm_lengkap'] = 'Nama ' . $_POST['nm_lengkap'] . ' Telah Ada';
        }
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
            $old_staff = selectOne('staff', ['id' => $id]);
            $image = "UIMG_" . time() . '_' . uniqid() . '.' . $file_extension;
            if (uploadImageToR2($_FILES['profile_pict']['tmp_name'], 'staff', $image)) {
                if (!empty($old_staff['profile_pict'])) {
                    $legacyPath = ROOT_PATH . '/assets/staff/' . $old_staff['profile_pict'];
                    if (file_exists($legacyPath)) {
                        unlink($legacyPath);
                    }
                    deleteFromR2('staff', $old_staff['profile_pict']);
                }
                $_POST['profile_pict'] = $image;
            }
        }
    } else {
        if (selectOne('staff', ['id' => $id])['profile_pict'] !== null) {
            $_POST['profile_pict'] = selectOne('staff', ['id' => $id])['profile_pict'];
        }
    }

    if (count($errors) === 0) {
        $update = update('staff', $id, ['nm_lengkap' => $_POST['nm_lengkap'], 'profile_pict' => $_POST['profile_pict']]);
        if ($update) {
            echo json_encode(['status' => 1, 'msg' => 'Sukses, Berhasil Update Staff']);
        } else {
            echo json_encode(['status' => 0, 'msg' => 'Somethin Went Wrong']);
        }
    } else {
        echo json_encode(['status' => 0, 'error' => $errors]);
    }
}