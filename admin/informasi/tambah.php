<?php
include('../../path.php');
include(ROOT_PATH . '/app/controllers/info.php');
include(ROOT_PATH . '/app/helpers/middleware.php');
adminOnly();
adminLevel([1, 3]);

$informasi = null;

$pageAssets = ['editor' => true];
require_once ROOT_PATH . '/app/helpers/html_sanitizer.php';
include ROOT_PATH . '/admin/inc/layoutStart.php';

adminPageHeader([
    'desc' => 'Publikasi baru langsung tampil di halaman Berita website setelah diterbitkan.',
    'back' => BASE_URL . '/admin/informasi.php',
]);

include ROOT_PATH . '/admin/inc/forms/informasiForm.php';
include ROOT_PATH . '/admin/inc/layoutEnd.php';
?>
</body>

</html>
