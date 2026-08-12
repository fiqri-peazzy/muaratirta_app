<?php
include("path.php");
include(ROOT_PATH . '/app/controllers/users.php');
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Tentang Perusahaan | Muara Tirta Kota Gorontalo</title>
    <meta name="description"
        content="Profil dan Sejarah PERUMDA Air Minum Muara Tirta Kota Gorontalo. Melayani dengan standar K4 untuk kualitas hidup masyarakat yang lebih baik.">
    <meta name="keywords" content="Profil PDAM Gorontalo, Sejarah Muara Tirta, PERUMDA Air Minum Gorontalo">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Roboto:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Work+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">
    <link href="assets/logo/Logo-PDAM-MT-min.ico" rel="icon">

    <?php include(ROOT_PATH . '/include/styles.php'); ?>

    <style>
    .about-history-timeline {
        position: relative;
        padding: 40px 0;
    }

    .about-history-timeline::before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        left: 50%;
        width: 2px;
        background: #e9ecef;
        transform: translateX(-50%);
    }

    .timeline-item {
        margin-bottom: 60px;
        position: relative;
        width: 50%;
    }

    .timeline-item:nth-child(odd) {
        left: 0;
        padding-right: 40px;
        text-align: right;
    }

    .timeline-item:nth-child(even) {
        left: 50%;
        padding-left: 40px;
    }

    .timeline-dot {
        width: 20px;
        height: 20px;
        background: var(--modern-primary);
        border: 4px solid #fff;
        border-radius: 50%;
        position: absolute;
        top: 0;
        z-index: 10;
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.2);
    }

    .timeline-item:nth-child(odd) .timeline-dot {
        right: -10px;
    }

    .timeline-item:nth-child(even) .timeline-dot {
        left: -10px;
    }

    .timeline-content {
        padding: 30px;
        background: #fff;
        border-radius: 15px;
        box-shadow: var(--modern-shadow-sm);
        transition: var(--modern-transition);
        border-top: 4px solid var(--modern-primary);
    }

    .timeline-content:hover {
        transform: translateY(-5px);
        box-shadow: var(--modern-shadow-md);
    }

    .timeline-year {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--modern-primary);
        margin-bottom: 10px;
        display: block;
    }

    .transformation-section {
        background: linear-gradient(135deg, var(--modern-dark) 0%, #1c2837 100%);
        color: #fff;
        padding: 80px 0;
        border-radius: 30px;
        margin: 40px 0;
        position: relative;
        overflow: hidden;
    }

    .transformation-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(13, 110, 253, 0.1) 0%, transparent 70%);
    }

    @media (max-width: 768px) {
        .about-history-timeline::before {
            left: 20px;
        }

        .timeline-item {
            width: 100%;
            left: 0 !important;
            padding-left: 40px !important;
            padding-right: 0 !important;
            text-align: left !important;
            margin-bottom: 40px;
        }

        .timeline-item:nth-child(odd) .timeline-dot,
        .timeline-item:nth-child(even) .timeline-dot {
            left: 10px;
        }
    }
    </style>

</head>

<body>

    <?php include(ROOT_PATH . '/include/header.php'); ?>

    <main id="main">

        <!-- ======= Breadcrumbs ======= -->
        <div class="breadcrumbs d-flex align-items-center"
            style="background-image: url('assets/image/RLC_1016-1-min.jpg');">
            <div class="container position-relative d-flex flex-column align-items-center" data-aos="fade">

                <h2>Tentang Perusahaan</h2>
                <ol>
                    <li><a href="<?php echo BASE_URL . '/' ?>">Beranda</a></li>
                    <li>Tentang Perusahaan</li>
                </ol>

            </div>
        </div><!-- End Breadcrumbs -->

        <?php include(ROOT_PATH . '/include/webticker.php') ?>

        <!-- ======= Intro Section ======= -->
        <section class="modern-about-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6" data-aos="fade-right">
                        <span class="modern-about-badge">
                            <i class="bi bi-droplet-fill me-2"></i>
                            Siap Melayani
                        </span>
                        <h2 class="modern-about-title">
                            Menyediakan Air Bersih Untuk <span>Masyarakat Gorontalo</span>
                        </h2>
                        <p class="modern-about-description">
                            PERUMDA Air Minum Muara Tirta Kota Gorontalo adalah pilar utama penyedia air bersih di Kota
                            Gorontalo.
                            Kami berkomitmen penuh untuk meningkatkan taraf hidup masyarakat melalui ketersediaan air
                            minum yang memenuhi standar K4.
                        </p>
                        <div class="row g-4 mb-4">
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="modern-about-feature-icon me-3"
                                        style="width: 40px; height: 40px; font-size: 1rem;">
                                        <i class="bi bi-check2-circle"></i>
                                    </div>
                                    <h5 class="mb-0 fw-bold">Kualitas Terjamin</h5>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="modern-about-feature-icon me-3"
                                        style="width: 40px; height: 40px; font-size: 1rem;">
                                        <i class="bi bi-check2-circle"></i>
                                    </div>
                                    <h5 class="mb-0 fw-bold">Distribusi Kontinu</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6" data-aos="fade-left">
                        <div class="modern-about-animation-wrapper">
                            <script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.8.5/dist/dotlottie-wc.js"
                                type="module"></script>
                            <dotlottie-wc
                                src="https://lottie.host/37db8280-9322-46aa-bc59-35ea54e21ca0/OyrSOjvXRC.lottie"
                                background="transparent" speed="1" style="width: 100%; height: 100%;" autoplay loop>
                            </dotlottie-wc>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ======= Transformation Section ======= -->
        <section class="container" data-aos="fade-up">
            <div class="transformation-section px-4 px-md-5">
                <div class="row align-items-center">
                    <div class="col-lg-7">
                        <h3 class="fw-bold mb-4" style="font-size: 2.25rem;">Transformasi Menjadi PERUMDA</h3>
                        <p style="font-size: 1.1rem; opacity: 0.9; line-height: 1.8;">
                            Dalam upaya meningkatkan profesionalitas dan kualitas pelayanan, institusi kami telah
                            bertransformasi dari
                            <strong>PDAM (Perusahaan Daerah Air Minum)</strong> menjadi <strong>PERUMDA (Perusahaan Umum
                                Daerah) Air Minum Muara Tirta</strong>.
                            Transformasi ini bukan sekadar pergantian nama, melainkan komitmen manajemen baru untuk tata
                            kelola yang lebih modern, transparan, dan berorientasi pada kepuasan pelanggan.
                        </p>
                    </div>
                    <div class="col-lg-5 text-center d-none d-lg-block">
                        <i class="bi bi-shield-shaded" style="font-size: 180px; color: rgba(255,255,255,0.1);"></i>
                    </div>
                </div>
            </div>
        </section>

        <!-- ======= History Timeline Section ======= -->
        <section class="modern-services-section">
            <div class="container">
                <div class="modern-section-header" data-aos="fade-up">
                    <h2 class="modern-section-title">Rekam Jejak & Sejarah</h2>
                    <p class="modern-section-subtitle">Perjalanan kami dalam melayani Kota Gorontalo dari masa ke masa
                    </p>
                </div>

                <div class="about-history-timeline">
                    <!-- Item 1 -->
                    <div class="timeline-item" data-aos="fade-up">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <span class="timeline-year">1981</span>
                            <h4>Berdirinya BPAM Kotamadya Gorontalo</h4>
                            <p>Pembentukan Badan Pengelola Air Minum (BPAM) Kotamadya Dati II Gorontalo berdasarkan
                                Surat Keputusan Dirjen Cipta Karya Departemen PU Nomor 125/KPTS/CK/1981. Ditandai dengan
                                berfungsinya sistem penyediaan air bersih oleh PPSAB Sulawesi Utara.</p>
                        </div>
                    </div>

                    <!-- Item 2 -->
                    <div class="timeline-item" data-aos="fade-up">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <span class="timeline-year">1986</span>
                            <h4>Pembangunan IPA Tanggilingo</h4>
                            <p>Pembangunan Instalasi Pengolahan Air (IPA) dengan kapasitas besar 218 L/dt. Langkah awal
                                dalam modernisasi infrastruktur pengolahan air untuk memenuhi kebutuhan yang terus
                                meningkat di wilayah Gorontalo.</p>
                        </div>
                    </div>

                    <!-- Item 3 -->
                    <div class="timeline-item" data-aos="fade-up">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <span class="timeline-year">1991</span>
                            <h4>Alih Status Menjadi PDAM</h4>
                            <p>Secara resmi beralih status melalui SK Menteri PU Nomor 705/KPTS/1991. Penyerahan
                                Prasarana dan Sarana Air Bersih kepada Gubernur Kepada Daerah Tk I Sulawesi Utara
                                diperkuat dengan BAST No. 01/BA/CK/1991.</p>
                        </div>
                    </div>

                    <!-- Item 4 -->
                    <div class="timeline-item" data-aos="fade-up">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <span class="timeline-year">1997 - 2018</span>
                            <h4>Ekspansi Kapasitas & Jangkauan</h4>
                            <p>Masa pertumbuhan signifikan dengan pembangunan dan peningkatan kapasitas berbagai IPA:
                            </p>
                            <ul class="list-unstyled">
                                <li><i class="bi bi-arrow-right-short text-primary"></i> <strong>IPA Bulotadaa:</strong>
                                    Berkembang dari 20 L/dt (1997) menjadi 50 L/dt (2017).</li>
                                <li><i class="bi bi-arrow-right-short text-primary"></i> <strong>IPA Pilolodaa:</strong>
                                    Mulai beroperasi tahun 2009 dengan 10 L/dt.</li>
                                <li><i class="bi bi-arrow-right-short text-primary"></i> <strong>IPA Dungingi:</strong>
                                    Beroperasi tahun 2016 dengan 20 L/dt.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ======= Service Standards (K4) ======= -->
        <section class="container py-5">
            <div class="modern-section-header" data-aos="fade-up">
                <h2 class="modern-section-title">Standar Pelayanan K4</h2>
                <p class="modern-section-subtitle">Empat pilar utama yang mendasari setiap tetes air yang kami alirkan
                </p>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="100">
                    <div class="modern-service-card" style="min-height: auto; padding: 30px;">
                        <div class="modern-service-icon" style="width: 70px; height: 70px;">
                            <div class="modern-service-icon-bg"></div>
                            <i class="bi bi-patch-check-fill shadow-none position-relative z-1 text-white"
                                style="font-size: 2rem;"></i>
                        </div>
                        <h4 class="fw-bold mt-3">Kualitas</h4>
                        <p class="small text-muted mb-0">Air bersih yang aman dan memenuhi standar kesehatan nasional.
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                    <div class="modern-service-card" style="min-height: auto; padding: 30px;">
                        <div class="modern-service-icon" style="width: 70px; height: 70px;">
                            <div class="modern-service-icon-bg"></div>
                            <i class="bi bi-moisture shadow-none position-relative z-1 text-white"
                                style="font-size: 2rem;"></i>
                        </div>
                        <h4 class="fw-bold mt-3">Kuantitas</h4>
                        <p class="small text-muted mb-0">Ketersediaan volume air yang cukup untuk kebutuhan sehari-hari.
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="300">
                    <div class="modern-service-card" style="min-height: auto; padding: 30px;">
                        <div class="modern-service-icon" style="width: 70px; height: 70px;">
                            <div class="modern-service-icon-bg"></div>
                            <i class="bi bi-infinity shadow-none position-relative z-1 text-white"
                                style="font-size: 2rem;"></i>
                        </div>
                        <h4 class="fw-bold mt-3">Kontinuitas</h4>
                        <p class="small text-muted mb-0">Aliran air yang terus menerus selama 24 jam setiap harinya.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="400">
                    <div class="modern-service-card" style="min-height: auto; padding: 30px;">
                        <div class="modern-service-icon" style="width: 70px; height: 70px;">
                            <div class="modern-service-icon-bg"></div>
                            <i class="bi bi-wallet2 shadow-none position-relative z-1 text-white"
                                style="font-size: 2rem;"></i>
                        </div>
                        <h4 class="fw-bold mt-3">Keterjangkauan</h4>
                        <p class="small text-muted mb-0">Tarif yang adil dan dapat dijangkau oleh seluruh lapisan
                            masyarakat.</p>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <?php include(ROOT_PATH . '/include/footer.php'); ?>

    <a href="#" class="scroll-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <div id="preloader"></div>

    <?php include(ROOT_PATH . '/include/scripts.php'); ?>

</body>

</html>