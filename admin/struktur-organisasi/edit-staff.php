<?php
include('../../path.php');
include(ROOT_PATH . '/app/controllers/struktur-organisasi.php');
include(ROOT_PATH . '/app/helpers/middleware.php');
adminOnly();
adminLevel([1]);

$staff = empty($_GET['id']) ? null : selectOne('staff', ['id' => $_GET['id']]);
if (!$staff) {
    $_SESSION['message'] = 'Data staff tidak ditemukan.';
    $_SESSION['type'] = 'error';
    header('Location: ' . BASE_URL . '/admin/struktur-organisasi.php');
    exit();
}

include ROOT_PATH . '/admin/inc/layoutStart.php';

adminPageHeader([
    'title' => 'Edit Staff',
    'desc' => $staff['nm_lengkap'] . ' · ' . $staff['jabatan'],
    'back' => BASE_URL . '/admin/struktur-organisasi.php',
]);

include ROOT_PATH . '/admin/inc/forms/staffForm.php';
include ROOT_PATH . '/admin/inc/layoutEnd.php';
?>
</body>

</html>
