<?php
// Kerangka halaman admin bagian atas: <head>, header, sidebar, pembuka area konten.
// Set sebelum include (opsional):
//   $pageTitle  - judul tab browser (default: judul dari consoleNav)
//   $pageAssets - ['charts' => true] untuk ApexCharts, ['crop' => true] untuk ijaboCropTool
//   $pageHead   - HTML tambahan di dalam <head>
// Tutup dengan include inc/layoutEnd.php, lalu skrip halaman, lalu </body></html>.
require_once ROOT_PATH . '/admin/inc/consoleNav.php';
$pageAssets = $pageAssets ?? [];
$adminAsset = BASE_URL . '/admin';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <title><?= h(($pageTitle ?? adminNavContext()['title']) . ' | Admin Muara Tirta') ?></title>
    <link href="<?= BASE_URL ?>/assets/logo/Logo-PDAM-MT-min.ico" rel="icon">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?= $adminAsset ?>/vendors/styles/core.css" />
    <link rel="stylesheet" type="text/css" href="<?= $adminAsset ?>/vendors/styles/icon-font.min.css" />
    <link rel="stylesheet" type="text/css" href="<?= $adminAsset ?>/src/plugins/datatables/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="<?= $adminAsset ?>/src/plugins/datatables/css/responsive.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="<?= $adminAsset ?>/vendors/styles/style.css" />
    <?php if (!empty($pageAssets['crop'])) : ?>
    <link rel="stylesheet" href="<?= $adminAsset ?>/src/plugins/ijabocroptool/ijaboCropTool.min.css" />
    <?php endif; ?>
    <?php if (!empty($pageAssets['editor'])) : ?>
    <link rel="stylesheet" href="<?= $adminAsset ?>/src/plugins/quill/quill.snow.css" />
    <?php endif; ?>
    <?php include ROOT_PATH . '/admin/inc/consoleHead.php'; ?>
    <?= $pageHead ?? '' ?>
</head>

<body>
    <?php include ROOT_PATH . '/admin/inc/headerAdmin.php'; ?>
    <?php include ROOT_PATH . '/admin/inc/leftSidebar.php'; ?>

    <div class="mobile-menu-overlay"></div>

    <main class="main-container" id="main">
        <div class="pd-ltr-20 xs-pd-20-10">
