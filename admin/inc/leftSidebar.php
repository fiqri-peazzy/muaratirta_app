<?php
require_once ROOT_PATH . '/admin/inc/consoleNav.php';
$consoleUser = $consoleUser ?? getUser();
$level = (int) $consoleUser['level'];
$isCs = in_array($level, [1, 2], true);
$isArsip = in_array($level, [1, 3], true);
$isAdmin = $level === 1;
$chatbotActive = strpos(adminNavContext()['section'], 'chatbot/') === 0;
?>
<div class="left-side-bar">
    <div class="brand-logo">
        <a href="<?= BASE_URL . '/admin/' ?>" title="Dashboard">
            <span class="brand-mark"><img src="<?= BASE_URL ?>/assets/logo/logo-perumda-2026.png" alt="Logo PERUMDA Muara Tirta"></span>
            <span class="brand-text">
                <strong>Muara Tirta</strong>
                <small>Admin Console</small>
            </span>
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close" aria-label="Tutup menu">
            <i class="bi bi-x-lg"></i>
        </div>
    </div>

    <div class="menu-block">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <li>
                    <a href="<?= BASE_URL . '/admin/' ?>" class="dropdown-toggle no-arrow<?= adminNavActive('dashboard') ?>"
                        title="Dashboard">
                        <span class="micon bi bi-speedometer2"></span><span class="mtext">Dashboard</span>
                    </a>
                </li>

                <?php if ($isCs) : ?>
                <li class="menu-label-wrap">
                    <div class="menu-label">Layanan Pelanggan</div>
                </li>
                <li>
                    <a href="<?= BASE_URL . '/admin/pengaduan.php' ?>"
                        class="dropdown-toggle no-arrow<?= adminNavActive('pengaduan') ?>" title="Pengaduan">
                        <span class="micon bi bi-chat-left-text"></span><span class="mtext">Pengaduan</span>
                    </a>
                </li>
                <li>
                    <a href="<?= BASE_URL . '/admin/pasang-baru.php' ?>"
                        class="dropdown-toggle no-arrow<?= adminNavActive('pasang-baru') ?>" title="Pasang Baru">
                        <span class="micon bi bi-receipt-cutoff"></span><span class="mtext">Pasang Baru</span>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle<?= $chatbotActive ? ' active' : '' ?>"
                        title="Asisten Chatbot">
                        <span class="micon bi bi-robot"></span><span class="mtext">Asisten Chatbot</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="<?= BASE_URL . '/admin/chatbot/faq.php' ?>"
                                class="<?= trim(adminNavActive('chatbot/faq')) ?>">Kelola FAQ</a></li>
                        <li><a href="<?= BASE_URL . '/admin/chatbot/info.php' ?>"
                                class="<?= trim(adminNavActive('chatbot/info')) ?>">Info Layanan</a></li>
                        <li><a href="<?= BASE_URL . '/admin/chatbot/history.php' ?>"
                                class="<?= trim(adminNavActive('chatbot/history')) ?>">Riwayat Chat</a></li>
                    </ul>
                </li>
                <?php endif; ?>

                <?php if ($isArsip) : ?>
                <li class="menu-label-wrap">
                    <div class="menu-label">Konten</div>
                </li>
                <li>
                    <a href="<?= BASE_URL . '/admin/informasi.php' ?>"
                        class="dropdown-toggle no-arrow<?= adminNavActive('informasi') ?>" title="Informasi & Berita">
                        <span class="micon bi bi-newspaper"></span><span class="mtext">Informasi &amp; Berita</span>
                    </a>
                </li>
                <li>
                    <a href="<?= BASE_URL . '/admin/galeri.php' ?>"
                        class="dropdown-toggle no-arrow<?= adminNavActive('galeri') ?>" title="Galeri">
                        <span class="micon bi bi-images"></span><span class="mtext">Galeri</span>
                    </a>
                </li>
                <?php endif; ?>

                <?php if ($isAdmin) : ?>
                <li class="menu-label-wrap">
                    <div class="menu-label">Administrasi</div>
                </li>
                <li>
                    <a href="<?= BASE_URL . '/admin/users.php' ?>"
                        class="dropdown-toggle no-arrow<?= adminNavActive('users') ?>" title="Manajemen User">
                        <span class="micon bi bi-people"></span><span class="mtext">Manajemen User</span>
                    </a>
                </li>
                <li>
                    <a href="<?= BASE_URL . '/admin/struktur-organisasi.php' ?>"
                        class="dropdown-toggle no-arrow<?= adminNavActive('struktur-organisasi') ?>"
                        title="Struktur Organisasi">
                        <span class="micon bi bi-diagram-3"></span><span class="mtext">Struktur Organisasi</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <a href="<?= BASE_URL . '/admin/profile.php' ?>" title="Profil saya">
                <img src="<?= htmlspecialchars(adminAvatarUrl($consoleUser)) ?>" alt="" />
            </a>
            <a class="su-meta" href="<?= BASE_URL . '/admin/profile.php' ?>">
                <span class="su-name"><?= htmlspecialchars($consoleUser['nm_lengkap'] ?: $consoleUser['username']) ?></span>
                <span class="su-role"><?= adminRoleName($level) ?></span>
            </a>
            <a class="su-logout" href="<?= BASE_URL . '/logout.php' ?>" title="Keluar">
                <i class="bi bi-box-arrow-right"></i>
            </a>
        </div>
    </div>
</div>
