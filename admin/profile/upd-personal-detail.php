<?php

require_once('../../path.php');
require_once(ROOT_PATH . '/app/db/db.php');

function validateForm($data)
{
    $errors = [];
    $username_taken = [];
    $email_taken = [];
    $user = selectAll('users');
    foreach ($user as $i) {
        $username_taken[] = $i['username'];
        $email_taken[] = $i['email'];
    }
    if (empty($data['username'])) {
        $errors['username'] = 'Username Tidak Boleh Kosong';
    }

    if (getUser()['username'] !== $data['username']) {
        if (in_array($data['username'], $username_taken)) {
            $errors['username'] = 'Username Telah Di gunakan';
        }
    }


    if (strlen($data['username']) < 6) {
        $errors['username'] = 'Username minimal 6 karakter';
    }

    if (empty($data['email'])) {
        $errors['email'] =  'Email Tidak Boleh Kosong';
    }

    if (getUser()['email'] !== $data['email']) {
        if (in_array($data['email'], $email_taken)) {
            $errors['email'] = 'Email Telah Digunakan';
        }
    }



    return $errors;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $error = validateForm($_POST);
    $user = getUser();

    if (count($error) == 0) {
        $update = update('users', getUser()['id'], ['nm_lengkap' => $_POST['nm_lengkap'], 'username' => $_POST['username'], 'email' => $_POST['email'], 'no_hp' => $_POST['no_hp']]);

        if ($update) {
            $user_info = selectOne('users', ['id' => getUser()['id']]);
            echo json_encode(['status' => 1, 'msg' => 'Success, Profile Anda Berhasil di update', 'user_info' => $user_info]);
        } else {
            echo json_encode(['status' => 0, 'msg' => 'Something Went Wrong']);
        }
    } else {
        echo json_encode(['status' => 0, 'error' => $error]);
    }
}
