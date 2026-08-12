<?php
include("path.php");
include(ROOT_PATH . '/app/controllers/struktur-organisasi.php');
$direksi = selectAll('staff', ['kd_bagian' => 'BGN-4864']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Struktur Organisasi | Muaratirta Kota Gorontalo</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Roboto:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Work+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">
    <link href="assets/logo/Logo-PDAM-MT-min.ico" rel="icon">

    <?php include(ROOT_PATH . '/include/styles.php'); ?>

    <style>
    /* Struktur Organisasi Enhanced Styles - Prefix: so- */
    .so-enhanced-section {
        padding: 60px 0;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    }

    /* Leadership Cards */
    .so-leadership-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 30px;
        margin-bottom: 50px;
    }

    .so-leader-card {
        background: #ffffff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(0, 123, 255, 0.1);
    }

    .so-leader-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 16px 40px rgba(0, 123, 255, 0.15);
    }

    .so-leader-image {
        position: relative;
        width: 100%;
        height: 280px;
        overflow: hidden;
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    }

    .so-leader-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .so-leader-card:hover .so-leader-image img {
        transform: scale(1.05);
    }

    .so-leader-badge {
        position: absolute;
        top: 16px;
        right: 16px;
        background: rgba(255, 255, 255, 0.95);
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        color: #007bff;
        backdrop-filter: blur(10px);
    }

    .so-leader-content {
        padding: 24px;
    }

    .so-leader-name {
        font-size: 20px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 8px;
        line-height: 1.3;
    }

    .so-leader-position {
        color: #007bff;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 16px;
        display: block;
    }

    .so-leader-excerpt {
        color: #666;
        font-size: 14px;
        line-height: 1.7;
        margin-bottom: 16px;
    }

    .so-read-more {
        display: inline-flex;
        align-items: center;
        color: #007bff;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .so-read-more:hover {
        color: #0056b3;
        gap: 8px;
    }

    .so-read-more i {
        margin-left: 8px;
        transition: margin-left 0.3s ease;
    }

    .so-read-more:hover i {
        margin-left: 12px;
    }

    /* Department Section */
    .so-department-header {
        text-align: center;
        margin: 60px 0 40px;
    }

    .so-department-title {
        font-size: 32px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 12px;
        position: relative;
        display: inline-block;
    }

    .so-department-title:after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, #007bff, #0056b3);
        border-radius: 2px;
    }

    .so-department-subtitle {
        color: #666;
        font-size: 16px;
        margin-top: 20px;
    }

    /* Accordion Department Cards */
    .so-accordion-item {
        background: #ffffff;
        border-radius: 16px;
        margin-bottom: 20px;
        overflow: hidden;
        border: 1px solid rgba(0, 123, 255, 0.1);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
    }

    .so-accordion-item:hover {
        box-shadow: 0 8px 24px rgba(0, 123, 255, 0.12);
    }

    .so-accordion-header {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        border: none;
        border-radius: 0;
    }

    .so-accordion-button {
        background: transparent;
        color: #ffffff;
        font-size: 16px;
        font-weight: 600;
        padding: 20px 24px;
        border: none;
        box-shadow: none !important;
        position: relative;
    }

    .so-accordion-button:not(.collapsed) {
        background: transparent;
        color: #ffffff;
    }

    .so-accordion-button::after {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23ffffff'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
    }

    .so-accordion-body {
        padding: 24px;
        background: #fafbfc;
    }

    /* Member Cards */
    .so-member-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
    }

    .so-member-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
    }

    .so-member-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 123, 255, 0.1);
        border-color: #007bff;
    }

    .so-member-img {
        width: 120px;
        height: 120px;
        margin: 0 auto 16px;
        border-radius: 50%;
        overflow: hidden;
        border: 4px solid #f0f0f0;
        transition: all 0.3s ease;
    }

    .so-member-card:hover .so-member-img {
        border-color: #007bff;
    }

    .so-member-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .so-member-name {
        font-size: 15px;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 6px;
    }

    .so-member-position {
        font-size: 13px;
        color: #007bff;
        font-weight: 500;
    }

    /* Lottie Animation */
    .so-lottie-wrapper {
        display: flex;
        justify-content: center;
        margin-bottom: 40px;
    }

    /* Modal Enhancements */
    .so-modal-header {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        color: #ffffff;
        border-radius: 0;
        padding: 20px 24px;
    }

    .so-modal-title {
        font-weight: 700;
        font-size: 20px;
    }

    .so-modal-body {
        padding: 32px;
        line-height: 1.8;
        color: #4a4a4a;
    }

    .so-modal .btn-close {
        filter: brightness(0) invert(1);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .so-leadership-grid {
            grid-template-columns: 1fr;
        }

        .so-member-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 16px;
        }

        .so-department-title {
            font-size: 26px;
        }

        .so-accordion-button {
            font-size: 14px;
            padding: 16px 20px;
        }
    }

    /* Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .so-leader-card,
    .so-accordion-item {
        animation: fadeInUp 0.6s ease-out;
    }
    </style>
</head>

<body>
    <?php include(ROOT_PATH . '/include/header.php'); ?>

    <main id="main">
        <!-- Breadcrumbs -->
        <div class="breadcrumbs d-flex align-items-center"
            style="background-image: url('assets/image/RLC_1016-1-min.jpg');">
            <div class="container position-relative d-flex flex-column align-items-center" data-aos="fade">
                <h2>STRUKTUR ORGANISASI</h2>
                <ol>
                    <li><a href="<?php echo BASE_URL . '/' ?>">Beranda</a></li>
                    <li>Struktur Organisasi</li>
                </ol>
            </div>
        </div>

        <?php include(ROOT_PATH . '/include/webticker.php') ?>

        <!-- Enhanced Struktur Organisasi Section -->
        <section class="so-enhanced-section">
            <div class="container" data-aos="fade-up">

                <!-- Lottie Animation -->
                <!-- <div class="so-lottie-wrapper" data-aos="zoom-in">
                    <lottie-player src="https://lottie.host/8f9c1a2b-3d4e-5f6a-7b8c-9d0e1f2a3b4c/XYZ123ABC.json"
                        background="transparent" speed="1" style="width: 280px; height: 280px;" loop autoplay>
                    </lottie-player>
                </div> -->

                <!-- Leadership Section -->
                <div class="so-leadership-grid">
                    <!-- Leader 1 -->
                    <div class="so-leader-card" data-aos="fade-up" data-aos-delay="100">
                        <div class="so-leader-image">
                            <img src="<?= $direksi[0]['profile_pict'] === null ? BASE_URL . '/assets/image/default-user.jpg' : resolveImageUrl($direksi[0]['profile_pict'], 'staff', ['assets/staff']) ?>"
                                alt="<?= $direksi[0]['nm_lengkap'] ?>">
                            <div class="so-leader-badge">Pembina</div>
                        </div>
                        <div class="so-leader-content">
                            <h3 class="so-leader-name"><?= $direksi[0]['nm_lengkap'] ?></h3>
                            <span class="so-leader-position"><?= $direksi[0]['jabatan'] ?></span>
                            <p class="so-leader-excerpt">
                                Segala puji bagi Allah Subhanahu wa Ta'ala, Tuhan Semesta Alam, yang telah memberikan
                                rahmat, petunjuk, dan karunia-Nya kepada kita...
                            </p>
                            <a href="#" id="sambutan-walikota" class="so-read-more">
                                Baca Sambutan Lengkap <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Leader 2 -->
                    <div class="so-leader-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="so-leader-image">
                            <img src="<?= $direksi[1]['profile_pict'] === null ? BASE_URL . '/assets/image/default-user.jpg' : resolveImageUrl($direksi[1]['profile_pict'], 'staff', ['assets/staff']) ?>"
                                alt="<?= $direksi[1]['nm_lengkap'] ?>">
                            <div class="so-leader-badge">Pengawas</div>
                        </div>
                        <div class="so-leader-content">
                            <h3 class="so-leader-name"><?= $direksi[1]['nm_lengkap'] ?></h3>
                            <span class="so-leader-position"><?= $direksi[1]['jabatan'] ?></span>
                            <p class="so-leader-excerpt">
                                Dengan rasa penuh syukur, kami ingin berbagi perjalanan PDAM Muara Tirta, sebuah
                                perusahaan yang telah tumbuh dan berkembang...
                            </p>
                            <a href="#" id="sambutan-dewan-pengawas" class="so-read-more">
                                Baca Sambutan Lengkap <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Leader 3 -->
                    <div class="so-leader-card" data-aos="fade-up" data-aos-delay="300">
                        <div class="so-leader-image">
                            <img src="<?= $direksi[2]['profile_pict'] === null ? BASE_URL . '/assets/image/default-user.jpg' : resolveImageUrl($direksi[2]['profile_pict'], 'staff', ['assets/staff']) ?>"
                                alt="<?= $direksi[2]['nm_lengkap'] ?>">
                            <div class="so-leader-badge">Direktur</div>
                        </div>
                        <div class="so-leader-content">
                            <h3 class="so-leader-name"><?= $direksi[2]['nm_lengkap'] ?></h3>
                            <span class="so-leader-position"><?= $direksi[2]['jabatan'] ?></span>
                            <p class="so-leader-excerpt">
                                Dengan mengucap Puji Syukur ke Hadirat Allah SWT, saya mempersembahkan Profil PERUMDA
                                Air Minum Muara Tirta...
                            </p>
                            <a href="#" id="sambutan-direktur" class="so-read-more">
                                Baca Sambutan Lengkap <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Department Header -->
                <div class="so-department-header" data-aos="fade-up">
                    <h2 class="so-department-title">Departemen & Tim</h2>
                    <p class="so-department-subtitle">Struktur organisasi yang solid untuk pelayanan terbaik</p>
                </div>

                <!-- Department Accordion -->
                <div class="accordion accordion-flush" id="departmentAccordion">

                    <!-- Satuan Pengawas Internal -->
                    <div class="so-accordion-item" data-aos="fade-up" data-aos-delay="100">
                        <h2 class="so-accordion-header" id="heading-spi">
                            <button class="so-accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse-spi" aria-expanded="false" aria-controls="collapse-spi">
                                <i class="fas fa-shield-alt me-3"></i> SATUAN PENGAWAS INTERNAL
                            </button>
                        </h2>
                        <div id="collapse-spi" class="accordion-collapse collapse" aria-labelledby="heading-spi"
                            data-bs-parent="#departmentAccordion">
                            <div class="so-accordion-body">
                                <div class="so-member-grid">
                                    <?php foreach (selectAll('staff', ['kd_bagian' => 'BGN-6713']) as $member) : ?>
                                    <div class="so-member-card">
                                        <div class="so-member-img">
                                            <img src="<?= $member['profile_pict'] === '' ? BASE_URL . '/assets/image/default-user.jpg' : resolveImageUrl($member['profile_pict'], 'staff', ['assets/staff']) ?>"
                                                alt="<?= $member['nm_lengkap'] ?>">
                                        </div>
                                        <h4 class="so-member-name"><?= $member['nm_lengkap'] ?></h4>
                                        <span class="so-member-position"><?= $member['jabatan'] ?></span>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Departemen Adm. Umum & Keuangan -->
                    <div class="so-accordion-item" data-aos="fade-up" data-aos-delay="200">
                        <h2 class="so-accordion-header" id="heading-auk">
                            <button class="so-accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse-auk" aria-expanded="false" aria-controls="collapse-auk">
                                <i class="fas fa-coins me-3"></i> DEPARTEMEN ADM. UMUM & KEUANGAN
                            </button>
                        </h2>
                        <div id="collapse-auk" class="accordion-collapse collapse" aria-labelledby="heading-auk"
                            data-bs-parent="#departmentAccordion">
                            <div class="so-accordion-body">
                                <div class="so-member-grid">
                                    <?php foreach (selectAll('staff', ['kd_bagian' => 'BGN-2686']) as $member) : ?>
                                    <div class="so-member-card">
                                        <div class="so-member-img">
                                            <img src="<?= $member['profile_pict'] === '' ? BASE_URL . '/assets/image/default-user.jpg' : resolveImageUrl($member['profile_pict'], 'staff', ['assets/staff']) ?>"
                                                alt="<?= $member['nm_lengkap'] ?>">
                                        </div>
                                        <h4 class="so-member-name"><?= $member['nm_lengkap'] ?></h4>
                                        <span class="so-member-position"><?= $member['jabatan'] ?></span>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Departemen Hubungan Langganan -->
                    <div class="so-accordion-item" data-aos="fade-up" data-aos-delay="300">
                        <h2 class="so-accordion-header" id="heading-hl">
                            <button class="so-accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse-hl" aria-expanded="false" aria-controls="collapse-hl">
                                <i class="fas fa-users me-3"></i> DEPARTEMEN HUBUNGAN LANGGANAN
                            </button>
                        </h2>
                        <div id="collapse-hl" class="accordion-collapse collapse" aria-labelledby="heading-hl"
                            data-bs-parent="#departmentAccordion">
                            <div class="so-accordion-body">
                                <div class="so-member-grid">
                                    <?php foreach (selectAll('staff', ['kd_bagian' => 'BGN-8727']) as $member) : ?>
                                    <div class="so-member-card">
                                        <div class="so-member-img">
                                            <img src="<?= $member['profile_pict'] === '' ? BASE_URL . '/assets/image/default-user.jpg' : resolveImageUrl($member['profile_pict'], 'staff', ['assets/staff']) ?>"
                                                alt="<?= $member['nm_lengkap'] ?>">
                                        </div>
                                        <h4 class="so-member-name"><?= $member['nm_lengkap'] ?></h4>
                                        <span class="so-member-position"><?= $member['jabatan'] ?></span>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Departemen Teknik & Pengembangan -->
                    <div class="so-accordion-item" data-aos="fade-up" data-aos-delay="400">
                        <h2 class="so-accordion-header" id="heading-tp">
                            <button class="so-accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse-tp" aria-expanded="false" aria-controls="collapse-tp">
                                <i class="fas fa-tools me-3"></i> DEPARTEMEN TEKNIK & PENGEMBANGAN
                            </button>
                        </h2>
                        <div id="collapse-tp" class="accordion-collapse collapse" aria-labelledby="heading-tp"
                            data-bs-parent="#departmentAccordion">
                            <div class="so-accordion-body">
                                <div class="so-member-grid">
                                    <?php foreach (selectAll('staff', ['kd_bagian' => 'BGN-2568']) as $member) : ?>
                                    <div class="so-member-card">
                                        <div class="so-member-img">
                                            <img src="<?= $member['profile_pict'] === '' ? BASE_URL . '/assets/image/default-user.jpg' : resolveImageUrl($member['profile_pict'], 'staff', ['assets/staff']) ?>"
                                                alt="<?= $member['nm_lengkap'] ?>">
                                        </div>
                                        <h4 class="so-member-name"><?= $member['nm_lengkap'] ?></h4>
                                        <span class="so-member-position"><?= $member['jabatan'] ?></span>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section>

    </main>

    <!-- Modal Sambutan Walikota -->
    <div class="modal fade" id="walikota" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="so-modal-header">
                    <h5 class="so-modal-title">Sambutan Walikota Gorontalo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="so-modal-body">
                    <p>Assalamualaikum Wr. Wb.,</p>
                    <p>Segala puji bagi Allah Subhanahu wa Ta'ala, Tuhan Semesta Alam, yang telah memberikan rahmat,
                        petunjuk, dan karunia-Nya kepada kita. Shalawat dan salam semoga tercurah kepada junjungan kita,
                        Nabi Muhammad SAW, keluarga, dan para sahabatnya yang mulia. Dalam upaya menjalankan tanggung
                        jawab kami sebagai pelayan publik yang diamanahkan oleh masyarakat, kami dengan senang hati
                        mempersembahkan profil Perusahaan Daerah Air Minum Muara Tirta Kota Gorontalo kepada masyarakat
                        Kota Gorontalo. Melalui profil ini, kami ingin berbagi dengan bapak / ibu semua tentang peran
                        penting Perumda Air Minum Muara Tirta Kota Gorontalo dalam menjaga ketersediaan air bersih yang
                        berkualitas bagi seluruh lapisan masyarakat.</p>
                    <p>Perusahaan Daerah Air Minum Muara Tirta Kota Gorontalo bukan hanya sebuah perusahaan, tetapi juga
                        merupakan penggerak penting dalam mendukung pembangunan berkelanjutan Kota Gorontalo. Dengan
                        komitmen untuk menyediakan air minum yang aman, bersih, dan terjangkau, Perusahaan Daerah Air
                        Minum Muara Tirta Kota Gorontalo telah menjadi mitra setia dalam menjaga kesehatan dan
                        kesejahteraan masyarakat kami.</p>
                    <p>Profil ini memberikan gambaran lengkap tentang berbagai upaya dan program yang telah dijalankan
                        oleh Perusahaan Daerah Air Minum Muara Tirta Kota Gorontalo untuk memenuhi kebutuhan air minum
                        warga Kota Gorontalo. Dari pengelolaan sumber daya air hingga pemberdayaan masyarakat dalam
                        penggunaan air secara bijak, kami berkomitmen untuk tetap bergerak maju demi kesejahteraan
                        bersama.</p>
                    <p>Kami ingin menyampaikan apresiasi yang tinggi kepada seluruh tim Perusahaan Daerah Air Minum
                        Muara Tirta Kota Gorontalo, yang telah bekerja keras dan berdedikasi dalam menghadirkan layanan
                        air minum yang berkualitas tinggi. Terima kasih juga kepada semua pemangku kepentingan, mitra
                        kerja, dan masyarakat yang telah mendukung langkah-langkah kami dalam membangun Kota Gorontalo
                        yang lebih baik.</p>
                    <p>Semoga profil Perusahaan Daerah Air Minum Muara Tirta Kota Gorontalo ini dapat memberikan wawasan
                        yang lebih dalam tentang peran penting Perumda Air Minum Muara Tirta Kota Gorontalo dalam
                        menjaga keberlanjutan dan keseimbangan lingkungan hidup. Mari kita bersama-sama menjaga dan
                        menghargai sumber daya alam ini, untuk generasi masa depan yang lebih baik.</p>
                    <p>Akhir kata, kami berharap agar langkah Perusahaan Daerah Air Minum Muara Tirta Kota Gorontalo
                        senantiasa diberkahi oleh Allah SWT dan mendapat dukungan serta kerjasama dari kita semua. Mari
                        terus bersatu dalam menjaga keberlanjutan dan meningkatkan kualitas hidup di Kota Gorontalo.</p>
                    <p><strong>Wassalamualaikum Wr. Wb.</strong></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Sambutan Dewan Pengawas -->
    <div class="modal fade" id="dewan-pengawas" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="so-modal-header">
                    <h5 class="so-modal-title">Sambutan Dewan Pengawas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="so-modal-body">
                    <p>Assalamualaikum Warahmatullahi Wabarakatuh…</p>
                    <p>Selamat Pagi…</p>
                    <p>Dengan rasa penuh syukur, kami ingin berbagi perjalanan PDAM Muara Tirta, sebuah perusahaan yang
                        telah tumbuh dan berkembang dalam memberikan layanan air minum di tengah-tengah masyarakat.
                        Melalui dedikasi kami, kami berupaya untuk terus menjadi bagian dari kehidupan sehari-hari warga
                        Kota Gorontalo, memenuhi kebutuhan akan air bersih yang berkualitas.</p>
                    <p>Kami mengangkat sebuah semangat untuk terus berinovasi dan memperkuat fondasi pelayanan kami.
                        Langkah-langkah ke depan yang kami rancang melibatkan upaya kolaboratif dengan masyarakat dan
                        pihak terkait, dengan tujuan menciptakan lingkungan yang lebih baik. Ini adalah kisah kami, yang
                        terus berkembang seiring waktu.</p>
                    <p>Semoga perjalanan ini dapat terus membawa manfaat bagi masyarakat Kota Gorontalo, dan kami
                        berharap dapat terus mendengar aspirasi dan harapan dari Anda semua. Terima kasih atas dukungan
                        yang telah diberikan, dan mari bersama-sama membangun masa depan yang lebih baik.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Sambutan Direktur -->
    <div class="modal fade" id="direktur" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="so-modal-header">
                    <h5 class="so-modal-title">Sambutan Direktur PDAM</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="so-modal-body">
                    <p>Assalamualaikum Warahmatullahi Wabarakatuh…</p>
                    <p>Selamat Pagi…</p>
                    <p>Dengan mengucap Puji Syukur ke Hadirat Allah SWT, saya mempersembahkan Profil PERUMDA Air Minum
                        Muara Tirta Kota Gorontalo. Dengan maksud untuk memberikan informasi kepada masyarakat
                        berdasarkan Peraturan Daerah Kota Gorontalo Nomor 3 Tahun 2022 tentang Pendirian Perusahaan Umum
                        Daerah Air Minum Muara Tirta, telah memiliki program rencana kerja ke depan</p>
                    <p><strong>Program-program itu meliputi:</strong></p>
                    <ul>
                        <li>Peningkatan Debit Kapasitas Pengembangan Jaringan Perpipaan;</li>
                        <li>Peningkatan Debit Kapasitas</li>
                        <li>Peningkatan Kualitas Air Baku</li>
                        <li>Peningkatan Pelayanan Air Minum</li>
                        <li>Peningkatan Pendapatan</li>
                        <li>Penerapan Manajemen Biaya</li>
                    </ul>
                    <p>Semua Rencana Kerja tersebut dilakukan untuk meningkatkan kinerja perusahaan sebagai Langkah
                        peningkatan mutu dan kualitas layanan air bersih kepada para pelanggan atau masyarakat Kota
                        Gorontalo pada umumnya.</p>
                </div>
            </div>
        </div>
    </div>

    <?php include(ROOT_PATH . '/include/footer.php'); ?>

    <a href="#" class="scroll-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <div id="preloader"></div>

    <!-- Lottie Player Script -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

    <?php include(ROOT_PATH . '/include/scripts.php'); ?>

    <script>
    // Modal triggers
    $('#sambutan-walikota').on('click', function(e) {
        e.preventDefault();
        $('#walikota').modal('show');
    });

    $('#sambutan-dewan-pengawas').on('click', function(e) {
        e.preventDefault();
        $('#dewan-pengawas').modal('show');
    });

    $('#sambutan-direktur').on('click', function(e) {
        e.preventDefault();
        $('#direktur').modal('show');
    });

    // Accordion auto-expand on desktop
    $(document).ready(function() {
        function adjustAccordion() {
            if ($(window).width() >= 768) {
                $('#collapse-spi, #collapse-auk, #collapse-hl, #collapse-tp').addClass('show');
            } else {
                $('#collapse-spi, #collapse-auk, #collapse-hl, #collapse-tp').removeClass('show');
            }
        }

        adjustAccordion();

        $(window).resize(function() {
            adjustAccordion();
        });
    });
    </script>
</body>

</html>