<?php
include('../../path.php');
include(ROOT_PATH . '/app/controllers/struktur-organisasi.php');
include(ROOT_PATH . '/app/helpers/middleware.php');
adminOnly();
adminLevel([1]);

$staff = null;

include ROOT_PATH . '/admin/inc/layoutStart.php';

adminPageHeader([
    'desc' => 'Tambahkan staff ke salah satu bagian di struktur organisasi.',
    'back' => BASE_URL . '/admin/struktur-organisasi.php',
]);

include ROOT_PATH . '/admin/inc/forms/staffForm.php';
include ROOT_PATH . '/admin/inc/layoutEnd.php';
?>
</body>

</html>
