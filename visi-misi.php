<?php
include("path.php");
include(ROOT_PATH . '/app/controllers/users.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Visi Misi | Muaratirta Kota Gorontalo</title>
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
    /* Custom Styles untuk Visi Misi - Tidak akan nabrak main.css */
    .vm-enhanced-section {
        padding: 60px 0;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    }

    .vm-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        margin-bottom: 30px;
        border: 1px solid rgba(0, 123, 255, 0.08);
        transition: all 0.3s ease;
    }

    .vm-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 32px rgba(0, 123, 255, 0.12);
    }

    .vm-header {
        display: flex;
        align-items: center;
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 3px solid #007bff;
    }

    .vm-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 20px;
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.25);
    }

    .vm-icon i {
        font-size: 28px;
        color: #ffffff;
    }

    .vm-title {
        font-size: 28px;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0;
        letter-spacing: -0.5px;
    }

    .vm-content {
        font-size: 16px;
        line-height: 1.8;
        color: #4a4a4a;
        margin: 0;
    }

    .vm-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .vm-list-item {
        display: flex;
        align-items: flex-start;
        padding: 16px 0;
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.2s ease;
    }

    .vm-list-item:last-child {
        border-bottom: none;
    }

    .vm-list-item:hover {
        background: #f8f9ff;
        padding-left: 10px;
        border-radius: 8px;
    }

    .vm-check-icon {
        width: 28px;
        height: 28px;
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 16px;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .vm-check-icon i {
        font-size: 14px;
        color: #ffffff;
    }

    .vm-list-text {
        font-size: 15px;
        line-height: 1.7;
        color: #4a4a4a;
        flex: 1;
    }

    .vm-lottie-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
        margin-bottom: 30px;
    }

    .vm-badge {
        display: inline-block;
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        color: #ffffff;
        padding: 8px 20px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.5px;
        margin-bottom: 16px;
        text-transform: uppercase;
    }

    .vm-divider {
        height: 4px;
        background: linear-gradient(90deg, #007bff 0%, transparent 100%);
        border-radius: 2px;
        margin: 40px 0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .vm-card {
            padding: 24px;
        }

        .vm-header {
            flex-direction: column;
            text-align: center;
        }

        .vm-icon {
            margin-right: 0;
            margin-bottom: 16px;
        }

        .vm-title {
            font-size: 24px;
        }

        .vm-lottie-wrapper {
            padding: 10px;
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

    .vm-card {
        animation: fadeInUp 0.6s ease-out;
    }

    .vm-card:nth-child(2) {
        animation-delay: 0.1s;
    }

    .vm-card:nth-child(3) {
        animation-delay: 0.2s;
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
                <h2>VISI DAN MISI</h2>
                <ol>
                    <li><a href="<?php echo BASE_URL . '/' ?>">Beranda</a></li>
                    <li>Visi Misi</li>
                </ol>
            </div>
        </div>

        <?php include(ROOT_PATH . '/include/webticker.php') ?>

        <!-- Enhanced Visi Misi Section -->
        <section class="vm-enhanced-section">
            <div class="container" data-aos="fade-up">

                <!-- Lottie Animation -->
                <div class="vm-lottie-wrapper" data-aos="zoom-in">
                    <dotlottie-wc src="https://lottie.host/41bfb167-65aa-4606-88eb-4dd3263926c5/TlcYI4p7Qd.lottie"
                        speed="1" background="transparent" style="width: 300px;height: 300px" autoplay loop>
                    </dotlottie-wc>
                </div>

                <!-- VISI Card -->
                <div class="vm-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="vm-header">
                        <div class="vm-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <h3 class="vm-title">VISI</h3>
                    </div>
                    <span class="vm-badge">PDAM Muara Tirta</span>
                    <p class="vm-content">
                        Peningkatan Pelayanan Air Minum Dalam Memenuhi Standar K4
                    </p>
                </div>

                <!-- MISI Card -->
                <div class="vm-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="vm-header">
                        <div class="vm-icon">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h3 class="vm-title">MISI</h3>
                    </div>
                    <span class="vm-badge">PDAM Muara Tirta</span>
                    <ul class="vm-list">
                        <li class="vm-list-item">
                            <div class="vm-check-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="vm-list-text">Peningkatan Pelayanan Air Bersih</span>
                        </li>
                        <li class="vm-list-item">
                            <div class="vm-check-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="vm-list-text">Pemenuhan Pelayanan Standar K4</span>
                        </li>
                        <li class="vm-list-item">
                            <div class="vm-check-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="vm-list-text">Peningkatan Kinerja PUPR</span>
                        </li>
                    </ul>
                </div>

                <!-- Divider -->
                <div class="vm-divider"></div>

                <!-- VISI Kota Gorontalo Card -->
                <div class="vm-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="vm-header">
                        <div class="vm-icon">
                            <i class="fas fa-city"></i>
                        </div>
                        <h3 class="vm-title">VISI KOTA GORONTALO</h3>
                    </div>
                    <span class="vm-badge">Pemerintah Kota</span>
                    <p class="vm-content">
                        Kota Gorontalo Sejahtera, Maju, Aktif, Religius dan Terdidik (Kota SMART)
                    </p>
                </div>

                <!-- MISI Kota Gorontalo Card -->
                <div class="vm-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="vm-header">
                        <div class="vm-icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <h3 class="vm-title">MISI KOTA GORONTALO</h3>
                    </div>
                    <span class="vm-badge">Pemerintah Kota</span>
                    <ul class="vm-list">
                        <li class="vm-list-item">
                            <div class="vm-check-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="vm-list-text">Mewujudkan Kesetaraan bagi Masyarakat untuk Memperoleh Akses
                                Layanan Pendidikan, Kesehatan dan Layanan Publik Lainnya Yang Terjangkau dan
                                Berkualitas</span>
                        </li>
                        <li class="vm-list-item">
                            <div class="vm-check-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="vm-list-text">Meningkatkan Ketersediaan Infrastruktur yang handal di semua
                                sektor public</span>
                        </li>
                        <li class="vm-list-item">
                            <div class="vm-check-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="vm-list-text">Penguatan Kapasitas UMKM, Koperasi dan pengembangan Sektor
                                Perekonomian Primer lainnya</span>
                        </li>
                        <li class="vm-list-item">
                            <div class="vm-check-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="vm-list-text">Reformasi Birokrasi yang berorientasi pada peningkatan tata
                                kelola, kapasitas organisasi pemerintah, dan kualitas sumber daya aparatur</span>
                        </li>
                        <li class="vm-list-item">
                            <div class="vm-check-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="vm-list-text">Mengembangkan Kualitas Hidup masyarakat yang religius dan
                                berbudaya</span>
                        </li>
                        <li class="vm-list-item">
                            <div class="vm-check-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="vm-list-text">Penguatan Daya Saing Kota Sebagai Pusat Perdagangan dan Jasa di
                                Kawasan Teluk Tomini</span>
                        </li>
                    </ul>
                </div>

            </div>
        </section>

    </main>

    <!-- Modal Login Form -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <button type="button" class="close btn btn-primary" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="login-container">
                        <h2 class="text-primary">Login</h2>
                        <form method="post">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="u_name" class="form-control" id="username"
                                    placeholder="Enter your username">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="pass" class="form-control" id="password"
                                    placeholder="Enter your password">
                            </div>
                            <div class="form-group">
                                <button type="submit" name="loginAdmin" class="btn btn-primary btn-block">Login</button>
                            </div>
                        </form>
                    </div>
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
    <script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.8.5/dist/dotlottie-wc.js" type="module"></script>

    <?php include(ROOT_PATH . '/include/scripts.php'); ?>
</body>

</html>