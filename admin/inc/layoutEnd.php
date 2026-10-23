<?php
// Kerangka halaman admin bagian bawah: penutup area konten, library JS bersama, flash message.
$pageAssets = $pageAssets ?? [];
$adminAsset = BASE_URL . '/admin';
?>
        </div>
    </main>

    <script src="<?= $adminAsset ?>/vendors/scripts/core.js"></script>
    <script src="<?= $adminAsset ?>/vendors/scripts/script.min.js"></script>
    <script src="<?= $adminAsset ?>/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="<?= $adminAsset ?>/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= $adminAsset ?>/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
    <script src="<?= $adminAsset ?>/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
    <script src="<?= $adminAsset ?>/vendors/scripts/dashboard3.js?v=<?= @filemtime(ROOT_PATH . '/admin/vendors/scripts/dashboard3.js') ?>"></script>
    <?php if (!empty($pageAssets['charts'])) : ?>
    <script src="<?= $adminAsset ?>/src/plugins/apexcharts/apexcharts.min.js"></script>
    <?php endif; ?>
    <?php if (!empty($pageAssets['crop'])) : ?>
    <script src="<?= $adminAsset ?>/src/plugins/ijabocroptool/ijaboCropTool.min.js"></script>
    <?php endif; ?>
    <?php if (!empty($pageAssets['editor'])) : ?>
    <script src="<?= $adminAsset ?>/src/plugins/quill/quill.js"></script>
    <script src="<?= $adminAsset ?>/src/scripts/editor.js?v=<?= @filemtime(ROOT_PATH . '/admin/src/scripts/editor.js') ?>"></script>
    <?php endif; ?>
    <?php adminFlashScript(); ?>
