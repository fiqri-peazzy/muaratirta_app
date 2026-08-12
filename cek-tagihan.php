<?php
include("path.php");
include(ROOT_PATH . '/app/controllers/users.php');
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Cek Tagihan | Muara Tirta Kota Gorontalo</title>
    <meta content="Cek tagihan air PDAM secara online dengan mudah dan cepat" name="description">
    <meta content="cek tagihan, tagihan air, pdam gorontalo, bayar tagihan" name="keywords">

    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#1e40af">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="mobile-web-app-title" content="PDAM MT">
    <link rel="manifest" href="<?= BASE_URL ?>/manifest.json">

    <!-- Apple Touch Icons -->
    <link rel="apple-touch-icon" href="<?= BASE_URL ?>/assets/logo/icon-152x152.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= BASE_URL ?>/assets/logo/icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= BASE_URL ?>/assets/logo/icon-192x192.png">

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
    <!-- Cek Tagihan Modern CSS -->
    <link href="<?= BASE_URL ?>/assets/css/tagihan.css" rel="stylesheet">
    <!-- html2canvas Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        #tabel-pelanggan tbody tr td {
            padding: 0;
        }

        /* Button Capture Styling */
        .tagihan-btn-capture {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .tagihan-btn-capture:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }

        .tagihan-btn-capture:active {
            transform: translateY(0);
        }

        .tagihan-capture-container {
            text-align: center;
            margin-top: 20px;
            padding: 20px;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border-radius: 15px;
        }

        .tagihan-capture-title {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 12px;
            font-weight: 500;
        }

        /* Watermark for screenshot */
        .tagihan-watermark {
            display: none;
            text-align: center;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-size: 12px;
            margin-top: 10px;
            border-radius: 8px;
        }

        .capturing .tagihan-watermark {
            display: block;
        }

        .capturing .tagihan-btn-capture {
            display: none;
        }

        /* Loading spinner for capture */
        .capture-loading {
            display: none;
            text-align: center;
            padding: 20px;
        }

        .capture-loading.active {
            display: block;
        }

        .capture-spinner {
            border: 4px solid #f3f4f6;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 10px;
        }

        .capturing .hide-on-capture {
            display: none !important;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Button Actions Container */
        .tagihan-capture-actions {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .tagihan-btn-share {
            background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4);
        }

        .tagihan-btn-share:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.6);
        }

        .tagihan-btn-share:active {
            transform: translateY(0);
        }

        /* Share Modal */
        .share-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 10000;
            align-items: center;
            justify-content: center;
        }

        .share-modal.active {
            display: flex;
        }

        .share-modal-content {
            background: white;
            border-radius: 20px;
            padding: 30px;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
            animation: slideUp 0.3s ease;
        }

        .share-modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f1f5f9;
        }

        .share-modal-title {
            font-size: 20px;
            font-weight: 700;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .share-modal-close {
            background: #f1f5f9;
            border: none;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .share-modal-close:hover {
            background: #e2e8f0;
            transform: rotate(90deg);
        }

        .share-preview {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
            background: #f8fafc;
        }

        .share-preview img {
            width: 100%;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .share-options {
            display: grid;
            gap: 10px;
        }

        .share-option-btn {
            background: white;
            border: 2px solid #e2e8f0;
            padding: 15px 20px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 15px;
            font-weight: 600;
            color: #1e293b;
        }

        .share-option-btn:hover {
            border-color: #25d366;
            background: #f0fdf4;
            transform: translateY(-2px);
        }

        .share-option-icon {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
            color: white;
        }

        .share-option-text {
            flex: 1;
        }

        .share-option-text h4 {
            margin: 0 0 5px 0;
            font-size: 16px;
        }

        .share-option-text p {
            margin: 0;
            font-size: 13px;
            color: #64748b;
            font-weight: 400;
        }

        @keyframes slideUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .tagihan-capture-actions {
                flex-direction: column;
            }

            .tagihan-btn-capture,
            .tagihan-btn-share {
                width: 100%;
                justify-content: center;
            }
        }
        
        /* Mobile - Rapat Bagian Header Info Pelanggan Saja */
@media (max-width: 768px) {
    .tagihan-card-header {
        padding: 12px !important;
    }
    
    .tagihan-customer-info {
        gap: 6px !important;
    }
    
    .tagihan-info-row {
        padding: 6px 10px !important;
        gap: 8px !important;
        margin-bottom: 0 !important;
    }
    
    .tagihan-info-label {
        font-size: 11px !important;
    }
    
    .tagihan-info-value {
        font-size: 12px !important;
    }
    
    .tagihan-info-label i {
        font-size: 11px !important;
        margin-right: 4px !important;
    }
}

@media (max-width: 480px) {
    .tagihan-card-header {
        padding: 10px !important;
    }
    
    .tagihan-customer-info {
        gap: 4px !important;
    }
    
    .tagihan-info-row {
        padding: 5px 8px !important;
        gap: 6px !important;
    }
    
    .tagihan-info-label {
        font-size: 10px !important;
    }
    
    .tagihan-info-value {
        font-size: 11px !important;
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
                <h2>Cek Tagihan</h2>
                <ol>
                    <li><a href="<?= BASE_URL . '/' ?>">Beranda</a></li>
                    <li>Cek Tagihan</li>
                </ol>
            </div>
        </div>
        <?php include(ROOT_PATH . '/include/webticker.php') ?>
        <!-- Main Content -->
        <section id="about" class="about section-bg">
            <div class="container" data-aos="fade-up">
                <!-- Search Form -->
                <div class="row justify-content-center mt-5">
                    <div class="col-lg-8">
                        <div class="tagihan-search-wrapper" data-aos="zoom-in">
                            <div class="tagihan-search-icon">
                                <i class="bi bi-search"></i>
                            </div>
                            <h3 class="tagihan-search-title text-center">Cek Tagihan Air Anda</h3>
                            <form method="post" action="<?= BASE_URL . '/api/get-tagihan-detail.php' ?>"
                                id="cek_tagihan_form">
                                <div class="tagihan-form-group">
                                    <input type="text" name="id_pel" class="tagihan-input"
                                        placeholder="Masukkan No. Sambung (7 digit)" maxlength="7" required
                                        oninput="checkInputLength(this)" autocomplete="off">
                                    <button type="submit" class="tagihan-btn-submit">
                                        <i class="bi bi-search me-2"></i>
                                        Cek Sekarang
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Result Card -->
                <div class="row justify-content-center mb-5">
                    <div class="col-lg-10">
                        <div class="tagihan-result-card d-none" id="result-card" data-aos="fade-up">
                            <!-- Capture Container -->
                            <div id="capture-area">
                                <!-- Customer Info Header -->
                                <div class="tagihan-card-header">
                                    <div class="tagihan-customer-info">
                                        <div class="tagihan-info-row">
                                            <span class="tagihan-info-label">
                                                <i class="bi bi-hash"></i>
                                                No. Sambung
                                            </span>
                                            <span class="tagihan-info-value" id="id_pel">-</span>
                                        </div>
                                        <div class="tagihan-info-row">
                                            <span class="tagihan-info-label">
                                                <i class="bi bi-person-circle"></i>
                                                Nama Pelanggan
                                            </span>
                                            <span class="tagihan-info-value" id="nama">-</span>
                                        </div>
                                        <div class="tagihan-info-row">
                                            <span class="tagihan-info-label">
                                                <i class="bi bi-geo-alt-fill"></i>
                                                Alamat
                                            </span>
                                            <span class="tagihan-info-value" id="alamat">-</span>
                                        </div>
                                        <div class="tagihan-info-row">
                                            <span class="tagihan-info-label">
                                                <i class="bi bi-diagram-3-fill"></i>
                                                Klasifikasi
                                            </span>
                                            <span class="tagihan-info-value" id="klasifikasi">-</span>
                                        </div>
                                        <!-- Tambahkan class 'hide-on-capture' untuk menyembunyikan saat capture -->
                                        <div class="tagihan-info-row hide-on-capture">
                                            <span class="tagihan-info-label">
                                                <i class="bi bi-camera-fill"></i>
                                                Foto Rumah
                                            </span>
                                            <span class="tagihan-info-value">
                                                <a href="#" class="tagihan-foto-link" id="foto-rumah-link">
                                                    <i class="bi bi-image"></i>
                                                    Lihat Foto Rumah
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Bills Table -->
                                <div class="tagihan-card-body">
                                    <h3 class="tagihan-section-title">
                                        <i class="bi bi-receipt-cutoff"></i>
                                        Rincian Tagihan
                                    </h3>
                                    <div class="table-responsive">
                                        <table class="tagihan-table" id="tabel-tagihan">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Periode</th>
                                                    <th>Kubik (m³)</th>
                                                    <th>Tagihan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Data akan diisi oleh JavaScript -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Alert Box - Tambahkan class 'hide-on-capture' -->
                                    <div class="tagihan-alert-box hide-on-capture">
                                        <div class="tagihan-alert-header">
                                            <div class="tagihan-alert-icon">
                                                <i class="bi bi-exclamation-triangle-fill"></i>
                                            </div>
                                            <h4 class="tagihan-alert-title">PERHATIAN!</h4>
                                        </div>
                                        <ul class="tagihan-alert-list">
                                            <li class="tagihan-alert-item">
                                                <i class="bi bi-check-circle-fill"></i>
                                                <span>Untuk menghindari <strong>Denda Keterlambatan</strong> dan
                                                    <strong>Sanksi Penyegelan</strong>, mohon untuk melakukan pembayaran
                                                    sebelum tanggal <strong>20 setiap bulan berjalan</strong>.</span>
                                            </li>
                                            <li class="tagihan-alert-item">
                                                <i class="bi bi-check-circle-fill"></i>
                                                <span>Pembayaran melalui metode transfer tanpa konfirmasi bukti transfer
                                                    /
                                                    SP2D maka tagihan kami anggap <strong>BELUM LUNAS!</strong></span>
                                            </li>
                                        </ul>
                                        <div class="tagihan-whatsapp-box">
                                            <span class="tagihan-whatsapp-label">
                                                <i class="bi bi-info-circle-fill me-2"></i>
                                                Konfirmasi Bukti Transfer
                                            </span>
                                            <a href="https://wa.me/6281244697154" class="tagihan-btn-whatsapp"
                                                target="_blank">
                                                <i class="bi bi-whatsapp"></i>
                                                Hubungi via WhatsApp
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Watermark (shown only in screenshot) -->
                                <div class="tagihan-watermark">
                                    <strong>PDAM Muara Tirta Kota Gorontalo</strong><br>
                                    Dicetak pada: <span id="capture-timestamp"></span>
                                </div>
                            </div>
                            <!-- Capture Button Container -->
                            <div class="tagihan-capture-container">
                                <p class="tagihan-capture-title">
                                    <!--<i class="bi bi-download"></i>-->
                                    Simpan atau Bagikan Tagihan
                                </p>
                                <div class="tagihan-capture-actions">
                                    <button type="button" class="tagihan-btn-capture" onclick="captureTagihan()">
                                        <i class="bi bi-download"></i>
                                        Unduh & Bagikan
                                    </button>
                                    <!--<button type="button" class="tagihan-btn-share" onclick="shareToWhatsApp()">-->
                                    <!--    <i class="bi bi-whatsapp"></i>-->
                                    <!--    Bagikan ke WhatsApp-->
                                    <!--</button>-->
                                </div>
                                <!-- Loading State -->
                                <div class="capture-loading" id="capture-loading">
                                    <div class="capture-spinner"></div>
                                    <p style="color: #64748b; margin: 0;">Sedang membuat gambar...</p>
                                </div>
                            </div>
                        </div>
                        <!-- Empty State (Tagihan Lunas/Tidak Tersedia) -->
                        <div class="tagihan-result-card d-none" id="empty-card" data-aos="fade-up">
                            <div class="tagihan-card-body">
                                <div class="tagihan-empty-state">
                                    <div class="tagihan-empty-icon">
                                        <i class="bi bi-check-circle-fill"></i>
                                    </div>
                                    <h3 class="tagihan-empty-title">Tagihan Sudah Lunas atau tidak tersedia</h3>
                                    <p class="tagihan-empty-text">
                                        Hubungi customer service kami untuk informasi lebih lanjut.
                                    </p>
                                    <div class="tagihan-whatsapp-box mt-4">
                                        <span class="tagihan-whatsapp-label">
                                            Butuh Bantuan?
                                        </span>
                                        <a href="https://wa.me/6281244697154" class="tagihan-btn-whatsapp"
                                            target="_blank">
                                            <i class="bi bi-whatsapp"></i>
                                            Hubungi Customer Service
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </main>
    <!-- Modal Foto Rumah -->
    <div class="tagihan-modal" id="foto-modal">
        <div class="tagihan-modal-content">
            <div class="tagihan-modal-header">
                <h3 class="tagihan-modal-title">
                    <i class="bi bi-camera-fill"></i>
                    Foto Rumah Pelanggan
                </h3>
                <button class="tagihan-modal-close" onclick="closeFotoModal()">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="tagihan-modal-body" id="foto-modal-body">
                <!-- Loading State -->
                <div class="tagihan-loading" id="foto-loading">
                    <div class="tagihan-spinner"></div>
                    <p class="tagihan-loading-text">Memuat foto...</p>
                </div>
                <!-- Foto Container -->
                <div class="tagihan-foto-container d-none" id="foto-container">
                    <img src="" alt="Foto Rumah" class="tagihan-foto-img" id="foto-img">
                    <div class="tagihan-foto-info">
                        <div class="tagihan-foto-info-item">
                            <span class="tagihan-foto-info-label">No. Sambung:</span>
                            <span class="tagihan-foto-info-value" id="modal-id-pel">-</span>
                        </div>
                        <div class="tagihan-foto-info-item">
                            <span class="tagihan-foto-info-label">Nama:</span>
                            <span class="tagihan-foto-info-value" id="modal-nama">-</span>
                        </div>
                        <div class="tagihan-foto-info-item">
                            <span class="tagihan-foto-info-label">Alamat:</span>
                            <span class="tagihan-foto-info-value" id="modal-alamat">-</span>
                        </div>
                    </div>
                </div>
                <!-- Error State -->
                <div class="tagihan-error d-none" id="foto-error">
                    <div class="tagihan-error-icon">
                        <i class="bi bi-image-fill"></i>
                    </div>
                    <p class="tagihan-error-text">Foto rumah tidak tersedia atau belum diunggah</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Share Modal -->
    <div class="share-modal" id="share-modal">
        <div class="share-modal-content">
            <div class="share-modal-header">
                <h3 class="share-modal-title">
                    <i class="bi bi-share-fill"></i>
                    Bagikan Tagihan
                </h3>
                <button class="share-modal-close" onclick="closeShareModal()">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <div class="share-preview" id="share-preview">
                <img src="" alt="Preview Tagihan" id="share-preview-img" style="display: none;">
                <div style="text-align: center; padding: 20px;">
                    <div class="capture-spinner"></div>
                    <p style="color: #64748b; margin-top: 10px;">Mempersiapkan gambar...</p>
                </div>
            </div>

            <div class="share-options">
                <button class="share-option-btn" onclick="shareViaWhatsAppPersonal()">
                    <div class="share-option-icon">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div class="share-option-text">
                        <h4>WhatsApp Personal</h4>
                        <p>Bagikan ke kontak WhatsApp pribadi</p>
                    </div>
                </button>

                <button class="share-option-btn" onclick="shareViaWhatsAppWeb()">
                    <div class="share-option-icon">
                        <i class="bi bi-laptop"></i>
                    </div>
                    <div class="share-option-text">
                        <h4>WhatsApp Web</h4>
                        <p>Bagikan melalui WhatsApp Web</p>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <?php include(ROOT_PATH . '/include/footer.php'); ?>
    <a href="#" class="scroll-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>
    <div id="preloader"></div>
    <?php include(ROOT_PATH . '/include/scripts.php'); ?>
    <!-- PWA Install Script -->
    <script src="<?= BASE_URL ?>/pwa-install.js"></script>

    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('<?= BASE_URL ?>/service-worker.js')
                .then((reg) => console.log('✅ Service Worker registered:', reg.scope))
                .catch((err) => console.error('❌ Service Worker registration failed:', err));
        }
    </script>

    <script>
        let capturedImageBlob = null;
        let capturedImageDataUrl = null;

        // Capture tagihan as image (existing function)
        function captureTagihan() {
            const captureArea = document.getElementById('capture-area');
            const loadingEl = document.getElementById('capture-loading');
            const btnCapture = document.querySelector('.tagihan-btn-capture');

            // Set timestamp
            const now = new Date();
            const timestamp = now.toLocaleString('id-ID', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            document.getElementById('capture-timestamp').textContent = timestamp;

            // Show loading
            loadingEl.classList.add('active');
            btnCapture.style.display = 'none';

            // Add capturing class to show watermark
            captureArea.classList.add('capturing');

            // Wait a moment for rendering
            setTimeout(() => {
                html2canvas(captureArea, {
                    scale: 2,
                    backgroundColor: '#ffffff',
                    logging: false,
                    useCORS: true,
                    allowTaint: true
                }).then(canvas => {
                    // Remove capturing class
                    captureArea.classList.remove('capturing');

                    // Convert to blob and download
                    canvas.toBlob(function(blob) {
                        const url = URL.createObjectURL(blob);
                        const link = document.createElement('a');
                        const filename = `Tagihan_${currentNoSambung}_${now.getTime()}.png`;

                        link.href = url;
                        link.download = filename;
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                        URL.revokeObjectURL(url);

                        // Hide loading, show button
                        loadingEl.classList.remove('active');
                        btnCapture.style.display = 'inline-flex';

                        // Show success message
                        toastr.success('Gambar tagihan berhasil diunduh!');
                    }, 'image/png');
                }).catch(error => {
                    console.error('Error capturing:', error);
                    captureArea.classList.remove('capturing');
                    loadingEl.classList.remove('active');
                    btnCapture.style.display = 'inline-flex';
                    toastr.error('Gagal membuat gambar. Silakan coba lagi.');
                });
            }, 300);
        }

        // Share to WhatsApp
        function shareToWhatsApp() {
            const captureArea = document.getElementById('capture-area');
            const loadingEl = document.getElementById('capture-loading');

            // Set timestamp
            const now = new Date();
            const timestamp = now.toLocaleString('id-ID', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            document.getElementById('capture-timestamp').textContent = timestamp;

            // Show loading
            loadingEl.classList.add('active');

            // Add capturing class
            captureArea.classList.add('capturing');

            // Capture image
            setTimeout(() => {
                html2canvas(captureArea, {
                    scale: 2,
                    backgroundColor: '#ffffff',
                    logging: false,
                    useCORS: true,
                    allowTaint: true
                }).then(canvas => {
                    // Remove capturing class
                    captureArea.classList.remove('capturing');

                    // Convert to blob
                    canvas.toBlob(function(blob) {
                        // Upload ke server
                        const formData = new FormData();
                        formData.append('tagihan_image', blob, `tagihan_${currentNoSambung}.png`);

                        fetch('<?= BASE_URL ?>/upload-tagihan.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                loadingEl.classList.remove('active');

                                if (data.success) {
                                    // Buat pesan dengan link gambar
                                    const message = encodeURIComponent(
                                        `*TAGIHAN PDAM MUARA TIRTA*\n\n` +
                                        `👤 Nama: ${currentNama}\n` +
                                        `🔢 No. Sambung: ${currentNoSambung}\n` +
                                        `📍 Alamat: ${currentAlamat}\n\n` +
                                        `📊 Lihat Tagihan Detail:\n${data.url}\n\n` +
                                        `🌐 Cek Online: ${window.location.origin}/cek-tagihan`
                                    );

                                    // Detect mobile or desktop
                                    const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator
                                        .userAgent);
                                    const whatsappUrl = isMobile ?
                                        `whatsapp://send?text=${message}` :
                                        `https://web.whatsapp.com/send?text=${message}`;

                                    // Open WhatsApp
                                    window.open(whatsappUrl, '_blank');

                                    toastr.success(
                                        'Link gambar tagihan berhasil dibuat! Silakan bagikan via WhatsApp.'
                                    );
                                } else {
                                    toastr.error(
                                        'Gagal membuat link gambar. Silakan coba lagi.');
                                }
                            })
                            .catch(error => {
                                console.error('Error uploading:', error);
                                loadingEl.classList.remove('active');
                                toastr.error('Terjadi kesalahan saat upload gambar.');
                            });
                    }, 'image/png');
                }).catch(error => {
                    console.error('Error capturing:', error);
                    captureArea.classList.remove('capturing');
                    loadingEl.classList.remove('active');
                    toastr.error('Gagal membuat gambar. Silakan coba lagi.');
                });
            }, 300);
        }
        // Share via WhatsApp Personal (Mobile)
        function shareViaWhatsAppPersonal() {
            if (!capturedImageBlob) {
                toastr.error('Gambar belum siap. Silakan coba lagi.');
                return;
            }

            // Check if Web Share API is supported
            if (navigator.share && navigator.canShare) {
                const file = new File([capturedImageBlob], `Tagihan_${currentNoSambung}.png`, {
                    type: 'image/png'
                });

                const shareData = {
                    title: 'Tagihan PDAM Muara Tirta',
                    text: `Tagihan PDAM a.n ${currentNama}\nNo. Sambung: ${currentNoSambung}\n\nCek tagihan Anda di: ${window.location.origin}/cek-tagihan`,
                    files: [file]
                };

                if (navigator.canShare(shareData)) {
                    navigator.share(shareData)
                        .then(() => {
                            closeShareModal();
                            toastr.success('Berhasil dibagikan!');
                        })
                        .catch((error) => {
                            console.error('Error sharing:', error);
                            // Fallback to WhatsApp direct link
                            shareViaWhatsAppDirect();
                        });
                } else {
                    // Fallback if can't share files
                    shareViaWhatsAppDirect();
                }
            } else {
                // Fallback for browsers that don't support Web Share API
                shareViaWhatsAppDirect();
            }
        }

        // Share via WhatsApp Direct (Fallback)
        function shareViaWhatsAppDirect() {
            const message = encodeURIComponent(
                `*Tagihan PDAM Muara Tirta*\n\n` +
                `Nama: ${currentNama}\n` +
                `No. Sambung: ${currentNoSambung}\n` +
                `Alamat: ${currentAlamat}\n\n` +
                `Cek tagihan lengkap Anda di:\n${window.location.origin}/cek-tagihan`
            );

            // Detect mobile or desktop
            const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
            const whatsappUrl = isMobile ?
                `whatsapp://send?text=${message}` :
                `https://wa.me/?text=${message}`;

            window.open(whatsappUrl, '_blank');
            closeShareModal();

            toastr.info('Silakan pilih kontak untuk membagikan tagihan. Gambar dapat dikirim secara terpisah.');
        }

        // Share via WhatsApp Web
        function shareViaWhatsAppWeb() {
            const message = encodeURIComponent(
                `*Tagihan PDAM Muara Tirta*\n\n` +
                `Nama: ${currentNama}\n` +
                `No. Sambung: ${currentNoSambung}\n` +
                `Alamat: ${currentAlamat}\n\n` +
                `Cek tagihan lengkap Anda di:\n${window.location.origin}/cek-tagihan`
            );

            window.open(`https://web.whatsapp.com/send?text=${message}`, '_blank');
            closeShareModal();

            toastr.info('Silakan pilih kontak di WhatsApp Web. Gambar dapat dikirim secara terpisah.');
        }

        // Close share modal
        function closeShareModal() {
            const shareModal = document.getElementById('share-modal');
            shareModal.classList.remove('active');
            capturedImageBlob = null;
            capturedImageDataUrl = null;
        }

        // Close modal when clicking outside
        document.getElementById('share-modal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeShareModal();
            }
        });
    </script>

    <script>
        // Global variables
        let currentNoSambung = '';
        let currentNama = '';
        let currentAlamat = '';

        // Check input length
        function checkInputLength(input) {
            if (input.value.length > 7) {
                input.value = input.value.slice(0, 7);
                toastr.error('Maksimal 7 digit');
            }
        }

        // Get classification name
        function ketGolongan(gol) {
            const golonganMap = {
                '01': 'Sosial Umum',
                '02': 'Sosial Khusus',
                '03': 'Rumah Tangga A',
                '04': 'Rumah Tangga B',
                '05': 'Instansi Pemerintah',
                '06': 'Niaga Kecil',
                '07': 'Niaga Besar',
                '08': 'Rumah Tangga C',
                '09': 'Khusus',
                '10': 'Rumah Tangga D'
            };
            return golonganMap[gol] || 'Klasifikasi Tidak Dikenali';
        }

        // Format currency
        function formatRupiah(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(amount);
        }

        // Capture tagihan as image
        function captureTagihan() {
            const captureArea = document.getElementById('capture-area');
            const loadingEl = document.getElementById('capture-loading');
            const btnCapture = document.querySelector('.tagihan-btn-capture');

            // Set timestamp
            const now = new Date();
            const timestamp = now.toLocaleString('id-ID', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            document.getElementById('capture-timestamp').textContent = timestamp;

            // Show loading
            loadingEl.classList.add('active');
            btnCapture.style.display = 'none';

            // Add capturing class to show watermark
            captureArea.classList.add('capturing');

            // Wait a moment for rendering
            setTimeout(() => {
                html2canvas(captureArea, {
                    scale: 2,
                    backgroundColor: '#ffffff',
                    logging: false,
                    useCORS: true,
                    allowTaint: true
                }).then(canvas => {
                    // Remove capturing class
                    captureArea.classList.remove('capturing');

                    // Convert to blob and download
                    canvas.toBlob(function(blob) {
                        const url = URL.createObjectURL(blob);
                        const link = document.createElement('a');
                        const filename = `Tagihan_${currentNoSambung}_${now.getTime()}.png`;

                        link.href = url;
                        link.download = filename;
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                        URL.revokeObjectURL(url);

                        // Hide loading, show button
                        loadingEl.classList.remove('active');
                        btnCapture.style.display = 'inline-flex';

                        // Show success message
                        toastr.success('Gambar tagihan berhasil diunduh!');
                    }, 'image/png');
                }).catch(error => {
                    console.error('Error capturing:', error);
                    captureArea.classList.remove('capturing');
                    loadingEl.classList.remove('active');
                    btnCapture.style.display = 'inline-flex';
                    toastr.error('Gagal membuat gambar. Silakan coba lagi.');
                });
            }, 300);
        }

        // Open foto modal
        function openFotoModal(noSambung, nama, alamat) {
            currentNoSambung = noSambung;
            currentNama = nama;
            currentAlamat = alamat;
            const modal = document.getElementById('foto-modal');
            const loading = document.getElementById('foto-loading');
            const container = document.getElementById('foto-container');
            const error = document.getElementById('foto-error');

            // Reset states
            loading.classList.remove('d-none');
            container.classList.add('d-none');
            error.classList.add('d-none');

            // Show modal
            modal.classList.add('active');

            // Set info
            document.getElementById('modal-id-pel').textContent = noSambung;
            document.getElementById('modal-nama').textContent = nama;
            document.getElementById('modal-alamat').textContent = alamat;

            // Load image
            // const fotoUrl = `http://103.133.223.242/sister-gto/api/uploads/rumah/${noSambung}.jpg`;
            const fotoUrl = `proxy.php?id=${noSambung}`;

            const img = document.getElementById('foto-img');

            img.onload = function() {
                loading.classList.add('d-none');
                container.classList.remove('d-none');
            };

            img.onerror = function() {
                loading.classList.add('d-none');
                error.classList.remove('d-none');
            };

            img.src = fotoUrl;
        }

        // Close foto modal
        function closeFotoModal() {
            const modal = document.getElementById('foto-modal');
            modal.classList.remove('active');
        }

        // Close modal when clicking outside
        document.getElementById('foto-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeFotoModal();
            }
        });

        // Close modal with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeFotoModal();
            }
        });

        // Form submission
        $('#cek_tagihan_form').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            var formData = new FormData(form);

            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function() {
                    toastr.remove();
                    $('#result-card').addClass('d-none');
                    $('#empty-card').addClass('d-none');
                    $('#tabel-tagihan tbody').empty();
                },
                success: function(response) {
                    if ($.isEmptyObject(response.error)) {
                        if (response.status == 'true' && response.pelanggan && response.pelanggan
                            .length > 0) {
                            // Has bills
                            const pelanggan = response.pelanggan[0];
                            currentNoSambung = pelanggan.NOSAMW;
                            currentNama = pelanggan.NAMA;
                            currentAlamat = pelanggan.ALAMAT;

                            $(form)[0].reset();
                            $('#result-card').removeClass('d-none');

                            // Fill customer info
                            $('#id_pel').text(currentNoSambung);
                            $('#nama').text(currentNama);
                            $('#alamat').text(currentAlamat);
                            $('#klasifikasi').text(ketGolongan(pelanggan.GOLONGAN));

                            // Setup foto link
                            $('#foto-rumah-link').off('click').on('click', function(e) {
                                e.preventDefault();
                                openFotoModal(currentNoSambung, currentNama, currentAlamat);
                            });

                            // Fill bills table
                            let no = 0;
                            let totalTagihan = 0;

                            $.each(response.pelanggan, function(index, item) {
                                no++;
                                totalTagihan += parseInt(item.TAGIHAN);
                                $('#tabel-tagihan tbody').append(`
                                <tr>
                                    <td>${no}</td>
                                    <td>${item.PERIODE}</td>
                                    <td>${item.PAKAI}</td>
                                    <td>${formatRupiah(item.TAGIHAN)}</td>
                                </tr>
                            `);
                            });

                            // Add total row
                            $('#tabel-tagihan tbody').append(`
                            <tr class="tagihan-total-row">
                                <td colspan="3" style="text-align: center;">
                                    <strong>TOTAL TAGIHAN</strong>
                                </td>
                                <td><strong>${formatRupiah(totalTagihan)}</strong></td>
                            </tr>
                        `);

                            // Scroll to result
                            $('html, body').animate({
                                scrollTop: $('#result-card').offset().top - 100
                            }, 800);

                        } else {
                            // No bills (Lunas)
                            const noSambung = $('input[name="id_pel"]').val();
                            currentNoSambung = noSambung;

                            $(form)[0].reset();
                            $('#empty-card').removeClass('d-none');

                            // Scroll to result
                            $('html, body').animate({
                                scrollTop: $('#empty-card').offset().top - 100
                            }, 800);
                        }
                    } else {
                        var errMsg = '';
                        $.each(response.error, function(i, val) {
                            errMsg += val;
                        });
                        toastr.error(errMsg);
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('Terjadi kesalahan saat mengambil data. Silakan coba lagi.');
                    console.error('Error:', error);
                }
            });
        });

        // Session messages
        <?php if (isset($_SESSION['messages']) && isset($_SESSION['type'])) : ?>
            swal({
                title: '<?php echo $_SESSION['title'] ?? 'Notifikasi' ?>',
                text: '<?php echo $_SESSION['messages'] ?>',
                type: '<?php echo $_SESSION['type'] ?>',
                timer: 3000
            });
            <?php
            unset($_SESSION['messages']);
            unset($_SESSION['type']);
            unset($_SESSION['title']);
            ?>
        <?php endif; ?>
    </script>

</body>

</html>