<?php
include("path.php");
include(ROOT_PATH . '/app/controllers/users.php');
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM informasi WHERE tag='Berita' AND (judul LIKE ? OR deskripsi LIKE ?)";
    $stmt = $conn->prepare($sql);
    prepStmtForFetch($stmt);
    $like = '%' . $search . '%';
    $stmt->bind_param('ss', $like, $like);
    $stmt->execute();
    $all_berita = stmtFetchAllAssoc($stmt);
    if (count($all_berita) > 0) {
        $page_header = 'Hasil Pencarian Untuk ' . htmlspecialchars($search) . '...';
        $itemsPerPage = 6;
        $totalItems = count($all_berita);
        $totalPages = ceil($totalItems / $itemsPerPage);
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($currentPage - 1) * $itemsPerPage;
        $paginatedBerita = array_slice($all_berita, $offset, $itemsPerPage);
    } else {
        $all_berita = array();
        $page_header = 'Tidak Ada Hasil Pencarian Untuk ' . htmlspecialchars($search) . '...';
    }
} else {
    $all_berita = selectAll('informasi', ['tag' => 'Berita'], 'tanggal_buat');
    $page_header = 'Semua Berita';
    $itemsPerPage = 6;
    $totalItems = count($all_berita);
    $totalPages = ceil($totalItems / $itemsPerPage);
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($currentPage - 1) * $itemsPerPage;
    $paginatedBerita = array_slice($all_berita, $offset, $itemsPerPage);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Berita Muaratirta | Muara Tirta Kota Gorontalo</title>
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
    /* Berita Enhanced Styles - Prefix: br- */
    .br-enhanced-section {
        padding: 60px 0;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        min-height: 70vh;
    }

    /* Header Section */
    .br-header {
        margin-bottom: 40px;
    }

    .br-title-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 30px;
    }

    .br-title {
        font-size: 32px;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0;
        position: relative;
        padding-bottom: 12px;
    }

    .br-title:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, #007bff, #0056b3);
        border-radius: 2px;
    }

    /* Search Bar */
    .br-search-wrapper {
        position: relative;
        max-width: 400px;
        width: 100%;
    }

    .br-search-input {
        width: 100%;
        padding: 12px 48px 12px 20px;
        border: 2px solid #e9ecef;
        border-radius: 25px;
        font-size: 14px;
        transition: all 0.3s ease;
        background: #ffffff;
    }

    .br-search-input:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 4px rgba(0, 123, 255, 0.1);
    }

    .br-search-btn {
        position: absolute;
        right: 4px;
        top: 50%;
        transform: translateY(-50%);
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .br-search-btn:hover {
        transform: translateY(-50%) scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
    }

    .br-search-btn svg {
        width: 18px;
        height: 18px;
        fill: #ffffff;
    }

    /* News Grid */
    .br-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 30px;
        margin-bottom: 50px;
    }

    .br-card {
        background: #ffffff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(0, 123, 255, 0.08);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .br-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 32px rgba(0, 123, 255, 0.15);
        border-color: #007bff;
    }

    /* Card Image */
    .br-card-image {
        position: relative;
        width: 100%;
        height: 220px;
        overflow: hidden;
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    }

    .br-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .br-card:hover .br-card-image img {
        transform: scale(1.08);
    }

    .br-date-badge {
        position: absolute;
        top: 16px;
        right: 16px;
        background: rgba(255, 255, 255, 0.95);
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        color: #007bff;
        backdrop-filter: blur(10px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    /* Card Content */
    .br-card-content {
        padding: 24px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .br-card-title {
        font-size: 18px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 12px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .br-card-meta {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 12px;
        font-size: 13px;
        color: #666;
        flex-wrap: wrap;
    }

    .br-meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .br-meta-item svg {
        width: 14px;
        height: 14px;
        fill: #007bff;
    }

    .br-card-excerpt {
        color: #666;
        font-size: 14px;
        line-height: 1.7;
        margin-bottom: 16px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex: 1;
    }

    .br-read-more {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #007bff;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        margin-top: auto;
    }

    .br-read-more:hover {
        color: #0056b3;
        gap: 12px;
    }

    .br-read-more svg {
        width: 16px;
        height: 16px;
        fill: currentColor;
        transition: transform 0.3s ease;
    }

    .br-read-more:hover svg {
        transform: translateX(4px);
    }

    /* Pagination */
    .br-pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 40px;
    }

    .br-page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #ffffff;
        border: 2px solid #e9ecef;
        color: #666;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .br-page-link:hover {
        border-color: #007bff;
        color: #007bff;
        background: rgba(0, 123, 255, 0.05);
    }

    .br-page-link.active {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        border-color: #007bff;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
    }

    /* Empty State */
    .br-empty-state {
        text-align: center;
        padding: 80px 20px;
    }

    .br-empty-icon {
        width: 120px;
        height: 120px;
        margin: 0 auto 24px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .br-empty-icon svg {
        width: 60px;
        height: 60px;
        fill: #666;
    }

    .br-empty-title {
        font-size: 24px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 12px;
    }

    .br-empty-text {
        color: #666;
        font-size: 16px;
        margin-bottom: 24px;
    }

    .br-empty-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        color: #ffffff;
        padding: 12px 28px;
        border-radius: 25px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
    }

    .br-empty-btn:hover {
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 123, 255, 0.4);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .br-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .br-title-wrapper {
            flex-direction: column;
            align-items: flex-start;
        }

        .br-search-wrapper {
            max-width: 100%;
        }

        .br-title {
            font-size: 26px;
        }

        .br-card-image {
            height: 200px;
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

    .br-card {
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
                <h2>BERITA</h2>
                <ol>
                    <li><a href="<?php echo BASE_URL . '/' ?>">Beranda</a></li>
                    <li>Berita</li>
                </ol>
            </div>
        </div>

        <?php include(ROOT_PATH . '/include/webticker.php') ?>

        <!-- Enhanced Berita Section -->
        <section class="br-enhanced-section">
            <div class="container" data-aos="fade-up">

                <!-- Header with Search -->
                <div class="br-header">
                    <div class="br-title-wrapper">
                        <h2 class="br-title"><?php echo $page_header; ?></h2>
                        <form action="<?php echo BASE_URL . '/berita' ?>" method="GET" class="br-search-wrapper">
                            <input type="text" name="search" class="br-search-input" placeholder="Cari berita..."
                                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                            <button type="submit" class="br-search-btn">
                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- News Grid -->
                <?php if (!empty($paginatedBerita)) : ?>
                <div class="br-grid">
                    <?php foreach ($paginatedBerita as $berita) : ?>
                    <article class="br-card">
                        <div class="br-card-image">
                            <img src="<?php echo resolveImageUrl($berita['image'], 'informasi', ['assets/info']) ?>"
                                alt="<?php echo htmlspecialchars($berita['judul']) ?>">
                            <span class="br-date-badge">
                                <?php echo date('d M Y', strtotime($berita['tanggal_buat'])) ?>
                            </span>
                        </div>
                        <div class="br-card-content">
                            <h3 class="br-card-title"><?php echo $berita['judul'] ?></h3>
                            <div class="br-card-meta">
                                <div class="br-meta-item">
                                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                    </svg>
                                    <span><?php echo $berita['author'] ?></span>
                                </div>
                                <div class="br-meta-item">
                                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z" />
                                    </svg>
                                    <span><?php echo date('H:i', strtotime($berita['tanggal_buat'])) ?></span>
                                </div>
                            </div>
                            <p class="br-card-excerpt">
                                <?php echo substr(strip_tags($berita['deskripsi']), 0, 150) . '...' ?>
                            </p>
                            <a href="<?php echo BASE_URL . '/detail-berita/' . $berita['slug'] ?>" class="br-read-more">
                                Baca Selengkapnya
                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z" />
                                </svg>
                            </a>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <?php if (empty($_GET['search']) && $totalPages > 1) : ?>
                <div class="br-pagination">
                    <?php for ($page = 1; $page <= $totalPages; $page++) : ?>
                    <a href="<?php echo BASE_URL . '/berita?page=' . $page; ?>"
                        class="br-page-link <?php echo ($page == $currentPage) ? 'active' : ''; ?>">
                        <?php echo $page; ?>
                    </a>
                    <?php endfor; ?>
                </div>
                <?php endif; ?>

                <?php else : ?>
                <!-- Empty State -->
                <div class="br-empty-state">
                    <div class="br-empty-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                        </svg>
                    </div>
                    <h3 class="br-empty-title">Tidak Ada Hasil Ditemukan</h3>
                    <p class="br-empty-text">Maaf, pencarian Anda tidak menemukan hasil. Coba kata kunci lain.</p>
                    <a href="<?php echo BASE_URL . '/berita' ?>" class="br-empty-btn">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                            style="width: 18px; height: 18px; fill: currentColor;">
                            <path
                                d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
                        </svg>
                        Lihat Semua Berita
                    </a>
                </div>
                <?php endif; ?>

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