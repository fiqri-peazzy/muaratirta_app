<?php

include('../../path.php');
require_once(ROOT_PATH . '/app/db/db.php');
require_once(ROOT_PATH . '/app/helpers/r2_helper.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $staff = selectOne('staff', ['id' => $id]);

    if (!empty($staff['profile_pict'])) {
        $legacyPath = ROOT_PATH . '/assets/staff/' . $staff['profile_pict'];
        if (file_exists($legacyPath)) {
            unlink($legacyPath);
        }
        deleteFromR2('staff', $staff['profile_pict']);
    }

    $delete_staff = deleteF('staff', $id);
    if ($delete_staff) {
        echo 'SUccesfull deleted';
    }
}