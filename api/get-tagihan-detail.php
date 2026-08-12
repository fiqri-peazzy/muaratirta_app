<?php

require('../path.php');
require_once(ROOT_PATH . '/app/db/db.php');
require_once(ROOT_PATH . '/app/helpers/api_tagihan.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];

    if (empty($_POST['id_pel'])) {
        $errors[] = 'Masukan No Sambung';
    } elseif (!is_numeric($_POST['id_pel'])) {
        $errors[] = 'No Sambung Harus Berupa Angka';
    }

    if (count($errors) == 0) {

        $id_pel = $_POST['id_pel'];
        $data = getTagihanDetail($id_pel);

        // print_r($data);

        if (count($data) > 0) {
            echo json_encode($data);
        } else {
            echo json_encode(['status' => false]);
        }
    } else {
        echo json_encode(['status' => false, 'error' => $errors]);
    }
}