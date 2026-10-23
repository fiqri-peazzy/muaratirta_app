<?php
// Lapisan tema "Admin Console". Disisipkan tepat sebelum </head> di semua halaman admin,
// sesudah CSS DeskApp supaya override-nya menang.
$consoleCssVer = @filemtime(ROOT_PATH . '/admin/src/styles/console.css') ?: '1';
$consoleJsVer = @filemtime(ROOT_PATH . '/admin/src/scripts/console.js') ?: '1';
?>
<meta name="theme-color" content="#0a1424" />
<link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/admin/src/styles/console.css?v=<?= $consoleCssVer ?>" />
<script>
    window.MT_BASE = <?= json_encode(BASE_URL) ?>;
    // Pasang tema & status sidebar sebelum render supaya tidak berkedip.
    (function () {
        var d = document.documentElement;
        try {
            d.setAttribute('data-theme', localStorage.getItem('mt-theme') === 'dark' ? 'dark' : 'light');
            if (localStorage.getItem('mt-sb') === '1') d.classList.add('sb-collapsed');
            // Sisa pengaturan layout DeskApp lama (header gelap, sidebar putih, dsb) sudah tidak dipakai.
            localStorage.removeItem('optionsObject');
        } catch (e) {
            d.setAttribute('data-theme', 'light');
        }
    })();
</script>
<script src="<?= BASE_URL ?>/admin/src/scripts/console.js?v=<?= $consoleJsVer ?>" defer></script>
