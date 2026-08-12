<?php

include('../../path.php');
require_once(ROOT_PATH . '/app/db/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    if (selectOne('staff', ['id' => $id])['profile_pict'] !== null) {
        unlink(ROOT_PATH . '/assets/staff/' . selectOne('staff', ['id' => $id])['profile_pict']);
    }

    $delete_staff = deleteF('staff', $id);
    if ($delete_staff) {
        echo 'SUccesfull deleted';
    }
}