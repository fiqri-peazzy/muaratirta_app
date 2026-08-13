<?php
include("path.php");
include(ROOT_PATH . '/app/controllers/users.php');
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
if (!empty($slug)) {
    $berita = selectOne('informasi', ['slug' => $slug]);
    if (!$berita) {
        header('Location:' . BASE_URL . '/404.php');
        exit();
    }
} else {
    header('Location:' . BASE_URL . '/404.php');
    exit();
}
$sql = "SELECT * FROM informasi WHERE tag='Berita' AND id != ? ORDER BY tanggal_buat DESC LIMIT 5";
$stmt = $conn->prepare($sql);
prepStmtForFetch($stmt);
$stmt->bind_param('i', $berita['id']);
$stmt->execute();
$berita_terbaru = stmtFetchAllAssoc($stmt);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <base href="<?= BASE_URL ?>/">
    <meta name="theme-color" content="#0D6EFD" />
    <meta content="<?= substr(strip_tags($berita['deskripsi']), 0, 160) ?>" name="description">
    <meta content="Berita Terkini, Muaratirta, Kota Gorontalo, PDAM" name="keywords">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?= htmlspecialchars($berita['judul']) ?>">
    <meta property="og:type" content="article">
    <meta property="og:description" content="<?= substr(strip_tags($berita['deskripsi']), 0, 150) ?>">
    <meta property="og:image"
        content="<?= (isset($berita['image']) && !empty($berita['image'])) ? resolveImageUrl($berita['image'], 'informasi', ['assets/info']) : '' ?>">
    <meta property="og:image:width" content="1260" />
    <meta property="og:image:height" content="469" />
    <meta property="og:site_name" content="PERUMDA MUARA TIRTA KOTA GORONTALO">
    <meta property="og:url" content="<?= BASE_URL . '/detail-berita/' . $berita['slug'] ?>">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($berita['judul']) ?>">
    <meta name="twitter:description" content="<?= substr(strip_tags($berita['deskripsi']), 0, 150) ?>">
    <meta name="twitter:image"
        content="<?= (isset($berita['image']) && !empty($berita['image'])) ? resolveImageUrl($berita['image'], 'informasi', ['assets/info']) : '' ?>">
    <meta name="twitter:url" content="<?= BASE_URL . '/detail-berita/' . $berita['slug'] ?>">

    <title><?= htmlspecialchars($berita['judul']) ?> | Muara Tirta Kota Gorontalo</title>

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
       PDAM MUARA TIRTA - DETAIL BERITA MODERN
       ======================================== */
    :root {
        --berita-primary: #0D6EFD;
        --berita-primary-dark: #0B5ED7;
        --berita-secondary: #0DCAF0;
        --berita-success: #198754;
        --berita-dark: #1a2332;
        --berita-light: #F8F9FA;
        --berita-white: #FFFFFF;
        --berita-text: #2C3E50;
        --berita-muted: #6C757D;
        --berita-border: #E0E0E0;
        --berita-shadow-sm: 0 2px 12px rgba(13, 110, 253, 0.08);
        --berita-shadow-md: 0 4px 20px rgba(13, 110, 253, 0.12);
        --berita-shadow-lg: 0 8px 32px rgba(13, 110, 253, 0.16);
        --berita-radius: 16px;
        --berita-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        font-family: 'Inter', sans-serif;
    }

    /* ========================================
       MAIN ARTICLE SECTION
       ======================================== */
    .berita-main-article {
        background: white;
        border-radius: var(--berita-radius);
        overflow: hidden;
        box-shadow: var(--berita-shadow-md);
        margin-bottom: 32px;
    }

    /* Article Image */
    .berita-article-image {
        position: relative;
        width: 100%;
        height: 500px;
        overflow: hidden;
        background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%);
    }

    .berita-article-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--berita-transition);
    }

    .berita-article-image:hover img {
        transform: scale(1.05);
    }

    .berita-image-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 200px;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
    }

    /* Article Content */
    .berita-article-content {
        padding: 40px;
    }

    .berita-article-title {
        font-size: 2rem;
        font-weight: 800;
        color: var(--berita-text);
        line-height: 1.3;
        margin-bottom: 24px;
        letter-spacing: -0.5px;
    }

    /* Meta Information */
    .berita-meta-info {
        display: flex;
        flex-wrap: wrap;
        gap: 24px;
        padding: 20px 0;
        margin-bottom: 24px;
        border-top: 2px solid var(--berita-light);
        border-bottom: 2px solid var(--berita-light);
    }

    .berita-meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--berita-muted);
        font-size: 0.9375rem;
        font-weight: 500;
    }

    .berita-meta-item i {
        color: var(--berita-primary);
        font-size: 1.125rem;
    }

    .berita-meta-item a {
        color: var(--berita-muted);
        text-decoration: none;
        transition: var(--berita-transition);
    }

    .berita-meta-item a:hover {
        color: var(--berita-primary);
    }

    /* Article Body */
    .berita-article-body {
        font-size: 1.125rem;
        line-height: 1.8;
        color: var(--berita-text);
        text-align: justify;
    }

    .berita-article-body p {
        margin-bottom: 20px;
    }

    .berita-article-body img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        margin: 24px 0;
    }

    /* Social Share Section */
    .berita-share-section {
        margin-top: 40px;
        padding-top: 32px;
        border-top: 2px solid var(--berita-light);
    }

    .berita-share-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--berita-text);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .berita-share-title i {
        color: var(--berita-primary);
    }

    .berita-share-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .berita-share-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        border-radius: 50px;
        font-size: 0.9375rem;
        font-weight: 600;
        text-decoration: none;
        transition: var(--berita-transition);
        box-shadow: var(--berita-shadow-sm);
    }

    .berita-share-btn i {
        font-size: 1.25rem;
    }

    .berita-share-btn-facebook {
        background: #1877F2;
        color: white;
    }

    .berita-share-btn-facebook:hover {
        background: #145DBF;
        transform: translateY(-2px);
        box-shadow: var(--berita-shadow-md);
        color: white;
    }

    .berita-share-btn-twitter {
        background: #000000;
        color: white;
    }

    .berita-share-btn-twitter:hover {
        background: #1a1a1a;
        transform: translateY(-2px);
        box-shadow: var(--berita-shadow-md);
        color: white;
    }

    .berita-share-btn-whatsapp {
        background: #25D366;
        color: white;
    }

    .berita-share-btn-whatsapp:hover {
        background: #20BA5A;
        transform: translateY(-2px);
        box-shadow: var(--berita-shadow-md);
        color: white;
    }

    .berita-share-btn-print {
        background: var(--berita-muted);
        color: white;
    }

    .berita-share-btn-print:hover {
        background: var(--berita-dark);
        transform: translateY(-2px);
        box-shadow: var(--berita-shadow-md);
        color: white;
    }

    /* ========================================
       SIDEBAR SECTION
       ======================================== */
    .berita-sidebar {
        position: sticky;
        top: 100px;
    }

    /* Search Box */
    .berita-search-box {
        background: white;
        border-radius: var(--berita-radius);
        padding: 28px;
        margin-bottom: 24px;
        box-shadow: var(--berita-shadow-md);
    }

    .berita-sidebar-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--berita-text);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .berita-sidebar-title i {
        color: var(--berita-primary);
    }

    .berita-search-form {
        position: relative;
        display: flex;
        gap: 8px;
    }

    .berita-search-input {
        flex: 1;
        padding: 14px 20px;
        border: 2px solid var(--berita-border);
        border-radius: 50px;
        font-size: 1rem;
        color: var(--berita-text);
        transition: var(--berita-transition);
        outline: none;
    }

    .berita-search-input:focus {
        border-color: var(--berita-primary);
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
    }

    .berita-search-btn {
        padding: 14px 28px;
        background: linear-gradient(135deg, var(--berita-primary) 0%, var(--berita-secondary) 100%);
        color: white;
        border: none;
        border-radius: 50px;
        font-size: 1rem;
        cursor: pointer;
        transition: var(--berita-transition);
        box-shadow: var(--berita-shadow-sm);
    }

    .berita-search-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--berita-shadow-md);
    }

    .berita-search-btn i {
        font-size: 1.125rem;
    }

    /* Recent Posts */
    .berita-recent-posts {
        background: white;
        border-radius: var(--berita-radius);
        padding: 28px;
        box-shadow: var(--berita-shadow-md);
    }

    .berita-recent-item {
        padding: 16px 0;
        border-bottom: 1px solid var(--berita-border);
        transition: var(--berita-transition);
    }

    .berita-recent-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .berita-recent-item:hover {
        transform: translateX(4px);
    }

    .berita-recent-item-title {
        font-size: 1rem;
        font-weight: 600;
        line-height: 1.5;
        margin-bottom: 8px;
    }

    .berita-recent-item-title a {
        color: var(--berita-text);
        text-decoration: none;
        transition: var(--berita-transition);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .berita-recent-item-title a:hover {
        color: var(--berita-primary);
    }

    .berita-recent-item-date {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.875rem;
        color: var(--berita-muted);
    }

    .berita-recent-item-date i {
        font-size: 0.875rem;
        color: var(--berita-primary);
    }

    /* ========================================
       RESPONSIVE DESIGN
       ======================================== */
    @media (max-width: 991px) {
        .berita-sidebar {
            position: relative;
            top: 0;
            margin-top: 32px;
        }

        .berita-article-image {
            height: 400px;
        }

        .berita-article-content {
            padding: 32px 24px;
        }

        .berita-article-title {
            font-size: 1.75rem;
        }
    }

    @media (max-width: 768px) {
        .berita-article-image {
            height: 300px;
        }

        .berita-article-content {
            padding: 24px 20px;
        }

        .berita-article-title {
            font-size: 1.5rem;
        }

        .berita-meta-info {
            gap: 16px;
        }

        .berita-article-body {
            font-size: 1rem;
        }

        .berita-share-buttons {
            flex-direction: column;
        }

        .berita-share-btn {
            width: 100%;
            justify-content: center;
        }

        .berita-search-form {
            flex-direction: column;
        }

        .berita-search-btn {
            width: 100%;
        }
    }

    @media (max-width: 576px) {
        .berita-article-image {
            height: 250px;
        }

        .berita-article-title {
            font-size: 1.375rem;
        }

        .berita-search-box,
        .berita-recent-posts {
            padding: 20px;
        }

        .berita-sidebar-title {
            font-size: 1.125rem;
        }
    }

    /* ========================================
       PRINT STYLES
       ======================================== */
    @media print {

        .berita-share-section,
        .berita-sidebar,
        .breadcrumbs,
        header,
        footer {
            display: none !important;
        }

        .berita-main-article {
            box-shadow: none;
            border: 1px solid #ddd;
        }

        .berita-article-image {
            height: auto;
            max-height: 400px;
        }

        .berita-article-body {
            font-size: 12pt;
            line-height: 1.6;
        }
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
                <h2>Detail Berita</h2>
                <ol>
                    <li><a href="<?= BASE_URL . '/' ?>">Beranda</a></li>
                    <li><a href="<?= BASE_URL . '/berita' ?>">Berita</a></li>
                    <li><?= htmlspecialchars($berita['judul']) ?></li>
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
                        <article class="berita-main-article">
                            <!-- Article Image -->
                            <div class="berita-article-image">
                                <a href="<?= resolveImageUrl($berita['image'], 'informasi', ['assets/info']) ?>"
                                    data-lightbox="berita-image">
                                    <img src="<?= resolveImageUrl($berita['image'], 'informasi', ['assets/info']) ?>"
                                        alt="<?= htmlspecialchars($berita['judul']) ?>" loading="lazy">
                                </a>
                                <div class="berita-image-overlay"></div>
                            </div>

                            <!-- Article Content -->
                            <div class="berita-article-content">
                                <h1 class="berita-article-title"><?= htmlspecialchars($berita['judul']) ?></h1>

                                <!-- Meta Information -->
                                <div class="berita-meta-info">
                                    <div class="berita-meta-item">
                                        <i class="bi bi-person-circle"></i>
                                        <span>Oleh <strong><?= htmlspecialchars($berita['author']) ?></strong></span>
                                    </div>
                                    <div class="berita-meta-item">
                                        <i class="bi bi-calendar-event"></i>
                                        <time datetime="<?= date('Y-m-d', strtotime($berita['tanggal_buat'])) ?>">
                                            <?= date('d F Y', strtotime($berita['tanggal_buat'])) ?>
                                        </time>
                                    </div>
                                    <div class="berita-meta-item">
                                        <i class="bi bi-clock-history"></i>
                                        <span><?= date('H:i', strtotime($berita['tanggal_buat'])) ?> WIB</span>
                                    </div>
                                </div>

                                <!-- Article Body -->
                                <div class="berita-article-body">
                                    <?= $berita['deskripsi'] ?>
                                </div>

                                <!-- Social Share -->
                                <div class="berita-share-section">
                                    <h5 class="berita-share-title">
                                        <i class="bi bi-share-fill"></i>
                                        Bagikan Artikel Ini
                                    </h5>
                                    <div class="berita-share-buttons">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(BASE_URL . '/detail-berita/' . $berita['slug']) ?>"
                                            class="berita-share-btn berita-share-btn-facebook" target="_blank"
                                            rel="noopener noreferrer">
                                            <i class="bi bi-facebook"></i>
                                            <span>Facebook</span>
                                        </a>
                                        <a href="https://twitter.com/intent/tweet?url=<?= urlencode(BASE_URL . '/detail-berita/' . $berita['slug']) ?>&text=<?= urlencode($berita['judul']) ?>"
                                            class="berita-share-btn berita-share-btn-twitter" target="_blank"
                                            rel="noopener noreferrer">
                                            <i class="bi bi-twitter-x"></i>
                                            <span>Twitter</span>
                                        </a>
                                        <a href="https://api.whatsapp.com/send?text=<?= urlencode($berita['judul'] . ' - ' . BASE_URL . '/detail-berita/' . $berita['slug']) ?>"
                                            class="berita-share-btn berita-share-btn-whatsapp" target="_blank"
                                            rel="noopener noreferrer">
                                            <i class="bi bi-whatsapp"></i>
                                            <span>WhatsApp</span>
                                        </a>
                                        <a href="javascript:window.print()"
                                            class="berita-share-btn berita-share-btn-print">
                                            <i class="bi bi-printer"></i>
                                            <span>Cetak</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-4">
                        <aside class="berita-sidebar">
                            <!-- Search Box -->
                            <div class="berita-search-box" data-aos="fade-up">
                                <h3 class="berita-sidebar-title">
                                    <i class="bi bi-search"></i>
                                    Cari Berita
                                </h3>
                                <form action="<?= BASE_URL . '/berita' ?>" method="get" class="berita-search-form">
                                    <input type="text" name="search" class="berita-search-input"
                                        placeholder="Cari berita lainnya..." autocomplete="off">
                                    <button type="submit" class="berita-search-btn">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </form>
                            </div>

                            <!-- Recent Posts -->
                            <div class="berita-recent-posts" data-aos="fade-up" data-aos-delay="100">
                                <h3 class="berita-sidebar-title">
                                    <i class="bi bi-newspaper"></i>
                                    Berita Terbaru
                                </h3>

                                <?php if (!empty($berita_terbaru)): ?>
                                <?php foreach ($berita_terbaru as $item): ?>
                                <div class="berita-recent-item">
                                    <h4 class="berita-recent-item-title">
                                        <a href="<?= BASE_URL . '/detail-berita/' . $item['slug'] ?>">
                                            <?= htmlspecialchars($item['judul']) ?>
                                        </a>
                                    </h4>
                                    <div class="berita-recent-item-date">
                                        <i class="bi bi-calendar3"></i>
                                        <time datetime="<?= date('Y-m-d', strtotime($item['tanggal_buat'])) ?>">
                                            <?= date('d M Y', strtotime($item['tanggal_buat'])) ?>
                                        </time>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: var(--berita-muted); text-align: center; padding: 20px;">
                                    Tidak ada berita terbaru
                                </p>
                                <?php endif; ?>
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

    // Copy link functionality (optional)
    function copyLink() {
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(() => {
            alert('Link berhasil disalin!');
        }).catch(err => {
            console.error('Gagal menyalin link:', err);
        });
    }
    </script>
</body>

</html>