<?php
// require_once('../../path.php');
require(ROOT_PATH . '/app/db/db.php');
require_once(ROOT_PATH . '/app/helpers/clean_data.php');
require_once(ROOT_PATH . '/app/helpers/php_mail.php');
require_once(ROOT_PATH . '/app/helpers/r2_helper.php');


function generateRandomString($length = 12)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

$errors = array();



$cek = "select * from users";
$result = mysqli_query($conn, $cek);
if (mysqli_num_rows($result) == 0) {
    $str_password = 'admin';
    $hash_password = password_hash($str_password, PASSWORD_DEFAULT);

    $query = "insert into users values('','admin','$hash_password','admin@gmail.com','1')";

    mysqli_query($conn, $query);
    echo ("<script> alert('Admin Berhasil di tambahkan')</script>");
}


if (isset($_POST['loginAdmin'])) {
    $errors = [];
    $u_name = $_POST['u_name'];
    $pass = $_POST['pass'];

    $cek = "select * from users where username='$u_name'";
    $res = mysqli_query($conn, $cek);
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);

        $hash_password = $row['password'];
        if (password_verify($pass, $hash_password)) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['last_login_timestamp'] = time();
            header('Location:admin/index.php');
            exit();
        } else {
            $errors['password'] = 'Password Salah Coba Lagi';
        }
    } else {
        $errors['username'] = 'Username Tidak Ditemukan';
    }
}

if (isset($_SESSION['username'])) {
    if ((time() - $_SESSION['last_login_timestamp']) > 1800) {
        header('Location:' . BASE_URL . '/logout.php');
    }
}

if (isset($_POST['submit-keluhan'])) {

    // dd($_POST);

    if (!empty($_FILES['foto']['name'])) {
        $allowed_extensions = array('jpg', 'jpeg');
        $file_extension = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));

        if (in_array($file_extension, $allowed_extensions)) {
            $image = time() . "_" . uniqid() . "." . $file_extension;

            $results = uploadImageToR2($_FILES['foto']['tmp_name'], 'pengaduan', $image);

            if ($results) {
                $_POST['foto'] = $image;
            } else {
                $errors[] = 'Gagal Upload Foto';
            }
        } else {
            $errors[] = 'Upload File berupa .jpg atau .jpeg !';
        }
    } else {
        $_POST['foto'] = '';
    }


    unset($_POST['submit-keluhan']);

    $_POST = cleanInput($_POST);

    if (empty($_POST['id_pel'])) {
        $errors[] = 'Wajib Masukan Id Pelanggan';
    } elseif (!is_numeric($_POST['id_pel'])) {
        $errors[] = 'Id Pelanggan Wajib Berupa angka 7 digit';
    } elseif (strlen($_POST['id_pel']) < 7) {
        $errors[] = 'Id Pelanggan Wajib Berupa angka 7 digit..';
    }



    if (empty($_POST['alamat'])) {
        $errors[] = 'Masukan Alamat Lengkap';
    }
    if (empty($_POST['no_hp'])) {
        $errors[] = 'Masukan No Hp';
    } elseif (!is_numeric($_POST['no_hp'])) {
        $errors[] = 'No Telepon Harus Berupa Angka';
    }

    if (empty($_POST['isi_pengaduan'])) {
        $errors[] = 'Isi Keluhan Yang anda alami';
    }

    if (count($errors) == 0) {
        $keluhan = create('pengaduan', $_POST);
        $_SESSION['messages'] = 'Keluhan Telah Terkirim';
        $_SESSION['type'] = 'success';
        header('Location:' . BASE_URL . '/lapor-keluhan');
        exit();
    }
}

if (isset($_POST['daftar-baru'])) {
    if (!empty($_FILES['foto_ktp']['name'])) {
        $allowed_extensions = array('jpg', 'jpeg', 'png');

        $file_extension = strtolower(pathinfo($_FILES['foto_ktp']['name'], PATHINFO_EXTENSION));

        if (!in_array($file_extension, $allowed_extensions)) {
            $errors[] = "Upload File berupa .Jpg, .jpeg .png!";
        } else {
            $foto_ktp = time() . "_" . generateRandomString() . '.jpg';
            $destination = ROOT_PATH . "/assets/daftar-baru/" . $foto_ktp;

            $results = move_uploaded_file($_FILES['foto_ktp']['tmp_name'], $destination);

            if ($results) {
                $_POST['foto_ktp'] = $foto_ktp;
            } else {
                $errors[] = "Gagal Upload File";
            }
        }
    } else {
        $errors[] = 'Mohon Upload Foto KTP anda';
    }
    if (!empty($_FILES['foto_rumah']['name'])) {
        $allowed_extensions = array('jpg', 'jpeg');

        $file_extension = strtolower(pathinfo($_FILES['foto_rumah']['name'], PATHINFO_EXTENSION));

        if (!in_array($file_extension, $allowed_extensions)) {
            $errors[] = "Upload File berupa .Jpg, .jpeg !";
        } else {
            $foto_rumah = time() . "_" . generateRandomString() . '.jpg';
            $destination = ROOT_PATH . "/assets/daftar-baru/" . $foto_rumah;

            $results = move_uploaded_file($_FILES['foto_rumah']['tmp_name'], $destination);

            if ($results) {
                $_POST['foto_rumah'] = $foto_rumah;
            } else {
                $errors[] = "Gagal Upload File";
            }
        }
    } else {
        $errors[] = 'Mohon Upload Foto Rumah anda';
    }

    if (empty($_POST['alamat'])) {
        $errors[] = 'Mohon Mengisi Alamat dengan Lengkap';
    }

    if (empty($_POST['no_hp'])) {
        $errors[] = "Masukan No Telepon Anda";
    }

    if (empty($errors)) {
        unset($_POST['daftar-baru']);
        $_POST = cleanInput($_POST);
        $daftar_baru = create('pasang_baru', $_POST);
        $_SESSION['type'] = 'success';
        $_SESSION['title'] = 'Terima Kasih Telah Melakukan Pendaftaran Sambungan Baru';
        $_SESSION['messages'] = 'Mohon Menunggu, Data yang anda kirimkan akan segera di tindak lanjut oleh Petugas';
        header('Location:' . BASE_URL . '/pasang-baru');
        exit();
    } else {
        $_SESSION['type'] = 'error';
        $_SESSION['title'] = 'Gagal Mengirim Data';
    }
}

// FORGOT PASSWORD HANDLER

if (isset($_POST['forgot-password-form'])) {
    unset($_POST['forgot-password-form']);
    $errors = [];
    $email_taken = [];
    foreach (selectAll('users') as $user) {
        $email[] = $user['email'];
    }
    if (empty($_POST['email'])) {
        $errors['email'] = 'Masukan Email Untuk Reset Password';
    } elseif (!in_array($_POST['email'], $email)) {
        $errors['email'] = 'Email Tidak terdaftar dalam sistem';
    }

    date_default_timezone_set('Asia/Jakarta');
    $now = date_create('now')->format('Y-m-d H:i:s');
    if (count($errors) === 0) {
        $user_info = selectOne('users', ['email' => $_POST['email']]);

        // create token
        $token = bin2hex(openssl_random_pseudo_bytes(65));

        $password_reset_token = selectOne('password_reset_token', ['email' => $user_info['email']]);


        if ($password_reset_token) {
            $id = $password_reset_token['id'];
            $update_token = update('password_reset_token', $id, ['created_at' => $now, 'token' => $token]);
        } else {
            $create_token = create('password_reset_token', ['email' => $_POST['email'], 'token' => $token, 'created_at' => $now]);
        }

        $action_url = BASE_URL . '/reset-password?token=' . $token;
        $mail_data = array(
            'action_url' => $action_url,
            'user' => $user_info
        );

        $reset_password_email_template = ROOT_PATH . '/mail-template/reset_password.php';
        if (file_exists($reset_password_email_template)) {
            extract($mail_data);
            ob_start();
            include $reset_password_email_template;
            $mail_body = ob_get_clean();
        }

        $mail_config = array(
            'mail_from_email' => 'fiqriawan36@gmail.com',
            'mail_from_name' => $_ENV['EMAIL_FROM_NAME'],
            'mail_recipient_email' => $user_info['email'],
            'mail_recipient_name' => $user_info['nm_lengkap'],
            'mail_subject' => 'Reset Password',
            'mail_body' => $mail_body
        );

        if (sendEmail($mail_config)) {
            $_SESSION['message'] = 'Sukses, Email reset password terkirim di email';
            $_SESSION['type'] = 'success';
            // header('location:' . BASE_URL . '/forgot-password');
            // exit();
        } else {
            $_SESSION['message'] = 'Something Went Wrong';
            $_SESSION['type'] = 'error';
        }
    }
}

if (isset($_GET['token'])) {
    date_default_timezone_set('Asia/Jakarta');

    $password_reset_token = selectOne('password_reset_token', ['token' => $_GET['token']]);
    if (!$password_reset_token) {
        $_SESSION['message'] = 'Invalid Password Reset Token';
        $_SESSION['type'] = 'error';
        header('Location:' . BASE_URL . '/forgot-password?status=error');
        exit();
    } else {
        $now = new DateTime();
        $token_created_at = DateTime::createFromFormat('Y-m-d H:i:s', $password_reset_token['created_at']);
        $diff = $token_created_at->diff($now);
        if ($diff->days * 24 * 60 + $diff->h * 60 + $diff->i > 40) {
            $_SESSION['message'] = 'Token Expired';
            header('Location:' . BASE_URL . '/forgot-password?status=error');
            exit();
        } else {
            if (isset($_POST['change-password-form'])) {
                $errors = [];
                $cek_password = selectOne('users', ['email' => $password_reset_token['email']]);

                if (empty($_POST['new_password'])) {
                    $errors['new_password'] = 'Error ,Masukan Password Baru';
                } elseif (password_verify($_POST['new_password'], $cek_password['password'])) {
                    $errors['new_password'] = 'Masukan Password Yang Berbeda dari sebelumnya';
                } elseif (strlen($_POST['new_password']) < 6) {
                    $errors['new_password'] = 'Password Minimal 6 Karakter';
                }

                if (empty($_POST['confirm_password'])) {
                    $errors['confirm_password'] = 'Konfirmasi Password';
                } elseif ($_POST['new_password'] !== $_POST['confirm_password']) {
                    $errors['confirm_password'] = 'Password tidak Cocok';
                }

                if (count($errors) == 0) {
                    //cek token 

                    $cek_token = selectOne('password_reset_token', ['token' => $_GET['token']]);

                    $user_info = selectOne('users', ['email' => $cek_token['email']]);
                    if (!$cek_token) {
                        $_SESSION['message'] = 'Invalid Password reset Token';
                        $_SESSION['type'] = 'error';
                        header('Location:' . BASE_URL . '/forgot-password?status=error');
                        exit();
                    } else {
                        $user = update('users', $user_info['id'], ['password' => password_hash($_POST['new_password'], PASSWORD_DEFAULT)]);
                        if ($user) {
                            $mail_data = array(
                                'user' => $user_info,
                                'new_password' => $_POST['new_password']
                            );
                            $password_change_mail_template = ROOT_PATH . '/mail-template/password_change.php';

                            if (file_exists($password_change_mail_template)) {
                                extract($mail_data);
                                ob_start();
                                include $password_change_mail_template;
                                $mail_body = ob_get_clean();
                            }
                            $mail_config = array(
                                'mail_from_email' => 'fiqriawan36@gmail.com',
                                'mail_from_name' => $_ENV['EMAIL_FROM_NAME'],
                                'mail_recipient_email' => $user_info['email'],
                                'mail_recipient_name' => $user_info['nm_lengkap'],
                                'mail_subject' => 'Reset Password',
                                'mail_body' => $mail_body
                            );

                            if (sendEmail($mail_config)) {
                                $delete_token = deleteF('password_reset_token', $cek_token['id']);
                                $_SESSION['message'] = 'Password Berhasil Di reset';
                                $_SESSION['type'] = 'success';
                            } else {
                                $_SESSION['message'] = 'Something Went Wrong';
                                $_SESSION['type'] = 'error';
                            }
                        }
                    }
                }
            }
        }
    }
}