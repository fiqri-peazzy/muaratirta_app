<?php
require_once('../../path.php');
require_once(ROOT_PATH . '/app/db/db.php');
require_once(ROOT_PATH . '/app/helpers/clean_data.php');
require_once(ROOT_PATH . '/app/helpers/r2_helper.php');

function validateFormAddUser($data)
{
    $errors = [];
    $username_taken = [];
    $email_taken = [];
    $user_username = selectAll('users');
    foreach ($user_username as $user) {
        $username_taken[] = $user['username'];
        $email_taken[] = $user['email'];
    }
    if (empty($data['username']) && $data['username'] === '') {
        $errors['username'] = 'Username Wajib Diisi';
    } elseif (strlen($data['username']) < 6) {
        $errors['username'] = 'Username Minimal 6 karakter';
    } elseif (in_array($data['username'], $username_taken)) {
        $errors['username'] = 'Username Telah Di gunakan';
    }

    if (!empty($data['no_hp'])) {
        if (!is_numeric($data['no_hp'])) {
            $errors['no_hp'] = 'No Telepon Berupa Angka';
        }
    }

    if (empty($data['email'])) {
        $errors['email'] = 'Email Wajib Diisi';
    } elseif (in_array($data['email'], $email_taken)) {
        $errors['email'] = 'Email Telah di gunakan';
    }

    if (empty($data['password'])) {
        $errors['password'] = 'Password Wajib Diisi';
    } elseif (strlen($data['password']) < 6) {
        $errors['password'] = "Password Minimal 6 karakter";
    }

    if (empty($data['confirm_password'])) {
        $errors['confirm_password'] = 'Konfirmasi Password';
    } elseif ($data['password'] !== $data['confirm_password']) {
        $errors['confirm_password'] = 'Password Tidak Cocok';
    }


    return $errors;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = validateFormAddUser($_POST);
    // echo json_encode($errors);
    if (!empty($_FILES['profile_pict']['name'])) {
        $allowed_extensions = array('jpg', 'jpeg', 'png');

        $file_extension = strtolower(pathinfo($_FILES['profile_pict']['name'], PATHINFO_EXTENSION));

        if (!in_array($file_extension, $allowed_extensions)) {
            $errors['profile_pict'] = 'Upload file image (.jpg, .png)';
        } else {
            $image = "UIMG_" . time() . '_' . uniqid() . '.' . $file_extension;
            if (uploadImageToR2($_FILES['profile_pict']['tmp_name'], 'profile', $image)) {
                $_POST['profile_pict'] = $image;
            }
        }
    }

    if (count($errors) === 0) {

        unset($_POST['confirm_password']);

        $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $new_user = create('users', cleanInput($_POST));
        if ($new_user) {
            echo json_encode(['status' => 1, 'msg' => 'Sukses, Berhasil Tambah User']);
        } else {
            echo json_encode(['status' => 0, 'msg' => 'Somethin Went Wrong']);
        }
    } else {
        echo json_encode(['status' => 0, 'error' => $errors]);
    }
}
