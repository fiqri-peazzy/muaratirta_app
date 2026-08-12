<!-- ======= Header ======= -->
<header id="header" class="header d-flex align-items-center">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

        <a href="<?php echo BASE_URL . "/" ?>" class="logo d-flex align-items-center">
            <!-- Uncomment the line below if you also wish to use an image logo -->
            <img src="<?php echo BASE_URL . '/assets/image/logo.svg' ?>" id="logo" alt="Logo PDAM">
            <!-- <h1>PDAM MUARATIRTA <br><span>Kota Gorontalo</span></h1> -->
        </a>

        <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
        <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
        <nav id="navbar" class="navbar navbar-expand-lg">
            <ul>
                <li><a href="<?php echo BASE_URL . "/" ?>">Beranda</a></li>
                <li class="dropdown"><a href="#">Profil <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                    <ul>
                        <li><a href="<?php echo BASE_URL . '/about' ?>">Tentang Perusahaan</a></li>
                        <li><a href="<?php echo BASE_URL . '/visi-misi' ?>">Visi Misi</a></li>
                        <!-- <li><a href="https://muaratirta.id/">Direksi</a></li> -->

                        <li><a href="<?php echo BASE_URL . '/struktur-organisasi' ?>">Struktur Organisasi</a></li>
                        <li><a href="<?php echo BASE_URL . '/infrastruktur' ?>">Infrastruktur</a></li>

                    </ul>
                </li>
                <li class="dropdown"><a href="#">Pelanggan <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                    <ul>
                        <li><a href="<?php echo BASE_URL . '/cek-tagihan' ?>">Cek Tagihan</a></li>
                        <li><a href="<?php echo BASE_URL . '/pasang-baru' ?>">Pasang Baru</a></li>
                        <li><a href="<?php echo BASE_URL . '/lapor-keluhan' ?>">Lapor Keluhan</a></li>
                        <!-- <li><a href="#">Call Center</a></li> -->

                    </ul>

                </li>
                <li class="dropdown"><a href="#">Informasi <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                    <ul>
                        <li><a href="<?php echo BASE_URL . '/berita' ?>">Berita</a></li>
                        <li><a href="<?= BASE_URL . '/promo' ?>">Promo</a></li>
                        <li><a href="<?php echo BASE_URL . '/info-gangguan' ?>">Info Gangguan</a></li>
                        <li><a href="<?php echo BASE_URL . '/galeri' ?>">Galeri</a></li>

                    </ul>
                </li>
                <li><a href="<?php echo BASE_URL . '/kontak' ?>">Kontak</a></li>

            </ul>
        </nav><!-- .navbar -->

    </div>
</header><!-- End Header -->