<?php

require_once('../../path.php');
require_once(ROOT_PATH . '/app/db/db.php');
require_once(ROOT_PATH . '/app/helpers/php_mail.php');

function validateForm($data)
{
    $errors = [];

    $user_id = getUser();

    if (empty($data['current_password'])) {
        $errors['current_password'] = 'Masukan Password Lama';
    } elseif (!password_verify($data['current_password'], $user_id['password'])) {
        $errors['current_password'] = 'Password Anda Salah';
    }

    if (empty($data['new_password'])) {
        $errors['new_password'] = 'Masukan Password Baru';
    } elseif (strlen($data['new_password'] < 6)) {
        $errors['new_password'] = 'Password Harus Minimal 6 Karakter';
    } elseif ($data['current_password'] == $data['new_password']) {
        $errors['new_password'] = 'Masukan Password yang Berbeda';
    }
    if (empty($data['confirm_password'])) {
        $errors['confirm_password'] = 'Konfirmasi Password Baru';
    } elseif ($data['new_password'] != $data['confirm_password']) {
        $errors['confirm_password'] = 'Password Tidak Cocok';
    }

    return $errors;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_id = getUser()['id'];
    $errors = validateForm($_POST);
    if (count($errors) == 0) {
        $update = update('users', $user_id, ['password' => password_hash($_POST['new_password'], PASSWORD_DEFAULT)]);
        if ($update) {
            $user_info = selectOne('users', ['id' => $user_id]);
            $base_url = BASE_URL;
            $mail_data = array(
                'user' => $user_info,
                'new_password' => $_POST['new_password'],
                'base_url' => $base_url,
            );
            $change_password_email = ROOT_PATH . '/mail-template/password_change.php';

            if (file_exists($change_password_email)) {
                extract($mail_data);
                ob_start();
                include $change_password_email;
                $mail_body = ob_get_clean();
            }

            $mailConfig = array(
                'mail_from_email' => 'fiqriawan36@gmail.com',
                'mail_from_name' => 'admin',
                'mail_recipient_email' => $user_info['email'],
                'mail_recipient_name' => $user_info['nm_lengkap'],
                'mail_subject' => 'Password Changed',
                'mail_body' => $mail_body
            );

            sendEmail($mailConfig);
            echo json_encode(['status' => 1, 'msg' => 'Sukses, Password Anda Berhasil di ubah']);
        }
    } else {
        echo json_encode(['status' => 0, 'error' => $errors]);
    }
}
