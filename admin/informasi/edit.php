<?php
require_once('../../path.php');
require_once(ROOT_PATH . '/app/controllers/info.php');
include(ROOT_PATH . '/app/helpers/middleware.php');
adminOnly();
adminLevel([1, 3]);
require_once ROOT_PATH . '/admin/inc/consoleNav.php';

$informasi = empty($_GET['id']) ? null : selectOne('informasi', ['id' => $_GET['id']]);
if (!$informasi) {
    $_SESSION['message'] = 'Publikasi tidak ditemukan atau sudah dihapus.';
    $_SESSION['type'] = 'error';
    header('Location: ' . BASE_URL . '/admin/informasi.php');
    exit();
}

$viewLink = !empty($informasi['slug'])
    ? '<a href="' . BASE_URL . '/detail-berita/' . h($informasi['slug']) . '" target="_blank" rel="noopener" class="btn btn-ghost"><i class="bi bi-box-arrow-up-right"></i> Lihat di website</a>'
    : '';

$pageAssets = ['editor' => true];
require_once ROOT_PATH . '/app/helpers/html_sanitizer.php';
include ROOT_PATH . '/admin/inc/layoutStart.php';

adminPageHeader([
    'desc' => 'Perubahan langsung terlihat di website setelah disimpan.',
    'back' => BASE_URL . '/admin/informasi.php',
    'actions' => $viewLink,
]);

include ROOT_PATH . '/admin/inc/forms/informasiForm.php';
include ROOT_PATH . '/admin/inc/layoutEnd.php';
?>
</body>

</html>
