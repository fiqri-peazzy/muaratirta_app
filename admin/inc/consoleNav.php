<?php
// Helper bersama panel admin: peta halaman (judul, breadcrumb, menu aktif), page header,
// flash message -> toast, dan format tanggal/nama. Dipakai header, sidebar, dan semua halaman.

// Avatar & thumbnail memakai resolveImageUrl(); tidak semua controller memuat helper R2 (mis. chatbot).
require_once ROOT_PATH . '/app/helpers/r2_helper.php';

if (!function_exists('adminNavContext')) {
    function adminNavContext()
    {
        static $ctx = null;
        if ($ctx !== null) {
            return $ctx;
        }

        $script = str_replace('\\', '/', realpath($_SERVER['SCRIPT_FILENAME'] ?? '') ?: '');
        $adminDir = str_replace('\\', '/', ROOT_PATH . '/admin/');
        $rel = strpos($script, $adminDir) === 0 ? substr($script, strlen($adminDir)) : basename($script);

        $u = BASE_URL . '/admin/';
        // [section, judul, ikon, [[label, url|null], ...] induk untuk breadcrumb]
        $pages = [
            'index.php' => ['dashboard', 'Dashboard', 'bi-speedometer2', []],
            'pengaduan.php' => ['pengaduan', 'Pengaduan', 'bi-chat-left-text', [['Layanan Pelanggan', null]]],
            'pengaduan/detail.php' => ['pengaduan', 'Detail Pengaduan', 'bi-chat-left-text', [['Pengaduan', $u . 'pengaduan.php']]],
            'pasang-baru.php' => ['pasang-baru', 'Pasang Baru', 'bi-receipt-cutoff', [['Layanan Pelanggan', null]]],
            'pasang-baru/detail.php' => ['pasang-baru', 'Detail Pendaftaran', 'bi-receipt-cutoff', [['Pasang Baru', $u . 'pasang-baru.php']]],
            'chatbot/faq.php' => ['chatbot/faq', 'Kelola FAQ', 'bi-question-circle', [['Asisten Chatbot', null]]],
            'chatbot/info.php' => ['chatbot/info', 'Info Layanan', 'bi-info-circle', [['Asisten Chatbot', null]]],
            'chatbot/history.php' => ['chatbot/history', 'Riwayat Chat', 'bi-clock-history', [['Asisten Chatbot', null]]],
            'informasi.php' => ['informasi', 'Informasi & Berita', 'bi-newspaper', [['Konten', null]]],
            'informasi/tambah.php' => ['informasi', 'Tulis Informasi', 'bi-pencil-square', [['Informasi & Berita', $u . 'informasi.php']]],
            'informasi/edit.php' => ['informasi', 'Edit Informasi', 'bi-pencil-square', [['Informasi & Berita', $u . 'informasi.php']]],
            'galeri.php' => ['galeri', 'Galeri', 'bi-images', [['Konten', null]]],
            'galeri/tambah.php' => ['galeri', 'Tambah Foto', 'bi-cloud-arrow-up', [['Galeri', $u . 'galeri.php']]],
            'users.php' => ['users', 'Manajemen User', 'bi-people', [['Administrasi', null]]],
            'users/add-user.php' => ['users', 'Tambah User', 'bi-person-plus', [['Manajemen User', $u . 'users.php']]],
            'struktur-organisasi.php' => ['struktur-organisasi', 'Struktur Organisasi', 'bi-diagram-3', [['Administrasi', null]]],
            'struktur-organisasi/add-staff.php' => ['struktur-organisasi', 'Tambah Staff', 'bi-person-plus', [['Struktur Organisasi', $u . 'struktur-organisasi.php']]],
            'struktur-organisasi/edit-staff.php' => ['struktur-organisasi', 'Edit Staff', 'bi-person-badge', [['Struktur Organisasi', $u . 'struktur-organisasi.php']]],
            'struktur-organisasi/add-bagian.php' => ['struktur-organisasi', 'Tambah Bagian', 'bi-diagram-3', [['Struktur Organisasi', $u . 'struktur-organisasi.php']]],
            'struktur-organisasi/edit-bagian.php' => ['struktur-organisasi', 'Edit Bagian', 'bi-diagram-3', [['Struktur Organisasi', $u . 'struktur-organisasi.php']]],
            'profile.php' => ['profile', 'Profil Saya', 'bi-person-circle', [['Akun', null]]],
        ];

        [$section, $title, $icon, $trail] = $pages[$rel] ?? ['', 'Admin', 'bi-grid', []];
        $parent = $trail ? end($trail)[0] : null;
        $ctx = ['section' => $section, 'title' => $title, 'icon' => $icon, 'trail' => $trail, 'parent' => $parent];
        return $ctx;
    }

    function adminNavActive($section)
    {
        return adminNavContext()['section'] === $section ? ' active' : '';
    }

    function adminRoleName($level)
    {
        switch ((int) $level) {
            case 1:
                return 'Administrator';
            case 2:
                return 'Customer Service';
            case 3:
                return 'Arsip & Publikasi';
            default:
                return 'Staff';
        }
    }

    function adminAvatarUrl($user)
    {
        if (empty($user['profile_pict'])) {
            return BASE_URL . '/assets/profile-pict/default.png';
        }
        return resolveImageUrl($user['profile_pict'], 'profile', ['assets/profile-pict']);
    }

    function h($s)
    {
        return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Page header standar: breadcrumb, ikon, judul, deskripsi, tombol aksi.
     * $opts: title, desc, icon, actions (HTML), back (URL tombol kembali), meta (HTML di bawah deskripsi)
     */
    function adminPageHeader($opts = [])
    {
        $ctx = adminNavContext();
        $title = $opts['title'] ?? $ctx['title'];
        $icon = $opts['icon'] ?? $ctx['icon'];
        ?>
<header class="ph">
    <div class="ph-main">
        <nav aria-label="Breadcrumb">
            <ol class="ph-crumbs">
                <li><a href="<?= BASE_URL ?>/admin/"><i class="bi bi-house-door"></i> Dashboard</a></li>
                <?php foreach ($ctx['trail'] as [$label, $url]) : ?>
                <li><?php if ($url) : ?><a href="<?= h($url) ?>"><?= h($label) ?></a><?php else : ?><?= h($label) ?><?php endif; ?></li>
                <?php endforeach; ?>
                <?php if ($ctx['section'] !== 'dashboard') : ?>
                <li aria-current="page"><?= h($opts['crumb'] ?? $title) ?></li>
                <?php endif; ?>
            </ol>
        </nav>
        <div class="ph-title">
            <?php if (!empty($opts['back'])) : ?>
            <a class="ph-back" href="<?= h($opts['back']) ?>" title="Kembali" aria-label="Kembali"><i class="bi bi-arrow-left"></i></a>
            <?php else : ?>
            <span class="ph-icon"><i class="bi <?= h($icon) ?>"></i></span>
            <?php endif; ?>
            <div style="min-width:0">
                <h1><?= h($title) ?></h1>
                <?php if (!empty($opts['desc'])) : ?><p><?= h($opts['desc']) ?></p><?php endif; ?>
                <?= $opts['meta'] ?? '' ?>
            </div>
        </div>
    </div>
    <?php if (!empty($opts['actions'])) : ?>
    <div class="ph-actions"><?= $opts['actions'] ?></div>
    <?php endif; ?>
</header>
        <?php
    }

    /**
     * Pindahkan flash message session ($_SESSION['message'] + ['type']) ke toast UI.
     */
    function adminFlashScript()
    {
        $flash = [];
        if (!empty($_SESSION['message'])) {
            $type = $_SESSION['type'] ?? 'info';
            $type = $type === 'danger' ? 'error' : $type;
            $flash[] = ['message' => (string) $_SESSION['message'], 'type' => $type];
        }
        unset($_SESSION['message'], $_SESSION['type']);
        echo '<script>window.MT_FLASH = ' . json_encode($flash, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) . ';</script>';
    }

    function adminInitials($name)
    {
        $parts = preg_split('/\s+/', trim((string) $name));
        $ini = '';
        foreach (array_slice(array_filter($parts), 0, 2) as $p) {
            $ini .= mb_strtoupper(mb_substr($p, 0, 1));
        }
        return $ini ?: '?';
    }

    function adminAvatarTone($seed)
    {
        return 'av-' . (crc32((string) $seed) % 6);
    }

    function adminDate($date, $withTime = false)
    {
        $bulan = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $t = strtotime((string) $date);
        if (!$t) {
            return '-';
        }
        return date('j', $t) . ' ' . $bulan[(int) date('n', $t)] . ' ' . date('Y', $t) . ($withTime ? ', ' . date('H:i', $t) : '');
    }

    /** Waktu relatif ("5 menit lalu") memakai jam server PHP. */
    function adminAgo($date)
    {
        $t = strtotime((string) $date);
        if (!$t) {
            return '-';
        }
        $m = (int) floor((time() - $t) / 60);
        if ($m < 1) return 'baru saja';
        if ($m < 60) return $m . ' menit lalu';
        if ($m < 1440) return floor($m / 60) . ' jam lalu';
        if ($m < 2880) return 'kemarin';
        if ($m < 10080) return floor($m / 1440) . ' hari lalu';
        return adminDate($date);
    }

    /** Baris kedua di bawah tanggal: waktu relatif kalau masih seminggu terakhir, selain itu jamnya. */
    function adminTimeHint($date)
    {
        $t = strtotime((string) $date);
        if (!$t) {
            return '';
        }
        return time() - $t < 7 * 86400 ? adminAgo($date) : 'pukul ' . date('H:i', $t);
    }

    /** Nomor HP lokal (08xx) -> link wa.me (628xx). */
    function adminWaLink($phone, $text = '')
    {
        $digits = preg_replace('/\D+/', '', (string) $phone);
        if ($digits === '') {
            return '';
        }
        if (strpos($digits, '0') === 0) {
            $digits = '62' . substr($digits, 1);
        } elseif (strpos($digits, '62') !== 0) {
            $digits = '62' . $digits;
        }
        return 'https://wa.me/' . $digits . ($text !== '' ? '?text=' . rawurlencode($text) : '');
    }

    function adminExcerpt($html, $len = 120)
    {
        $text = trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags((string) $html), ENT_QUOTES, 'UTF-8')));
        return mb_strlen($text) > $len ? mb_substr($text, 0, $len) . '…' : $text;
    }
}
