<?php
include("path.php");
include(ROOT_PATH . '/app/controllers/users.php');

$info_gangguan = selectAll('informasi', ['tag' => 'Info Gangguan'], 'tanggal_buat');
$page_header = 'Informasi Gangguan';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Info Gangguan | Muara Tirta Kota Gorontalo</title>
    <meta name="description" content="Informasi terkini mengenai gangguan pelayanan air minum di wilayah Kota Gorontalo.">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Roboto:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Work+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <link href="assets/logo/Logo-PDAM-MT-min.ico" rel="icon">

    <?php include(ROOT_PATH . '/include/styles.php'); ?>

    <style>
    /* Info Gangguan Enhanced Styles - Prefix: ig- */
    .ig-enhanced-section {
        padding: 60px 0;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        min-height: 70vh;
    }

    .ig-header {
        margin-bottom: 40px;
    }

    .ig-title {
        font-size: 32px;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0;
        position: relative;
        padding-bottom: 12px;
    }

    .ig-title:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, #dc3545, #c82333);
        border-radius: 2px;
    }

    .ig-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 30px;
    }

    .ig-card {
        background: #ffffff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(220, 53, 69, 0.08);
        display: flex;
        flex-direction: column;
        height: 100%;
        text-decoration: none !important;
    }

    .ig-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 32px rgba(220, 53, 69, 0.15);
        border-color: #dc3545;
    }

    .ig-card-image {
        position: relative;
        width: 100%;
        height: 220px;
        overflow: hidden;
        background: #f1f1f1;
    }

    .ig-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .ig-card:hover .ig-card-image img {
        transform: scale(1.08);
    }

    .ig-status-badge {
        position: absolute;
        top: 16px;
        left: 16px;
        background: rgba(220, 53, 69, 0.9);
        color: #fff;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        backdrop-filter: blur(5px);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .ig-status-badge i {
        font-size: 12px;
        animation: pulse-red 2s infinite;
    }

    @keyframes pulse-red {
        0% { transform: scale(0.95); opacity: 0.7; }
        70% { transform: scale(1.1); opacity: 1; }
        100% { transform: scale(0.95); opacity: 0.7; }
    }

    .ig-card-content {
        padding: 24px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .ig-card-title {
        font-size: 18px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 12px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .ig-card-meta {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 16px;
        font-size: 13px;
        color: #6c757d;
    }

    .ig-meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .ig-meta-item i {
        color: #dc3545;
    }

    .ig-read-more {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #dc3545;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-top: auto;
    }

    .ig-card:hover .ig-read-more {
        gap: 12px;
    }

    @media (max-width: 768px) {
        .ig-grid {
            grid-template-columns: 1fr;
        }
        .ig-title {
            font-size: 26px;
        }
    }
    </style>
</head>

<body>

    <?php include(ROOT_PATH . '/include/header.php'); ?>

    <main id="main">

        <!-- ======= Breadcrumbs ======= -->
        <div class="breadcrumbs d-flex align-items-center" style="background-image: url('assets/image/RLC_1016-1-min.jpg');">
            <div class="container position-relative d-flex flex-column align-items-center" data-aos="fade">
                <h2>INFO GANGGUAN</h2>
                <ol>
                    <li><a href="<?php echo BASE_URL . '/' ?>">Beranda</a></li>
                    <li>Info Gangguan</li>
                </ol>
            </div>
        </div>

        <?php include(ROOT_PATH . '/include/webticker.php') ?>

        <section class="ig-enhanced-section">
            <div class="container" data-aos="fade-up">

                <div class="ig-header">
                    <h2 class="ig-title"><?php echo $page_header; ?></h2>
                </div>

                <div class="ig-grid">
                    <?php if (!empty($info_gangguan)) : ?>
                        <?php foreach ($info_gangguan as $i) : ?>
                        <a href="<?php echo BASE_URL . '/info-gangguan-detail/' . $i['slug'] ?>" class="ig-card">
                            <div class="ig-card-image">
                                <?php if (isset($i['image']) && !empty($i['image'])) : ?>
                                    <img src="<?php echo BASE_URL . '/assets/info/' . $i['image'] ?>" alt="<?php echo htmlspecialchars($i['judul']) ?>">
                                <?php else : ?>
                                    <img src="<?php echo BASE_URL . '/assets/image/no-images.png' ?>" alt="Info Gangguan">
                                <?php endif; ?>
                                <div class="ig-status-badge">
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                    <span>Gangguan</span>
                                </div>
                            </div>
                            <div class="ig-card-content">
                                <h3 class="ig-card-title"><?= $i['judul'] ?></h3>
                                <div class="ig-card-meta">
                                    <div class="ig-meta-item">
                                        <i class="bi bi-person"></i>
                                        <span><?= $i['author'] ?></span>
                                    </div>
                                    <div class="ig-meta-item">
                                        <i class="bi bi-calendar"></i>
                                        <span><?= date('d M Y', strtotime($i['tanggal_buat'])) ?></span>
                                    </div>
                                </div>
                                <div class="ig-read-more">
                                    Lihat Selengkapnya <i class="bi bi-arrow-right"></i>
                                </div>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="col-12 text-center py-5">
                            <div class="mb-3">
                                <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                            </div>
                            <h4>Tidak Ada Gangguan Layanan</h4>
                            <p class="text-muted">Saat ini seluruh sistem distribusi air berjalan normal.</p>
                        </div>
                    <?php endif; ?>
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