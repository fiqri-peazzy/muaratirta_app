<?php

include(ROOT_PATH . "/app/db/db.php");

$errors = array();
$table_faq = 'chat_faq';
$table_info = 'chat_info';
$table_history = 'chat_history';

// FAQ variables
$id = '';
$pertanyaan = '';
$jawaban = '';
$is_active = 1;

// Info variables
$judul = '';
$konten = '';

/* ============================================
   FAQ CRUD
   ============================================ */

if (isset($_POST['add-faq'])) {
    $errors = validateFAQ($_POST);

    if (count($errors) === 0) {
        unset($_POST['add-faq']);
        $post_id = create($table_faq, $_POST);
        $_SESSION['message'] = "FAQ berhasil ditambahkan";
        $_SESSION['type'] = "success";
        header("location: " . BASE_URL . "/admin/chatbot/faq.php");
        exit();
    } else {
        $pertanyaan = $_POST['pertanyaan'];
        $jawaban = $_POST['jawaban'];
    }
}

if (isset($_GET['id'])) {
    $faq = selectOne($table_faq, ['id' => $_GET['id']]);
    $id = $faq['id'];
    $pertanyaan = $faq['pertanyaan'];
    $jawaban = $faq['jawaban'];
    $is_active = $faq['is_active'];
}

if (isset($_POST['update-faq'])) {
    $errors = validateFAQ($_POST);

    if (count($errors) === 0) {
        $id = $_POST['id'];
        unset($_POST['update-faq'], $_POST['id']);
        $count = update($table_faq, $id, $_POST);
        $_SESSION['message'] = "FAQ berhasil diupdate";
        $_SESSION['type'] = "success";
        header("location: " . BASE_URL . "/admin/chatbot/faq.php?id=" . $id);
        exit();
    } else {
        $id = $_POST['id'];
        $pertanyaan = $_POST['pertanyaan'];
        $jawaban = $_POST['jawaban'];
    }
}

if (isset($_GET['del_faq'])) {
    $count = deleteF($table_faq, $_GET['del_faq']);
    $_SESSION['message'] = "FAQ berhasil dihapus";
    $_SESSION['type'] = "success";
    header("location: " . BASE_URL . "/admin/chatbot/faq.php");
    exit();
}

/* ============================================
   INFO CRUD
   ============================================ */

if (isset($_POST['add-chat-info'])) {
    if (empty($_POST['judul'])) array_push($errors, "Judul harus diisi");
    if (empty($_POST['konten'])) array_push($errors, "Konten harus diisi");

    if (count($errors) === 0) {
        unset($_POST['add-chat-info']);
        $post_id = create($table_info, $_POST);
        $_SESSION['message'] = "Info Chat berhasil ditambahkan";
        $_SESSION['type'] = "success";
        header("location: " . BASE_URL . "/admin/chatbot/info.php");
        exit();
    } else {
        $judul = $_POST['judul'];
        $konten = $_POST['konten'];
    }
}

if (isset($_GET['info_id'])) {
    $info = selectOne($table_info, ['id' => $_GET['info_id']]);
    $id = $info['id'];
    $judul = $info['judul'];
    $konten = $info['konten'];
}

if (isset($_POST['update-chat-info'])) {
    if (empty($_POST['judul'])) array_push($errors, "Judul harus diisi");
    if (empty($_POST['konten'])) array_push($errors, "Konten harus diisi");

    if (count($errors) === 0) {
        $id = $_POST['id'];
        unset($_POST['update-chat-info'], $_POST['id']);
        $count = update($table_info, $id, $_POST);
        $_SESSION['message'] = "Info Chat berhasil diupdate";
        $_SESSION['type'] = "success";
        header("location: " . BASE_URL . "/admin/chatbot/info.php?id=" . $id);
        exit();
    } else {
        $id = $_POST['id'];
        $judul = $_POST['judul'];
        $konten = $_POST['konten'];
    }
}

if (isset($_GET['del_info'])) {
    $count = deleteF($table_info, $_GET['del_info']);
    $_SESSION['message'] = "Info Chat berhasil dihapus";
    $_SESSION['type'] = "success";
    header("location: " . BASE_URL . "/admin/chatbot/info.php");
    exit();
}

function validateFAQ($faq)
{
    $errors = array();
    if (empty($faq['pertanyaan'])) {
        array_push($errors, 'Pertanyaan harus diisi');
    }
    if (empty($faq['jawaban'])) {
        array_push($errors, 'Jawaban harus diisi');
    }
    return $errors;
}