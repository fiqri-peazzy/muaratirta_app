<?php


include('../../path.php');
require_once(ROOT_PATH . '/app/helpers/middleware.php');
adminAjaxOnly([1]);
require_once(ROOT_PATH . '/app/db/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $delete = deleteF('jabatan', $id);
    if ($delete) {
        echo 'Deleted Successfull';
    }
}