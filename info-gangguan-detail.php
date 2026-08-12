<?php
include("path.php");
include(ROOT_PATH . '/app/controllers/users.php');
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
if (!empty($slug)) {
    $info_gangguan = selectOne('informasi', ['slug' => $slug]);
    if (!$info_gangguan) {
        header('Location:' . BASE_URL . '/404.php');
        exit();
    }
} else {
    header('Location:' . BASE_URL . '/404.php');
    exit();
}
$sql = "SELECT * FROM informasi WHERE tag='Info Gangguan' AND id != ? ORDER BY tanggal_buat DESC LIMIT 5";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $info_gangguan['id']);
$stmt->execute();
$info_gangguan_terbaru = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <base href="<?= BASE_URL ?>/">
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="theme-color" content="#DC3545" />
    <meta content="<?= substr(strip_tags($info_gangguan['deskripsi']), 0, 160) ?>" name="description">
    <meta content="Info Gangguan, Gangguan Air, Muaratirta, Kota Gorontalo, PDAM" name="keywords">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?= htmlspecialchars($info_gangguan['judul']) ?>">
    <meta property="og:type" content="article">
    <meta property="og:description" content="<?= substr(strip_tags($info_gangguan['deskripsi']), 0, 150) ?>">
    <meta property="og:image"
        content="<?= (isset($info_gangguan['image']) && !empty($info_gangguan['image'])) ? resolveImageUrl($info_gangguan['image'], 'informasi', ['assets/info']) : BASE_URL . '/assets/image/info-gangguan.jpg' ?>">
    <meta property="og:image:width" content="1260" />
    <meta property="og:image:height" content="469" />
    <meta property="og:site_name" content="PERUMDA MUARA TIRTA KOTA GORONTALO">
    <meta property="og:url" content="<?= BASE_URL . '/info-gangguan-detail/' . $info_gangguan['slug'] ?>">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($info_gangguan['judul']) ?>">
    <meta name="twitter:description" content="<?= substr(strip_tags($info_gangguan['deskripsi']), 0, 150) ?>">
    <meta name="twitter:image"
        content="<?= (isset($info_gangguan['image']) && !empty($info_gangguan['image'])) ? resolveImageUrl($info_gangguan['image'], 'informasi', ['assets/info']) : BASE_URL . '/assets/image/info-gangguan.jpg' ?>">
    <meta name="twitter:url" content="<?= BASE_URL . '/info-gangguan-detail/' . $info_gangguan['slug'] ?>">

    <title>Info Gangguan - <?= htmlspecialchars($info_gangguan['judul']) ?> | Muara Tirta Kota Gorontalo</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Roboto:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Work+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">
    <link href="assets/logo/Logo-PDAM-MT-min.ico" rel="icon">
    <?php include(ROOT_PATH . '/include/styles.php'); ?>

    <style>
    /* ========================================
       PDAM MUARA TIRTA - DETAIL INFO GANGGUAN
       Modern Disruption Info Detail Page
       ======================================== */
    :root {
        --gangguan-primary: #3bb7e9ff;
        --gangguan-primary-dark: #3e87caff;
        --gangguan-warning: #FFC107;
        --gangguan-success: #198754;
        --gangguan-info: #0DCAF0;
        --gangguan-dark: #1a2332;
        --gangguan-light: #F8F9FA;
        --gangguan-white: #FFFFFF;
        --gangguan-text: #2C3E50;
        --gangguan-muted: #6C757D;
        --gangguan-border: #E0E0E0;
        --gangguan-shadow-sm: 0 2px 12px rgba(220, 53, 69, 0.08);
        --gangguan-shadow-md: 0 4px 20px rgba(220, 53, 69, 0.12);
        --gangguan-shadow-lg: 0 8px 32px rgba(220, 53, 69, 0.16);
        --gangguan-radius: 16px;
        --gangguan-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }



    /* ========================================
       ALERT BANNER
       ======================================== */
    .gangguan-alert-banner {
        color: white;
        padding: 16px 0;
        /* box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3); */
        position: relative;
        overflow: hidden;
    }

    .gangguan-alert-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        animation: gangguan-shine 3s infinite;
    }

    @keyframes gangguan-shine {
        to {
            left: 100%;
        }
    }

    .gangguan-alert-content {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        font-weight: 700;
        font-size: 1rem;
        position: relative;
        z-index: 1;
    }

    .gangguan-alert-icon {
        width: 32px;
        height: 32px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: gangguan-pulse 2s infinite;
    }

    @keyframes gangguan-pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }
    }

    .gangguan-alert-icon i {
        font-size: 1.25rem;
    }

    /* ========================================
       MAIN ARTICLE SECTION
       ======================================== */
    .gangguan-main-article {
        background: white;
        border-radius: var(--gangguan-radius);
        overflow: hidden;
        box-shadow: var(--gangguan-shadow-md);
        margin-bottom: 32px;
        border: 3px solid var(--gangguan-primary);
    }

    /* Status Badge */
    .gangguan-status-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        padding: 12px 24px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.875rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        z-index: 10;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .gangguan-status-badge.active {
        background: var(--gangguan-primary);
        color: white;
    }

    .gangguan-status-badge.resolved {
        background: var(--gangguan-success);
        color: white;
    }

    .gangguan-status-badge i {
        font-size: 1rem;
        animation: gangguan-blink 1.5s infinite;
    }

    @keyframes gangguan-blink {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.4;
        }
    }

    /* Article Image */
    .gangguan-article-image {
        position: relative;
        width: 100%;
        height: 450px;
        overflow: hidden;
        background: linear-gradient(135deg, #FFE6E6 0%, #FFC9C9 100%);
    }

    .gangguan-article-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--gangguan-transition);
    }

    .gangguan-article-image:hover img {
        transform: scale(1.05);
    }

    .gangguan-image-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 200px;
        /* background: linear-gradient(to top, rgba(220, 53, 69, 0.9), transparent); */
    }

    /* Article Content */
    .gangguan-article-content {
        padding: 40px;
    }

    .gangguan-article-title {
        font-size: 2rem;
        font-weight: 800;
        color: var(--gangguan-text);
        line-height: 1.3;
        margin-bottom: 24px;
        letter-spacing: -0.5px;
    }

    /* Meta Information */
    .gangguan-meta-info {
        display: flex;
        flex-wrap: wrap;
        gap: 24px;
        padding: 20px 0;
        margin-bottom: 24px;
        border-top: 2px solid var(--gangguan-light);
        border-bottom: 2px solid var(--gangguan-light);
    }

    .gangguan-meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--gangguan-muted);
        font-size: 0.9375rem;
        font-weight: 500;
    }

    .gangguan-meta-item i {
        color: var(--gangguan-primary);
        font-size: 1.125rem;
    }

    .gangguan-meta-item a {
        color: var(--gangguan-muted);
        text-decoration: none;
        transition: var(--gangguan-transition);
    }

    .gangguan-meta-item a:hover {
        color: var(--gangguan-primary);
    }

    /* Important Notice Box */
    .gangguan-notice-box {
        background: linear-gradient(135deg, #FFF3CD 0%, #FFE69C 100%);
        border-left: 5px solid var(--gangguan-warning);
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 32px;
        box-shadow: var(--gangguan-shadow-sm);
    }

    .gangguan-notice-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
    }

    .gangguan-notice-icon {
        width: 40px;
        height: 40px;
        background: var(--gangguan-warning);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
    }

    .gangguan-notice-title {
        font-size: 1.125rem;
        font-weight: 800;
        color: #856404;
        margin: 0;
    }

    .gangguan-notice-text {
        color: #856404;
        line-height: 1.6;
        font-size: 0.9375rem;
    }

    /* Article Body */
    .gangguan-article-body {
        font-size: 1.125rem;
        line-height: 1.8;
        color: var(--gangguan-text);
        text-align: justify;
    }

    .gangguan-article-body p {
        margin-bottom: 20px;
    }

    .gangguan-article-body img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        margin: 24px 0;
    }

    /* Contact Emergency Box */
    .gangguan-emergency-box {
        background: linear-gradient(135deg, var(--gangguan-primary) 0%, var(--gangguan-primary-dark) 100%);
        border-radius: 12px;
        padding: 28px;
        margin-top: 32px;
        color: white;
        box-shadow: var(--gangguan-shadow-md);
    }

    .gangguan-emergency-title {
        font-size: 1.25rem;
        font-weight: 800;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .gangguan-emergency-title i {
        font-size: 1.5rem;
    }

    .gangguan-emergency-content {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        align-items: center;
    }

    .gangguan-emergency-text {
        flex: 1;
        font-size: 1rem;
        line-height: 1.6;
        opacity: 0.95;
    }

    .gangguan-btn-emergency {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 14px 28px;
        background: white;
        color: var(--gangguan-primary);
        border-radius: 50px;
        text-decoration: none;
        font-weight: 700;
        font-size: 1rem;
        transition: var(--gangguan-transition);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        white-space: nowrap;
    }

    .gangguan-btn-emergency:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        color: var(--gangguan-primary);
    }

    .gangguan-btn-emergency i {
        font-size: 1.25rem;
    }

    /* Social Share Section */
    .gangguan-share-section {
        margin-top: 40px;
        padding-top: 32px;
        border-top: 2px solid var(--gangguan-light);
    }

    .gangguan-share-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--gangguan-text);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .gangguan-share-title i {
        color: var(--gangguan-primary);
    }

    .gangguan-share-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .gangguan-share-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        border-radius: 50px;
        font-size: 0.9375rem;
        font-weight: 600;
        text-decoration: none;
        transition: var(--gangguan-transition);
        box-shadow: var(--gangguan-shadow-sm);
    }

    .gangguan-share-btn i {
        font-size: 1.25rem;
    }

    .gangguan-share-btn-facebook {
        background: #1877F2;
        color: white;
    }

    .gangguan-share-btn-facebook:hover {
        background: #145DBF;
        transform: translateY(-2px);
        box-shadow: var(--gangguan-shadow-md);
        color: white;
    }

    .gangguan-share-btn-twitter {
        background: #000000;
        color: white;
    }

    .gangguan-share-btn-twitter:hover {
        background: #1a1a1a;
        transform: translateY(-2px);
        box-shadow: var(--gangguan-shadow-md);
        color: white;
    }

    .gangguan-share-btn-whatsapp {
        background: #25D366;
        color: white;
    }

    .gangguan-share-btn-whatsapp:hover {
        background: #20BA5A;
        transform: translateY(-2px);
        box-shadow: var(--gangguan-shadow-md);
        color: white;
    }

    /* ========================================
       SIDEBAR SECTION
       ======================================== */
    .gangguan-sidebar {
        position: sticky;
        top: 100px;
    }

    /* Recent Info Box */
    .gangguan-recent-box {
        background: white;
        border-radius: var(--gangguan-radius);
        padding: 28px;
        box-shadow: var(--gangguan-shadow-md);
        border: 2px solid var(--gangguan-light);
    }

    .gangguan-sidebar-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--gangguan-text);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
        padding-bottom: 12px;
        border-bottom: 3px solid var(--gangguan-primary);
    }

    .gangguan-sidebar-title i {
        color: var(--gangguan-primary);
    }

    .gangguan-recent-item {
        padding: 16px 0;
        border-bottom: 1px solid var(--gangguan-border);
        transition: var(--gangguan-transition);
    }

    .gangguan-recent-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .gangguan-recent-item:hover {
        transform: translateX(4px);
    }

    .gangguan-recent-item-title {
        font-size: 1rem;
        font-weight: 600;
        line-height: 1.5;
        margin-bottom: 8px;
    }

    .gangguan-recent-item-title a {
        color: var(--gangguan-text);
        text-decoration: none;
        transition: var(--gangguan-transition);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .gangguan-recent-item-title a:hover {
        color: var(--gangguan-primary);
    }

    .gangguan-recent-item-date {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.875rem;
        color: var(--gangguan-muted);
    }

    .gangguan-recent-item-date i {
        font-size: 0.875rem;
        color: var(--gangguan-primary);
    }

    /* Help Box */
    .gangguan-help-box {
        background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%);
        border-radius: var(--gangguan-radius);
        padding: 28px;
        margin-top: 24px;
        text-align: center;
        box-shadow: var(--gangguan-shadow-sm);
    }

    .gangguan-help-icon {
        width: 60px;
        height: 60px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        color: var(--gangguan-primary);
        font-size: 1.75rem;
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.2);
    }

    .gangguan-help-title {
        font-size: 1.125rem;
        font-weight: 800;
        color: var(--gangguan-text);
        margin-bottom: 12px;
    }

    .gangguan-help-text {
        font-size: 0.9375rem;
        color: var(--gangguan-muted);
        line-height: 1.6;
        margin-bottom: 20px;
    }

    .gangguan-btn-help {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: var(--gangguan-primary);
        color: white;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.9375rem;
        transition: var(--gangguan-transition);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    }

    .gangguan-btn-help:hover {
        background: var(--gangguan-primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
        color: white;
    }

    .gangguan-btn-help i {
        font-size: 1.125rem;
    }

    /* ========================================
       RESPONSIVE DESIGN
       ======================================== */
    @media (max-width: 991px) {
        .gangguan-sidebar {
            position: relative;
            top: 0;
            margin-top: 32px;
        }

        .gangguan-article-image {
            height: 400px;
        }

        .gangguan-article-content {
            padding: 32px 24px;
        }

        .gangguan-article-title {
            font-size: 1.75rem;
        }

        .gangguan-alert-banner {
            padding: 12px 0;
        }
    }

    @media (max-width: 768px) {
        .gangguan-article-image {
            height: 300px;
        }

        .gangguan-status-badge {
            top: 16px;
            right: 16px;
            padding: 10px 20px;
            font-size: 0.8125rem;
        }

        .gangguan-article-content {
            padding: 24px 20px;
        }

        .gangguan-article-title {
            font-size: 1.5rem;
        }

        .gangguan-meta-info {
            gap: 16px;
        }

        .gangguan-article-body {
            font-size: 1rem;
        }

        .gangguan-share-buttons {
            flex-direction: column;
        }

        .gangguan-share-btn {
            width: 100%;
            justify-content: center;
        }

        .gangguan-emergency-content {
            flex-direction: column;
            text-align: center;
        }

        .gangguan-btn-emergency {
            width: 100%;
            justify-content: center;
        }

        .gangguan-alert-content {
            font-size: 0.875rem;
            flex-wrap: wrap;
        }
    }

    @media (max-width: 576px) {
        .gangguan-article-image {
            height: 250px;
        }

        .gangguan-article-title {
            font-size: 1.375rem;
        }

        .gangguan-recent-box,
        .gangguan-notice-box,
        .gangguan-emergency-box,
        .gangguan-help-box {
            padding: 20px;
        }

        .gangguan-sidebar-title {
            font-size: 1.125rem;
        }
    }

    /* ========================================
       PRINT STYLES
       ======================================== */
    @media print {

        .gangguan-share-section,
        .gangguan-sidebar,
        .gangguan-alert-banner,
        .gangguan-emergency-box,
        .breadcrumbs,
        header,
        footer {
            display: none !important;
        }

        .gangguan-main-article {
            box-shadow: none;
            border: 2px solid #ddd;
        }

        .gangguan-article-image {
            height: auto;
            max-height: 400px;
        }

        .gangguan-article-body {
            font-size: 12pt;
            line-height: 1.6;
        }
    }
    </style>
</head>

<body>
    <?php include(ROOT_PATH . '/include/header.php'); ?>

    <!-- Alert Banner -->


    <main id="main">
        <!-- Breadcrumbs -->
        <div class="breadcrumbs d-flex align-items-center"
            style="background-image: url('assets/image/RLC_1016-1-min.jpg');">
            <div class="container position-relative d-flex flex-column align-items-center" data-aos="fade">
                <h2>Info Gangguan Detail</h2>
                <ol>
                    <li><a href="<?= BASE_URL . '/' ?>">Beranda</a></li>
                    <li><a href="<?= BASE_URL . '/info-gangguan' ?>">Info Gangguan</a></li>
                    <li><?= htmlspecialchars($info_gangguan['judul']) ?></li>
                </ol>
            </div>
        </div>

        <?php include(ROOT_PATH . '/include/webticker.php') ?>

        <!-- Main Content -->
        <section id="blog" class="blog section-bg">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row g-4">
                    <!-- Main Article -->
                    <div class="col-lg-8">
                        <article class="gangguan-main-article">
                            <!-- Article Image -->
                            <div class="gangguan-article-image">
                                <!-- Status Badge -->
                                <div class="gangguan-status-badge active">
                                    <i class="bi bi-exclamation-circle-fill"></i>
                                    <span>Gangguan Aktif</span>
                                </div>

                                <?php if (isset($info_gangguan['image']) && !empty($info_gangguan['image'])): ?>
                                <a href="<?= resolveImageUrl($info_gangguan['image'], 'informasi', ['assets/info']) ?>"
                                    data-lightbox="gangguan-image">
                                    <img src="<?= resolveImageUrl($info_gangguan['image'], 'informasi', ['assets/info']) ?>"
                                        alt="<?= htmlspecialchars($info_gangguan['judul']) ?>" loading="lazy">
                                </a>
                                <?php else: ?>
                                <a href="<?= BASE_URL . '/assets/image/info-gangguan.jpg' ?>"
                                    data-lightbox="gangguan-image">
                                    <img src="<?= BASE_URL . '/assets/image/info-gangguan.jpg' ?>" alt="Info Gangguan"
                                        loading="lazy">
                                </a>
                                <?php endif; ?>
                                <div class="gangguan-image-overlay"></div>
                            </div>

                            <!-- Article Content -->
                            <div class="gangguan-article-content">
                                <h1 class="gangguan-article-title"><?= htmlspecialchars($info_gangguan['judul']) ?></h1>

                                <!-- Meta Information -->
                                <div class="gangguan-meta-info">
                                    <div class="gangguan-meta-item">
                                        <i class="bi bi-person-circle"></i>
                                        <span>Oleh
                                            <strong><?= htmlspecialchars($info_gangguan['author']) ?></strong></span>
                                    </div>
                                    <div class="gangguan-meta-item">
                                        <i class="bi bi-calendar-event"></i>
                                        <time
                                            datetime="<?= date('Y-m-d', strtotime($info_gangguan['tanggal_buat'])) ?>">
                                            <?= date('d F Y', strtotime($info_gangguan['tanggal_buat'])) ?>
                                        </time>
                                    </div>
                                    <div class="gangguan-meta-item">
                                        <i class="bi bi-clock-history"></i>
                                        <span><?= date('H:i', strtotime($info_gangguan['tanggal_buat'])) ?> WIB</span>
                                    </div>
                                </div>

                                <!-- Important Notice -->
                                <div class="gangguan-notice-box">
                                    <div class="gangguan-notice-header">
                                        <div class="gangguan-notice-icon">
                                            <i class="bi bi-info-circle-fill"></i>
                                        </div>
                                        <h5 class="gangguan-notice-title">Perhatian Penting</h5>
                                    </div>
                                    <p class="gangguan-notice-text">
                                        Kami mohon maaf atas ketidaknyamanan yang terjadi. Tim kami sedang bekerja keras
                                        untuk mengatasi gangguan ini secepat mungkin. Untuk informasi terkini atau
                                        pertanyaan, silakan hubungi layanan pelanggan kami.
                                    </p>
                                </div>

                                <!-- Article Body -->
                                <div class="gangguan-article-body">
                                    <?= $info_gangguan['deskripsi'] ?>
                                </div>

                                <!-- Emergency Contact -->
                                <div class="gangguan-emergency-box">
                                    <h5 class="gangguan-emergency-title">
                                        <i class="bi bi-telephone-fill"></i>
                                        Butuh Bantuan Segera?
                                    </h5>
                                    <div class="gangguan-emergency-content">
                                        <div class="gangguan-emergency-text">
                                            Hubungi call center kami untuk informasi lebih lanjut atau laporkan gangguan
                                            di wilayah Anda.
                                        </div>
                                        <a href="tel:+6282290275" class="gangguan-btn-emergency">
                                            <i class="bi bi-telephone-forward-fill"></i>
                                            Call Center
                                        </a>
                                        <a href="https://wa.me/6281244697154" class="gangguan-btn-emergency"
                                            target="_blank" rel="noopener noreferrer">
                                            <i class="bi bi-whatsapp"></i>
                                            WhatsApp
                                        </a>
                                    </div>
                                </div>

                                <!-- Social Share -->
                                <div class="gangguan-share-section">
                                    <h5 class="gangguan-share-title">
                                        <i class="bi bi-share-fill"></i>
                                        Bagikan Informasi Ini
                                    </h5>
                                    <div class="gangguan-share-buttons">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(BASE_URL . '/info-gangguan-detail/' . $info_gangguan['slug']) ?>"
                                            class="gangguan-share-btn gangguan-share-btn-facebook" target="_blank"
                                            rel="noopener noreferrer">
                                            <i class="bi bi-facebook"></i>
                                            <span>Facebook</span>
                                        </a>
                                        <a href="https://twitter.com/intent/tweet?url=<?= urlencode(BASE_URL . '/info-gangguan-detail/' . $info_gangguan['slug']) ?>&text=<?= urlencode($info_gangguan['judul']) ?>"
                                            class="gangguan-share-btn gangguan-share-btn-twitter" target="_blank"
                                            rel="noopener noreferrer">
                                            <i class="bi bi-twitter-x"></i>
                                            <span>Twitter</span>
                                        </a>
                                        <a href="https://api.whatsapp.com/send?text=<?= urlencode($info_gangguan['judul'] . ' - ' . BASE_URL . '/info-gangguan-detail/' . $info_gangguan['slug']) ?>"
                                            class="gangguan-share-btn gangguan-share-btn-whatsapp" target="_blank"
                                            rel="noopener noreferrer">
                                            <i class="bi bi-whatsapp"></i>
                                            <span>WhatsApp</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-4">
                        <aside class="gangguan-sidebar">
                            <!-- Recent Info -->
                            <div class="gangguan-recent-box" data-aos="fade-up">
                                <h3 class="gangguan-sidebar-title">
                                    <i class="bi bi-exclamation-triangle"></i>
                                    Info Gangguan Lainnya
                                </h3>

                                <?php if (!empty($info_gangguan_terbaru)): ?>
                                <?php foreach ($info_gangguan_terbaru as $item): ?>
                                <div class="gangguan-recent-item">
                                    <h4 class="gangguan-recent-item-title">
                                        <a href="<?= BASE_URL . '/info-gangguan-detail/' . $item['slug'] ?>">
                                            <?= htmlspecialchars($item['judul']) ?>
                                        </a>
                                    </h4>
                                    <div class="gangguan-recent-item-date">
                                        <i class="bi bi-calendar3"></i>
                                        <time datetime="<?= date('Y-m-d', strtotime($item['tanggal_buat'])) ?>">
                                            <?= date('d M Y', strtotime($item['tanggal_buat'])) ?>
                                        </time>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: var(--gangguan-muted); text-align: center; padding: 20px;">
                                    Tidak ada info gangguan lainnya
                                </p>
                                <?php endif; ?>
                            </div>

                            <!-- Help Box -->
                            <div class="gangguan-help-box" data-aos="fade-up" data-aos-delay="100">
                                <div class="gangguan-help-icon">
                                    <i class="bi bi-headset"></i>
                                </div>
                                <h4 class="gangguan-help-title">Butuh Bantuan?</h4>
                                <p class="gangguan-help-text">
                                    Tim customer service kami siap membantu Anda 24/7. Jangan ragu untuk menghubungi
                                    kami.
                                </p>
                                <a href="https://wa.me/6281244697154" class="gangguan-btn-help" target="_blank"
                                    rel="noopener noreferrer">
                                    <i class="bi bi-chat-dots-fill"></i>
                                    Hubungi Kami
                                </a>
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

    <script>
    // Smooth scroll untuk anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Auto-detect status based on date (optional enhancement)
    // You can modify this to check actual status from database
    const publishDate = new Date('<?= $info_gangguan['tanggal_buat'] ?>');
    const currentDate = new Date();
    const daysDiff = Math.floor((currentDate - publishDate) / (1000 * 60 * 60 * 24));

    // If gangguan is older than 7 days, change status to resolved (optional)
    if (daysDiff > 7) {
        const statusBadge = document.querySelector('.gangguan-status-badge');
        if (statusBadge) {
            statusBadge.classList.remove('active');
            statusBadge.classList.add('resolved');
            statusBadge.innerHTML = '<i class="bi bi-check-circle-fill"></i><span>Telah Teratasi</span>';
        }
    }
    </script>
</body>

</html>