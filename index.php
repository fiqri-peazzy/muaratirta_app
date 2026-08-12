<?php
include("path.php");
include(ROOT_PATH . '/app/controllers/users.php');
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Beranda | Muara Tirta Kota Gorontalo</title>
    <meta name="description"
        content="PERUMDA Air Minum Muara Tirta Kota Gorontalo - Menyediakan Air Bersih Berkualitas untuk Kehidupan yang Lebih Baik">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Roboto:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Work+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">
    <link href="assets/logo/Logo-PDAM-MT-min.ico" rel="icon">
    <?php include(ROOT_PATH . '/include/styles.php'); ?>

    <!-- Modern Enhancement CSS -->
    <link href="<?= BASE_URL ?>/assets/css/modern-enhancement.css" rel="stylesheet">

    <script>
    const BASE_URL = '<?= BASE_URL ?>';
    </script>

</head>

<body>
    <?php include(ROOT_PATH . '/include/header.php'); ?>

    <!-- ======= Hero Section REVISED ======= -->
    <section id="hero" class="hero">
        <div class="hero-overlay"></div>

        <div class="info d-flex align-items-center modern-hero-content">
            <div class="container">
                <div class="row justify-content-center pt-5">
                    <div class="col-lg-12 text-center">
                        <h3 class="modern-hero-title text-white ">
                            <span style="text-transform: uppercase;">PERUMDA AIR MINUM</span><br>
                            MUARA TIRTA KOTA GORONTALO
                        </h3>

                        <p class="modern-hero-subtitle text-white">
                            Menyediakan Air Bersih Berkualitas Untuk Kehidupan yang Lebih Baik<br>
                            <strong>Meningkatkan Pelayanan Air Minum Dalam Memenuhi Standar K4</strong>
                        </p>

                        <div class="modern-hero-features d-flex flex-wrap justify-content-center mb-4">
                            <div class="modern-hero-feature-item">
                                <i class="bi bi-droplet-fill"></i>
                                <span>Peningkatan Pelayanan Air Bersih</span>
                            </div>
                            <div class="modern-hero-feature-item">
                                <i class="bi bi-graph-up-arrow"></i>
                                <span>Peningkatan Kinerja PERUMDA</span>
                            </div>
                            <div class="modern-hero-feature-item">
                                <i class="bi bi-award-fill"></i>
                                <span>Pemenuhan Standar K4</span>
                            </div>
                        </div>

                        <a href="<?= BASE_URL . '/about' ?>" class="btn-get-started">
                            Tentang Perusahaan
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div id="hero-carousel" class="carousel" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-item active" style="background-image: url(<?= BASE_URL . '/assets/image/bg.jpg' ?>)">
            </div>
        </div>
    </section>

    <?php include(ROOT_PATH . '/include/webticker.php') ?>

    <main id="main">

        <!-- ======= Service Cards Section - MODERN ======= -->
        <section class="modern-services-section">
            <div class="container">
                <div class="modern-section-header" data-aos="fade-up">
                    <h2 class="modern-section-title">Layanan Kami</h2>
                    <p class="modern-section-subtitle">Akses cepat dan mudah untuk kebutuhan air bersih Anda</p>
                </div>

                <div class="row g-4">
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="modern-service-card-wrapper">
                            <div class="modern-service-card" id="pasang-baru">
                                <div class="modern-service-icon">
                                    <div class="modern-service-icon-bg"></div>
                                    <img src="<?= BASE_URL . '/assets/image/plumbing-plumber-svgrepo-com.svg' ?>" alt=""
                                        srcset="">
                                </div>
                                <h4 class="modern-service-title">Pemasangan Baru</h4>
                                <p class="modern-service-desc">Daftar pemasangan sambungan air bersih baru untuk rumah
                                    atau usaha Anda dengan proses cepat dan mudah</p>
                                <div class="modern-service-arrow">
                                    <i class="bi bi-arrow-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="modern-service-card-wrapper">
                            <div class="modern-service-card" id="lapor-keluhan">
                                <div class="modern-service-icon">
                                    <div class="modern-service-icon-bg"></div>
                                    <img src="<?= BASE_URL . '/assets/image/chatting-conversation-contact-svgrepo-com.svg' ?>"
                                        alt="" srcset="">
                                </div>
                                <h4 class="modern-service-title">Lapor Keluhan</h4>
                                <p class="modern-service-desc">Laporkan kendala atau keluhan terkait layanan air bersih.
                                    Tim kami siap membantu Anda 24/7</p>
                                <div class="modern-service-arrow">
                                    <i class="bi bi-arrow-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="modern-service-card-wrapper">
                            <div class="modern-service-card" id="cek-tagihan">
                                <div class="modern-service-icon">
                                    <div class="modern-service-icon-bg"></div>
                                    <img src="<?= BASE_URL . '/assets/image/invoice-bill-svgrepo-com.svg' ?>" alt="">
                                </div>
                                <h4 class="modern-service-title">Cek Tagihan</h4>
                                <p class="modern-service-desc">Cek tagihan air bulanan Anda secara online. Bayar dengan
                                    mudah melalui berbagai metode pembayaran</p>
                                <div class="modern-service-arrow">
                                    <i class="bi bi-arrow-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ======= About Section - NEW ======= -->
        <section class="modern-about-section">
            <div class="container">
                <div class="modern-about-content">
                    <div class="modern-about-text" data-aos="fade-right">
                        <span class="modern-about-badge">
                            <i class="bi bi-droplet-fill me-2"></i>
                            Tentang Kami
                        </span>

                        <h2 class="modern-about-title">
                            Komitmen Kami Untuk <span>Air Bersih Berkualitas</span>
                        </h2>

                        <p class="modern-about-description">
                            PERUMDA Air Minum Muara Tirta Kota Gorontalo adalah perusahaan daerah yang berdedikasi untuk
                            menyediakan air bersih berkualitas tinggi kepada masyarakat Gorontalo. Dengan standar
                            pelayanan K4 (Kualitas, Kuantitas, Kontinuitas, dan Keterjangkauan), kami terus berinovasi
                            untuk meningkatkan kualitas hidup masyarakat.
                        </p>

                        <div class="modern-about-features">
                            <div class="modern-about-feature" data-aos="fade-up" data-aos-delay="100">
                                <div class="modern-about-feature-icon">
                                    <i class="bi bi-shield-check"></i>
                                </div>
                                <div class="modern-about-feature-text">
                                    <h4>Kualitas Terjamin</h4>
                                    <p>Air yang kami distribusikan telah melalui proses pengolahan dan pengujian ketat
                                        sesuai standar kesehatan nasional</p>
                                </div>
                            </div>

                            <div class="modern-about-feature" data-aos="fade-up" data-aos-delay="200">
                                <div class="modern-about-feature-icon">
                                    <i class="bi bi-clock-history"></i>
                                </div>
                                <div class="modern-about-feature-text">
                                    <h4>Layanan 24/7</h4>
                                    <p>Sistem distribusi air yang kontinyu dan tim customer service yang siap membantu
                                        Anda kapan saja</p>
                                </div>
                            </div>

                            <div class="modern-about-feature" data-aos="fade-up" data-aos-delay="300">
                                <div class="modern-about-feature-icon">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="modern-about-feature-text">
                                    <h4>Melayani Ribuan Pelanggan</h4>
                                    <p>Dipercaya oleh ribuan rumah tangga dan usaha di Kota Gorontalo untuk kebutuhan
                                        air bersih sehari-hari</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modern-about-animation" data-aos="fade-left">
                        <div class="modern-about-animation-wrapper">
                            <script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.8.5/dist/dotlottie-wc.js"
                                type="module"></script>

                            <dotlottie-wc
                                src="https://lottie.host/37db8280-9322-46aa-bc59-35ea54e21ca0/OyrSOjvXRC.lottie"
                                background="transparent" speed="1" style="width: 100%; height: 100%;" autoplay>
                            </dotlottie-wc>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ======= Info Gangguan Section - MODERN ======= -->
        <section class="modern-info-section">
            <div class="container">
                <div class="modern-section-header" data-aos="fade-up">
                    <h2 class="modern-section-title">Info Gangguan</h2>
                    <p class="modern-section-subtitle">Informasi terkini mengenai gangguan pelayanan di wilayah Anda</p>
                </div>

                <div class="swiper modern-swiper" data-aos="fade-up" data-aos-delay="200">
                    <div class="swiper-wrapper">
                        <?php $all_gangguan = selectAll('informasi', ['tag' => 'info Gangguan'], 'tanggal_buat'); ?>
                        <?php foreach ($all_gangguan as $i) : ?>
                        <div class="swiper-slide">
                            <div class="modern-info-card">
                                <div class="modern-info-image">
                                    <?php if (isset($i['image']) && !empty($i['image'])) : ?>
                                    <img src="<?= BASE_URL . '/assets/info/' . $i['image'] ?>"
                                        alt="<?= htmlspecialchars($i['judul']) ?>">
                                    <?php else : ?>
                                    <img src="<?= BASE_URL . '/assets/image/info-gangguan.jpg' ?>" alt="Info Gangguan">
                                    <?php endif; ?>
                                    <div class="modern-info-badge">
                                        <i class="bi bi-exclamation-triangle-fill"></i>
                                        <span>Gangguan</span>
                                    </div>
                                </div>

                                <div class="modern-info-content">
                                    <h3 class="modern-info-title">
                                        <?= substr($i['judul'], 0, 70) . (strlen($i['judul']) > 70 ? '...' : '') ?>
                                    </h3>

                                    <div class="modern-info-meta">
                                        <div class="modern-info-meta-item">
                                            <i class="bi bi-person-circle"></i>
                                            <span><?= htmlspecialchars($i['author']) ?></span>
                                        </div>
                                        <div class="modern-info-meta-item">
                                            <i class="bi bi-calendar-event"></i>
                                            <span><?= date('d M Y', strtotime($i['tanggal_buat'])) ?></span>
                                        </div>
                                    </div>

                                    <a href="<?= BASE_URL . '/info-gangguan-detail/' . $i['slug'] ?>"
                                        class="modern-info-link">
                                        Lihat Selengkapnya
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </section>

        <!-- ======= Berita Section - MODERN ======= -->
        <section class="modern-berita-section">
            <div class="container">
                <div class="modern-section-header" data-aos="fade-up">
                    <h2 class="modern-section-title">Berita Terkini</h2>
                    <p class="modern-section-subtitle">Update berita dan kegiatan PERUMDA Muara Tirta</p>
                </div>

                <div class="swiper modern-swiper" data-aos="fade-up" data-aos-delay="200">
                    <div class="swiper-wrapper">
                        <?php $info_berita = selectAll('informasi', ['tag' => 'Berita'], 'tanggal_buat'); ?>
                        <?php foreach ($info_berita as $i) : ?>
                        <div class="swiper-slide">
                            <article class="modern-berita-card">
                                <div class="modern-berita-image">
                                    <img src="<?= BASE_URL . '/assets/info/' . $i['image'] ?>"
                                        alt="<?= htmlspecialchars($i['judul']) ?>">
                                    <div class="modern-berita-date">
                                        <i class="bi bi-calendar3"></i>
                                        <span><?= date('d/m/Y', strtotime($i['tanggal_buat'])) ?></span>
                                    </div>
                                </div>

                                <div class="modern-berita-content">
                                    <span class="modern-berita-category">
                                        <i class="bi bi-tag-fill"></i>
                                        <?= htmlspecialchars($i['tag']) ?>
                                    </span>

                                    <h3 class="modern-berita-title">
                                        <?= substr($i['judul'], 0, 80) . (strlen($i['judul']) > 80 ? '...' : '') ?>
                                    </h3>

                                    <p class="modern-berita-excerpt">
                                        <?= substr(strip_tags($i['body'] ?? ''), 0, 120) . '...' ?>
                                    </p>

                                    <div class="modern-berita-meta">
                                        <div class="modern-berita-author">
                                            <div class="modern-berita-author-avatar">
                                                <?= strtoupper(substr($i['author'], 0, 1)) ?>
                                            </div>
                                            <span><?= htmlspecialchars($i['author']) ?></span>
                                        </div>
                                    </div>

                                    <a href="<?= BASE_URL . '/detail-berita/' . $i['slug'] ?>"
                                        class="modern-berita-link">
                                        Baca Selengkapnya
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </article>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </section>

        <!-- ======= Mitra Section ======= -->
        <section id="features" class="features section-bg py-5">
            <div class="container" data-aos="fade-up">
                <div class="modern-section-header">
                    <h2 class="modern-section-title">Mitra Pembayaran</h2>
                    <p class="modern-section-subtitle">Bayar tagihan air dengan mudah melalui berbagai kanal</p>
                </div>

                <div class="mitra-logo d-flex align-items-center justify-content-center flex-wrap gap-4"
                    style="max-width: 1000px; margin: 0 auto;">
                    <div class="mitra-logo-item" data-aos="zoom-in" data-aos-delay="100">
                        <img src="<?= BASE_URL ?>/assets/image/Group-17.png" alt="Mitra 1">
                    </div>
                    <div class="mitra-logo-item" data-aos="zoom-in" data-aos-delay="150">
                        <img src="<?= BASE_URL ?>/assets/image/Logo_Bank_BSG.png" alt="Bank BSG">
                    </div>
                    <div class="mitra-logo-item" data-aos="zoom-in" data-aos-delay="200">
                        <img src="<?= BASE_URL ?>/assets/image/Group-20.png" alt="Mitra 3">
                    </div>
                    <div class="mitra-logo-item" data-aos="zoom-in" data-aos-delay="250">
                        <img src="<?= BASE_URL ?>/assets/image/6d348add535c3c623309ebf5c1ee0c88_brand-architecture-bukalapak-primary@2x-1.png"
                            alt="Bukalapak">
                    </div>
                    <div class="mitra-logo-item" data-aos="zoom-in" data-aos-delay="300">
                        <img src="<?= BASE_URL ?>/assets/image/2560px-Bank_BTN_logo.svg.png" alt="Bank BTN">
                    </div>
                    <div class="mitra-logo-item" data-aos="zoom-in" data-aos-delay="350">
                        <img src="<?= BASE_URL ?>/assets/image/briva.png" alt="BRI VA">
                    </div>
                    <div class="mitra-logo-item" data-aos="zoom-in" data-aos-delay="400">
                        <img src="<?= BASE_URL ?>/assets/image/Group-21.png" alt="Mitra 7">
                    </div>
                    <div class="mitra-logo-item" data-aos="zoom-in" data-aos-delay="450">
                        <img src="<?= BASE_URL ?>/assets/image/Logo-myBCA-720x405.jpg" alt="myBCA">
                    </div>
                    <div class="mitra-logo-item" data-aos="zoom-in" data-aos-delay="500">
                        <img src="<?= BASE_URL ?>/assets/image/Group-22.png" alt="Mitra 9">
                    </div>
                    <div class="mitra-logo-item" data-aos="zoom-in" data-aos-delay="550">
                        <img src="<?= BASE_URL ?>/assets/image/Group-23.png" alt="Mitra 10">
                    </div>
                    <div class="mitra-logo-item" data-aos="zoom-in" data-aos-delay="600">
                        <img src="<?= BASE_URL ?>/assets/image/griyabayar8e-nyamping.png" alt="Griya Bayar">
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Chat Widget Button -->
    <button class="chat-widget-btn" id="chatWidgetBtn">
        <i class="bi bi-chat-dots-fill"></i>
        <span class="badge bg-danger" id="notificationBadge" style="display: none;">1</span>
    </button>

    <!-- Chat Window -->
    <div class="chat-window" id="chatWindow">
        <!-- Chat Header -->
        <div class="chat-header">
            <div class="d-flex align-items-center">
                <div class="chat-avatar">
                    <i class="bi bi-droplet-fill"></i>
                </div>
                <div class="ms-2">
                    <h6 class="mb-0">Tirta Assistant</h6>
                    <small class="text-white-50">Virtual Assistant PDAM Muaratirta</small>
                </div>
            </div>
            <button class="btn btn-sm btn-link text-white" id="closeChatBtn">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <!-- Chat Body -->
        <div class="chat-body" id="chatBody">
            <!-- Welcome Message -->
            <div class="message bot-message">
                <div class="message-avatar">
                    <i class="bi bi-robot"></i>
                </div>
                <div class="message-content">
                    <p>Halo! 👋 Saya <strong>Tirta</strong>, asisten virtual PDAM Muaratirta.</p>
                    <p>Saya siap membantu Anda dengan:</p>
                    <ul class="mb-2">
                        <li>Informasi tarif dan layanan</li>
                        <li>Cek status tagihan</li>
                        <li>Panduan pengaduan</li>
                        <li>FAQ seputar PDAM</li>
                    </ul>
                    <p class="mb-0">Ada yang bisa saya bantu? 😊</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions" id="quickActions">
            <button class="quick-action-btn" onclick="showCekTagihan()">
                <i class="bi bi-file-text"></i>
                Cek Tagihan
            </button>
            <button class="quick-action-btn" onclick="showFormPengaduan()">
                <i class="bi bi-megaphone"></i>
                Kirim Pengaduan
            </button>
        </div>

        <!-- Chat Input -->
        <div class="chat-input">
            <textarea class="form-control" id="messageInput" rows="1" placeholder="Ketik pesan Anda..."></textarea>
            <button class="btn btn-primary" id="sendBtn">
                <i class="bi bi-send-fill"></i>
            </button>
        </div>
    </div>

    <!-- Modal Cek Tagihan -->
    <div class="modal fade" id="modalCekTagihan" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cek Tagihan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nomor Pelanggan</label>
                        <input type="text" class="form-control" id="noPelangganTagihan"
                            placeholder="Masukkan nomor pelanggan">
                    </div>
                    <div id="hasilTagihan"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" onclick="cekTagihan()">Cek Tagihan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form Pengaduan -->
    <div class="modal fade" id="modalPengaduan" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form Pengaduan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formPengaduan" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Nomor Pelanggan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="id_pel" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nm_lengkap" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="alamat" rows="2" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor HP <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="no_hp" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Isi Pengaduan <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="isi_pengaduan" rows="4" required
                                placeholder="Jelaskan pengaduan Anda..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Foto (Opsional)</label>
                            <input type="file" class="form-control" name="foto" accept="image/*">
                            <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 5MB</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="submitPengaduan()">Kirim Pengaduan</button>
                </div>
            </div>
        </div>
    </div>


    <?php include(ROOT_PATH . '/include/footer.php'); ?>

    <!-- <a href="#" class="scroll-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a> -->

    <div id="preloader"></div>

    <?php include(ROOT_PATH . '/include/scripts.php'); ?>

    <script>
    $(document).ready(function() {
        // Service card navigation
        $('#pasang-baru').on('click', function(e) {
            e.preventDefault();
            location.href = '<?= BASE_URL . '/pasang-baru' ?>';
        });

        $('#lapor-keluhan').on('click', function(e) {
            e.preventDefault();
            location.href = '<?= BASE_URL . '/lapor-keluhan' ?>';
        });

        $('#cek-tagihan').on('click', function(e) {
            e.preventDefault();
            location.href = '<?= BASE_URL . '/cek-tagihan' ?>';
        });

        // Initialize Swiper for Info Gangguan
        const swiperInfo = new Swiper('.modern-info-section .swiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.modern-info-section .swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.modern-info-section .swiper-button-next',
                prevEl: '.modern-info-section .swiper-button-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            },
        });

        // Initialize Swiper for Berita
        const swiperBerita = new Swiper('.modern-berita-section .swiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.modern-berita-section .swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.modern-berita-section .swiper-button-next',
                prevEl: '.modern-berita-section .swiper-button-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            },
        });
    });
    </script>
</body>

</html>