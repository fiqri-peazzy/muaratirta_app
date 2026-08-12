<div class="left-side-bar">
    <div class="brand-logo">
        <a href="<?php echo BASE_URL . "/" ?>">
            <img src="<?php echo BASE_URL . "/assets/image/download.svg" ?>" alt="" class="dark-logo " />
            <img src="<?php echo BASE_URL . "/assets/image/logo.svg" ?>" alt="" class="light-logo" />
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <?php if (getUser()['level'] == 1 || getUser()['level'] == 3) : ?>
                <li>
                    <a href="<?php echo BASE_URL . '/admin/informasi.php' ?>" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-info-circle"></span> Informasi
                    </a>
                </li>
                <?php endif; ?>
                <?php if (getUser()['level'] == 1 || getUser()['level'] == 2) : ?>
                <li>
                    <a href="<?php echo BASE_URL . '/admin/pasang-baru.php' ?>" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-receipt-cutoff"></span> Pasang Baru
                    </a>
                </li>
                <li>
                    <a href="<?php echo BASE_URL . '/admin/pengaduan.php' ?>" class="dropdown-toggle no-arrow">
                        <span class="micon fa fa-comments-o"></span> Pengaduan
                    </a>
                </li>

                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon bi bi-robot"></span><span class="mtext">Asisten Chatbot</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="<?php echo BASE_URL . '/admin/chatbot/faq.php' ?>">Kelola FAQ</a></li>
                        <li><a href="<?php echo BASE_URL . '/admin/chatbot/info.php' ?>">Info Layanan</a></li>
                        <li><a href="<?php echo BASE_URL . '/admin/chatbot/history.php' ?>">Riwayat Chat</a></li>
                    </ul>
                </li>
                <?php endif; ?>



                <?php if (getUser()['level'] == 1 || getUser()['level'] == 3) : ?>
                <li>
                    <a href="<?php echo BASE_URL . '/admin/galeri.php' ?>" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-images"></span> Galeri
                    </a>
                </li>
                <?php endif; ?>
                <?php if (getUser()['level'] == 1) : ?>
                <li>
                    <a href="<?php echo BASE_URL . '/admin/users.php' ?>" class="dropdown-toggle no-arrow">
                        <span class="micon fa fa-user"></span> User
                    </a>
                </li>

                <li>
                    <a href="<?= BASE_URL . '/admin/struktur-organisasi.php' ?>" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-people"></span> Struktur Organisasi
                    </a>
                </li>
                <?php endif; ?>

                <li>
                    <div class="dropdown-divider"></div>
                </li>
                <li>
                    <div class="sidebar-small-cap">Auth</div>
                </li>
                <li>
                    <a href="<?= BASE_URL . "/logout.php" ?>" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-box-arrow-right"></span>Logout</a>
                </li>

            </ul>
        </div>
    </div>
</div>