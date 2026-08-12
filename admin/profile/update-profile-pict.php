<?php
require_once('../../path.php');
require_once(ROOT_PATH . '/app/db/db.php');
require_once(ROOT_PATH . '/app/helpers/r2_helper.php');

if (!empty($_FILES['user_profile_file']['name'])) {

    $user = getUser();
    $old_picture = $user['profile_pict'];
    $file = $_FILES['user_profile_file']['tmp_name'];
    $new_image_name = 'UIMG_' . time() . "_" . $user['id'] . '_' . uniqid() . '.jpg';

    if (uploadImageToR2($file, 'profile', $new_image_name)) {

        if (!empty($old_picture)) {
            $legacyPath = ROOT_PATH . '/assets/profile-pict/' . $old_picture;
            if (file_exists($legacyPath)) {
                unlink($legacyPath);
            }
            deleteFromR2('profile', $old_picture);
        }

        $user_id = update('users', $user['id'], ['profile_pict' => $new_image_name]);
        echo json_encode(['status' => 1, 'msg' => 'Success, Berhasil Update Foto Profile']);
    } else {

        echo json_encode(['status' => 0, 'msg' => 'failed']);
    }
}