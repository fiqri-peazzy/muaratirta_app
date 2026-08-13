<?php
include("path.php");
include(ROOT_PATH . '/app/controllers/users.php');

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
if (!empty($slug)) {
    $promo = selectOne('informasi', ['slug' => $slug]);
    if (!$promo) {
        header('Location:' . BASE_URL . '/404.php');
        exit();
    }
} else {
    header('Location:' . BASE_URL . '/404.php');
    exit();
}

$sql = "SELECT * FROM informasi WHERE tag='Promo' AND slug != ? ORDER BY tanggal_buat DESC LIMIT 4";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $slug);
$stmt->execute();
$promo_terbaru = stmtFetchAllAssoc($stmt);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <base href="<?= BASE_URL ?>/">
    <title><?= $promo['judul'] ?> | Muara Tirta Kota Gorontalo</title>
    
    <meta name="description" content="<?= substr(strip_tags($promo['deskripsi']), 0, 160) ?>">
    <meta name="theme-color" content="#0d6efd" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="article">
    <meta property="og:url" content="<?= BASE_URL . '/promo-detail/' . $promo['slug'] ?>">
    <meta property="og:title" content="<?= $promo['judul'] ?>">
    <meta property="og:description" content="<?= substr(strip_tags($promo['deskripsi']), 0, 160) ?>">
    <meta property="og:image" content="<?= (isset($promo['image']) && !empty($promo['image'])) ? resolveImageUrl($promo['image'], 'informasi', ['assets/info']) : BASE_URL . '/assets/image/bg.jpg' ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?= BASE_URL . '/promo-detail/' . $promo['slug'] ?>">
    <meta property="twitter:title" content="<?= $promo['judul'] ?>">
    <meta property="twitter:description" content="<?= substr(strip_tags($promo['deskripsi']), 0, 160) ?>">
    <meta property="twitter:image" content="<?= (isset($promo['image']) && !empty($promo['image'])) ? resolveImageUrl($promo['image'], 'informasi', ['assets/info']) : BASE_URL . '/assets/image/bg.jpg' ?>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Roboto:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Work+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <link href="assets/logo/Logo-PDAM-MT-min.ico" rel="icon">

    <?php include(ROOT_PATH . '/include/styles.php'); ?>

    <style>
        .pd-content-section {
            padding: 60px 0;
            background: #ffffff;
        }
        .pd-article {
            background: #fff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.04);
            border: 1px solid #f0f0f0;
        }
        .pd-featured-img {
            width: 100%;
            height: auto;
            max-height: 500px;
            object-fit: cover;
            border-bottom: 1px solid #eee;
        }
        .pd-body {
            padding: 40px;
        }
        .pd-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: #1a1a1a;
            margin-bottom: 20px;
            line-height: 1.2;
        }
        .pd-meta {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f0f0f0;
            color: #6c757d;
            font-size: 0.95rem;
        }
        .pd-meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .pd-meta-item i {
            color: #0d6efd;
        }
        .pd-text-content {
            font-size: 1.125rem;
            line-height: 1.8;
            color: #444;
            margin-bottom: 40px;
            text-align: justify;
        }
        
        /* Share Buttons */
        .pd-share-box {
            background: #f8fbff;
            padding: 25px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }
        .pd-share-title {
            margin: 0;
            font-weight: 700;
            font-size: 1rem;
            color: #1a1a1a;
        }
        .pd-share-links {
            display: flex;
            gap: 12px;
        }
        .pd-share-btn {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.25rem;
            transition: all 0.3s ease;
            text-decoration: none !important;
        }
        .pd-share-btn:hover {
            transform: translateY(-4px);
            color: #fff;
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        }
        .btn-fb { background: #3b5998; }
        .btn-tw { background: #1da1f2; }
        .btn-wa { background: #25d366; }

        /* Sidebar Styles */
        .pd-sidebar-box {
            background: #fff;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            border: 1px solid #f0f0f0;
            position: sticky;
            top: 100px;
        }
        .pd-sidebar-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 25px;
            padding-bottom: 12px;
            border-bottom: 3px solid #0d6efd;
            display: inline-block;
        }
        .pd-recent-item {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f8f8f8;
            text-decoration: none !important;
        }
        .pd-recent-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }
        .pd-recent-thumb {
            width: 70px;
            height: 70px;
            border-radius: 12px;
            object-fit: cover;
            flex-shrink: 0;
        }
        .pd-recent-content h4 {
            font-size: 0.95rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 5px;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            transition: color 0.3s ease;
        }
        .pd-recent-item:hover h4 {
            color: #0d6efd;
        }
        .pd-recent-date {
            font-size: 0.8rem;
            color: #6c757d;
        }

        @media (max-width: 991px) {
            .pd-title { font-size: 2rem; }
            .pd-body { padding: 30px; }
            .pd-sidebar-box { position: static; margin-top: 40px; }
        }
    </style>
</head>

<body>

    <?php include(ROOT_PATH . '/include/header.php'); ?>

    <main id="main">

        <!-- ======= Breadcrumbs ======= -->
        <div class="breadcrumbs d-flex align-items-center" style="background-image: url('assets/image/RLC_1016-1-min.jpg');">
            <div class="container position-relative d-flex flex-column align-items-center" data-aos="fade">
                <h2>DETAIL PROMO</h2>
                <ol>
                    <li><a href="<?php echo BASE_URL . '/' ?>">Beranda</a></li>
                    <li><a href="<?php echo BASE_URL . '/promo' ?>">Promo</a></li>
                    <li>Detail</li>
                </ol>
            </div>
        </div>

        <?php include(ROOT_PATH . '/include/webticker.php') ?>

        <section class="pd-content-section">
            <div class="container" data-aos="fade-up">
                <div class="row g-5">
                    
                    <!-- Main Content -->
                    <div class="col-lg-8">
                        <article class="pd-article">
                            <div class="pd-image-wrap">
                                <?php if (isset($promo['image']) && !empty($promo['image'])) : ?>
                                    <img src="<?php echo resolveImageUrl($promo['image'], 'informasi', ['assets/info']) ?>" alt="<?= htmlspecialchars($promo['judul']) ?>" class="pd-featured-img">
                                <?php else : ?>
                                    <img src="<?php echo BASE_URL . '/assets/image/bg.jpg' ?>" alt="Muara Tirta" class="pd-featured-img">
                                <?php endif; ?>
                            </div>

                            <div class="pd-body">
                                <h1 class="pd-title"><?= $promo['judul'] ?></h1>
                                
                                <div class="pd-meta">
                                    <div class="pd-meta-item">
                                        <i class="bi bi-person-circle"></i>
                                        <span><?= $promo['author'] ?></span>
                                    </div>
                                    <div class="pd-meta-item">
                                        <i class="bi bi-calendar3"></i>
                                        <span><?= date('d F Y', strtotime($promo['tanggal_buat'])) ?></span>
                                    </div>
                                </div>

                                <div class="pd-text-content">
                                    <?= $promo['deskripsi'] ?>
                                </div>

                                <!-- Share Section -->
                                <div class="pd-share-box">
                                    <h5 class="pd-share-title">Bagikan penawaran ini:</h5>
                                    <div class="pd-share-links">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(BASE_URL . '/promo-detail/' . $promo['slug']) ?>" 
                                           class="pd-share-btn btn-fb" target="_blank" title="Share on Facebook">
                                            <i class="bi bi-facebook"></i>
                                        </a>
                                        <a href="https://twitter.com/intent/tweet?url=<?= urlencode(BASE_URL . '/promo-detail/' . $promo['slug']) ?>&text=<?= urlencode($promo['judul']) ?>" 
                                           class="pd-share-btn btn-tw" target="_blank" title="Share on X">
                                            <i class="bi bi-twitter-x"></i>
                                        </a>
                                        <a href="https://api.whatsapp.com/send?text=<?= urlencode($promo['judul'] . ' - ' . BASE_URL . '/promo-detail/' . $promo['slug']) ?>" 
                                           class="pd-share-btn btn-wa" target="_blank" title="Share on WhatsApp">
                                            <i class="bi bi-whatsapp"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-4">
                        <aside class="pd-sidebar-box">
                            <h3 class="pd-sidebar-title">Promo Lainnya</h3>
                            <div class="pd-sidebar-list">
                                <?php foreach ($promo_terbaru as $p) : ?>
                                    <a href="<?php echo BASE_URL . '/promo-detail/' . $p['slug'] ?>" class="pd-recent-item">
                                        <?php if (isset($p['image']) && !empty($p['image'])) : ?>
                                            <img src="<?php echo resolveImageUrl($p['image'], 'informasi', ['assets/info']) ?>" alt="" class="pd-recent-thumb">
                                        <?php else : ?>
                                            <img src="<?php echo BASE_URL . '/assets/image/bg.jpg' ?>" alt="" class="pd-recent-thumb">
                                        <?php endif; ?>
                                        <div class="pd-recent-content">
                                            <h4><?= $p['judul'] ?></h4>
                                            <span class="pd-recent-date"><?= date('d M Y', strtotime($p['tanggal_buat'])) ?></span>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                            
                            <?php if (empty($promo_terbaru)) : ?>
                                <p class="text-muted small">Belum ada promo lainnya.</p>
                            <?php endif; ?>

                            <div class="mt-4 pt-4 border-top">
                                <a href="<?= BASE_URL ?>/promo" class="btn btn-outline-primary w-100 rounded-pill">Lihat Semua Promo</a>
                            </div>
                        </aside>
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