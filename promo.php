<?php
include("path.php");
include(ROOT_PATH . '/app/controllers/users.php');

$info_promo = selectAll('informasi', ['tag' => 'Promo'], 'tanggal_buat');
$page_header = 'Penawaran Spesial & Promo';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Promo | Muara Tirta Kota Gorontalo</title>
    <meta name="description" content="Kumpulan promo menarik dan penawaran spesial dari PERUMDA Air Minum Muara Tirta Kota Gorontalo.">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Roboto:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Work+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <link href="assets/logo/Logo-PDAM-MT-min.ico" rel="icon">

    <?php include(ROOT_PATH . '/include/styles.php'); ?>

    <style>
    /* Promo Enhanced Styles - Prefix: pr- */
    .pr-enhanced-section {
        padding: 80px 0;
        background: linear-gradient(135deg, #f0fbff 0%, #ffffff 100%);
        min-height: 70vh;
    }

    .pr-header {
        margin-bottom: 50px;
        text-align: center;
    }

    .pr-title {
        font-size: 36px;
        font-weight: 800;
        color: #1a1a1a;
        margin-bottom: 15px;
    }

    .pr-subtitle {
        color: #6c757d;
        font-size: 18px;
        max-width: 600px;
        margin: 0 auto;
    }

    .pr-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 30px;
    }

    .pr-card {
        background: #ffffff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(13, 110, 253, 0.05);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(13, 110, 253, 0.05);
        display: flex;
        flex-direction: column;
        height: 100%;
        text-decoration: none !important;
        position: relative;
    }

    .pr-card:hover {
        transform: translateY(-12px) scale(1.02);
        box-shadow: 0 20px 40px rgba(13, 110, 253, 0.12);
        border-color: #0d6efd;
    }

    .pr-card-image {
        position: relative;
        width: 100%;
        height: 250px;
        overflow: hidden;
    }

    .pr-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .pr-card:hover .pr-card-image img {
        transform: scale(1.1);
    }

    .pr-promo-tag {
        position: absolute;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, #ffc107, #ff9800);
        color: #000;
        padding: 5px 15px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .pr-card-content {
        padding: 30px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .pr-card-title {
        font-size: 20px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 15px;
        line-height: 1.4;
    }

    .pr-card-meta {
        margin-top: auto;
        padding-top: 20px;
        border-top: 1px dashed #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
        color: #6c757d;
    }

    .pr-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #0d6efd;
        color: #fff;
        padding: 8px 18px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .pr-card:hover .pr-btn {
        background: #0b5ed7;
        padding-right: 22px;
    }

    @media (max-width: 768px) {
        .pr-grid {
            grid-template-columns: 1fr;
        }
        .pr-title {
            font-size: 28px;
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
                <h2>DISKON & PROMO</h2>
                <ol>
                    <li><a href="<?php echo BASE_URL . '/' ?>">Beranda</a></li>
                    <li>Promo</li>
                </ol>
            </div>
        </div>

        <?php include(ROOT_PATH . '/include/webticker.php') ?>

        <section class="pr-enhanced-section">
            <div class="container" data-aos="fade-up">

                <div class="pr-header">
                    <h2 class="pr-title"><?php echo $page_header; ?></h2>
                    <p class="pr-subtitle">Cek penawaran terbaru untuk akses layanan air bersih yang lebih hemat dan menguntungkan.</p>
                </div>

                <div class="pr-grid">
                    <?php if (!empty($info_promo)) : ?>
                        <?php foreach ($info_promo as $i) : ?>
                        <a href="<?php echo BASE_URL . '/promo-detail/' . $i['slug'] ?>" class="pr-card">
                            <div class="pr-card-image">
                                <?php if (isset($i['image']) && !empty($i['image'])) : ?>
                                    <img src="<?php echo BASE_URL . '/assets/info/' . $i['image'] ?>" alt="<?php echo htmlspecialchars($i['judul']) ?>">
                                <?php else : ?>
                                    <img src="<?php echo BASE_URL . '/assets/image/info-gangguan.jpg' ?>" alt="Promo Muara Tirta">
                                <?php endif; ?>
                                <div class="pr-promo-tag">Promo Terbatas</div>
                            </div>
                            <div class="pr-card-content">
                                <h3 class="pr-card-title"><?= $i['judul'] ?></h3>
                                <div class="pr-card-meta">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-calendar3"></i>
                                        <span><?= date('d M Y', strtotime($i['tanggal_buat'])) ?></span>
                                    </div>
                                    <div class="pr-btn">
                                        Detail <i class="bi bi-arrow-right"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="col-12 text-center py-5">
                            <div class="mb-4">
                                <i class="bi bi-tag-fill text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                            </div>
                            <h4>Belum Ada Promo Aktif</h4>
                            <p class="text-muted">Nantikan info promo menarik selanjutnya di halaman ini.</p>
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