<?php
require_once('../../path.php');
require_once(ROOT_PATH . '/app/db/db.php');

if (!empty($_FILES['user_profile_file']['name'])) {


    $user = getUser();
    $old_picture = $user['profile_pict'];
    $path = ROOT_PATH . '/assets/profile-pict/';
    $file = $_FILES['user_profile_file']['tmp_name'];
    $new_image_name = 'UIMG_' . time() . "_" . $user['id'] . '.jpg';

    if (move_uploaded_file($file, $path . $new_image_name)) {

        if ($old_picture != null && file_exists($path . $old_picture)) {
            unlink($path . $old_picture);
        }

        $user_id = update('users', $user['id'], ['profile_pict' => $new_image_name]);
        echo json_encode(['status' => 1, 'msg' => 'Success, Berhasil Update Foto Profile']);
    } else {

        echo json_encode(['status' => 0, 'msg' => 'failed']);
    }
}