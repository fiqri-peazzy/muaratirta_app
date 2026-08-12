<?php


include('../../path.php');
include(ROOT_PATH . '/app/db/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $delete = deleteF('jabatan', $id);
    if ($delete) {
        echo 'Deleted Successfull';
    }
}