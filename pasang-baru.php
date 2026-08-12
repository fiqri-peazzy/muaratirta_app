<?php
include("path.php");
include(ROOT_PATH . '/app/controllers/users.php');
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Daftar Pasang Baru | Muara Tirta Kota Gorontalo</title>
    <meta content="Daftar pemasangan sambungan air bersih PDAM Muara Tirta secara online" name="description">
    <meta content="pasang baru, daftar pdam, sambungan air, pdam gorontalo" name="keywords">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Roboto:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Work+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">

    <link href="assets/logo/Logo-PDAM-MT-min.ico" rel="icon">
    <?php include(ROOT_PATH . '/include/styles.php'); ?>

    <style>
    /* ========================================
       PASANG BARU - MODERN STYLES
       ======================================== */


    :root {
        --pb-primary: #0D6EFD;
        --pb-primary-dark: #0B5ED7;
        --pb-secondary: #0DCAF0;
        --pb-success: #198754;
        --pb-warning: #FFC107;
        --pb-danger: #DC3545;
        --pb-dark: #1a2332;
        --pb-light: #F8F9FA;
        --pb-white: #FFFFFF;
        --pb-text: #2C3E50;
        --pb-muted: #6C757D;
        --pb-shadow-sm: 0 2px 12px rgba(13, 110, 253, 0.1);
        --pb-shadow-md: 0 4px 20px rgba(13, 110, 253, 0.15);
        --pb-shadow-lg: 0 8px 32px rgba(13, 110, 253, 0.2);
        --pb-radius: 20px;
        --pb-transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Header Section */
    .pb-header-section {
        background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%);
        border-radius: var(--pb-radius);
        padding: 60px 40px;
        margin-bottom: 40px;
        position: relative;
        overflow: hidden;
        box-shadow: var(--pb-shadow-md);
    }

    .pb-header-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, transparent 70%);
        animation: pb-rotate 20s linear infinite;
    }

    @keyframes pb-rotate {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    .pb-header-content {
        display: flex;
        align-items: center;
        gap: 40px;
        position: relative;
        z-index: 1;
    }

    .pb-animation-box {
        width: 180px;
        height: 180px;
        flex-shrink: 0;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: var(--pb-shadow-md);
    }

    .pb-header-text {
        flex: 1;
    }

    .pb-badge {
        display: inline-block;
        padding: 8px 20px;
        background: rgba(13, 110, 253, 0.2);
        color: var(--pb-primary);
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 16px;
    }

    .pb-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--pb-text);
        margin-bottom: 12px;
        line-height: 1.2;
    }

    .pb-subtitle {
        font-size: 1.125rem;
        color: var(--pb-muted);
        line-height: 1.6;
    }

    /* Step Progress */
    .pb-step-container {
        background: white;
        border-radius: var(--pb-radius);
        padding: 40px;
        margin-bottom: 32px;
        box-shadow: var(--pb-shadow-sm);
    }

    .pb-steps {
        display: flex;
        justify-content: space-between;
        margin-bottom: 48px;
        position: relative;
    }

    .pb-steps::before {
        content: '';
        position: absolute;
        top: 32px;
        left: 10%;
        right: 10%;
        height: 3px;
        background: var(--pb-light);
        z-index: 0;
    }

    .pb-step-progress {
        position: absolute;
        top: 32px;
        left: 10%;
        height: 3px;
        background: linear-gradient(90deg, var(--pb-primary) 0%, var(--pb-secondary) 100%);
        width: 0%;
        transition: width 0.6s ease;
        z-index: 1;
    }

    .pb-step {
        flex: 1;
        text-align: center;
        position: relative;
        z-index: 2;
    }

    .pb-step-circle {
        width: 64px;
        height: 64px;
        background: white;
        border: 4px solid var(--pb-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--pb-muted);
        transition: var(--pb-transition);
        box-shadow: var(--pb-shadow-sm);
    }

    .pb-step.active .pb-step-circle {
        background: linear-gradient(135deg, var(--pb-primary) 0%, var(--pb-secondary) 100%);
        border-color: var(--pb-primary);
        color: white;
        transform: scale(1.1);
        box-shadow: var(--pb-shadow-md);
    }

    .pb-step.completed .pb-step-circle {
        background: var(--pb-success);
        border-color: var(--pb-success);
        color: white;
    }

    .pb-step-label {
        font-size: 0.9375rem;
        font-weight: 600;
        color: var(--pb-muted);
        transition: var(--pb-transition);
    }

    .pb-step.active .pb-step-label {
        color: var(--pb-primary);
        font-weight: 700;
    }

    .pb-step.completed .pb-step-label {
        color: var(--pb-success);
    }

    /* Form Sections */
    .pb-form-section {
        display: none;
    }

    .pb-form-section.active {
        display: block;
        animation: pb-fadeInUp 0.5s ease;
    }

    @keyframes pb-fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .pb-section-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--pb-text);
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 3px solid var(--pb-light);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .pb-section-title i {
        color: var(--pb-primary);
        font-size: 1.75rem;
    }

    /* Form Groups */
    .pb-form-group {
        margin-bottom: 24px;
    }

    .pb-form-label {
        display: block;
        font-size: 0.9375rem;
        font-weight: 700;
        color: var(--pb-text);
        margin-bottom: 8px;
    }

    .pb-form-label .required {
        color: var(--pb-danger);
        margin-left: 4px;
    }

    .pb-form-control {
        width: 100%;
        padding: 14px 20px;
        border: 2px solid #E0E0E0;
        border-radius: 12px;
        font-size: 1rem;
        color: var(--pb-text);
        transition: var(--pb-transition);
        background: white;
    }

    .pb-form-control:focus {
        outline: none;
        border-color: var(--pb-primary);
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
    }

    .pb-form-control:disabled {
        background: var(--pb-light);
        cursor: not-allowed;
    }

    /* File Upload */
    .pb-upload-area {
        border: 3px dashed #E0E0E0;
        border-radius: 12px;
        padding: 32px;
        text-align: center;
        background: var(--pb-light);
        cursor: pointer;
        transition: var(--pb-transition);
        position: relative;
    }

    .pb-upload-area:hover {
        border-color: var(--pb-primary);
        background: #E3F2FD;
    }

    .pb-upload-area.has-file {
        border-color: var(--pb-success);
        background: #E8F5E9;
    }

    .pb-upload-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--pb-primary) 0%, var(--pb-secondary) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        color: white;
        font-size: 2rem;
    }

    .pb-upload-area.has-file .pb-upload-icon {
        background: var(--pb-success);
    }

    .pb-upload-text {
        font-size: 1rem;
        font-weight: 600;
        color: var(--pb-text);
        margin-bottom: 8px;
    }

    .pb-upload-hint {
        font-size: 0.875rem;
        color: var(--pb-muted);
    }

    .pb-file-input {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        cursor: pointer;
    }

    .pb-file-name {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: white;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--pb-success);
        margin-top: 12px;
    }

    /* Location Button */
    .pb-location-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: white;
        border: 2px solid var(--pb-primary);
        border-radius: 50px;
        color: var(--pb-primary);
        font-weight: 700;
        font-size: 0.9375rem;
        cursor: pointer;
        transition: var(--pb-transition);
        margin-top: 12px;
    }

    .pb-location-btn:hover {
        background: var(--pb-primary);
        color: white;
        transform: translateY(-2px);
        box-shadow: var(--pb-shadow-md);
    }

    .pb-location-btn i {
        font-size: 1.125rem;
    }

    .pb-spinner {
        display: none;
        margin-left: 16px;
        color: var(--pb-primary);
    }

    .pb-spinner.active {
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .pb-spinner i {
        animation: pb-spin 1s linear infinite;
    }

    @keyframes pb-spin {
        to {
            transform: rotate(360deg);
        }
    }

    /* Info Box */
    .pb-info-box {
        background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%);
        border-left: 5px solid var(--pb-primary);
        border-radius: 12px;
        padding: 20px;
        margin: 24px 0;
    }

    .pb-info-box-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }

    .pb-info-icon {
        width: 40px;
        height: 40px;
        background: var(--pb-primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
    }

    .pb-info-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--pb-primary);
        margin: 0;
    }

    .pb-info-text {
        font-size: 0.9375rem;
        color: var(--pb-text);
        line-height: 1.6;
        margin: 0;
    }

    /* Requirements List */
    .pb-requirements {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .pb-requirement-item {
        display: flex;
        align-items: start;
        gap: 12px;
        padding: 16px;
        background: white;
        border-radius: 12px;
        margin-bottom: 12px;
        box-shadow: var(--pb-shadow-sm);
        transition: var(--pb-transition);
    }

    .pb-requirement-item:hover {
        transform: translateX(8px);
        box-shadow: var(--pb-shadow-md);
    }

    .pb-requirement-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--pb-primary) 0%, var(--pb-secondary) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.125rem;
        flex-shrink: 0;
    }

    .pb-requirement-text {
        flex: 1;
        padding-top: 8px;
    }

    .pb-requirement-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--pb-text);
        margin-bottom: 4px;
    }

    .pb-requirement-desc {
        font-size: 0.875rem;
        color: var(--pb-muted);
        line-height: 1.5;
    }

    /* Agreement Box */
    .pb-agreement-box {
        background: #FFF3CD;
        border: 2px solid var(--pb-warning);
        border-radius: 12px;
        padding: 24px;
        margin: 24px 0;
    }

    .pb-agreement-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: #856404;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .pb-agreement-title i {
        font-size: 1.5rem;
    }

    .pb-agreement-content {
        background: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 16px;
        max-height: 200px;
        overflow-y: auto;
    }

    .pb-agreement-text {
        font-size: 0.9375rem;
        color: var(--pb-text);
        line-height: 1.8;
    }

    .pb-checkbox-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px;
        background: white;
        border-radius: 8px;
    }

    .pb-checkbox {
        width: 24px;
        height: 24px;
        cursor: pointer;
    }

    .pb-checkbox-label {
        font-size: 1rem;
        font-weight: 700;
        color: var(--pb-text);
        cursor: pointer;
        user-select: none;
    }

    /* Buttons */
    .pb-button-group {
        display: flex;
        gap: 16px;
        justify-content: flex-end;
        margin-top: 32px;
        padding-top: 32px;
        border-top: 2px solid var(--pb-light);
    }

    .pb-btn {
        padding: 14px 32px;
        border-radius: 50px;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        transition: var(--pb-transition);
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .pb-btn-secondary {
        background: var(--pb-light);
        color: var(--pb-text);
    }

    .pb-btn-secondary:hover {
        background: #E0E0E0;
    }

    .pb-btn-primary {
        background: linear-gradient(135deg, var(--pb-primary) 0%, var(--pb-secondary) 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    }

    .pb-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(13, 110, 253, 0.4);
    }

    .pb-btn-primary:disabled {
        background: var(--pb-light);
        color: var(--pb-muted);
        cursor: not-allowed;
        box-shadow: none;
    }

    .pb-btn i {
        font-size: 1.125rem;
    }

    /* Modal */
    .pb-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.85);
        backdrop-filter: blur(8px);
        align-items: center;
        justify-content: center;
    }

    .pb-modal.active {
        display: flex;
        animation: pb-fadeIn 0.3s ease;
    }

    @keyframes pb-fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .pb-modal-content {
        background: white;
        border-radius: var(--pb-radius);
        max-width: 500px;
        width: 90%;
        padding: 40px;
        position: relative;
        animation: pb-scaleIn 0.3s ease;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    }

    @keyframes pb-scaleIn {
        from {
            transform: scale(0.9);
            opacity: 0;
        }

        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    .pb-modal-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, var(--pb-primary) 0%, var(--pb-secondary) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
        color: white;
        font-size: 3rem;
    }

    .pb-modal-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--pb-text);
        text-align: center;
        margin-bottom: 16px;
    }

    .pb-modal-text {
        font-size: 1.125rem;
        color: var(--pb-muted);
        text-align: center;
        margin-bottom: 24px;
        line-height: 1.6;
    }

    .pb-modal-price {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--pb-primary);
        text-align: center;
        margin-bottom: 24px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .pb-header-content {
            flex-direction: column;
            text-align: center;
        }

        .pb-title {
            font-size: 2rem;
        }

        .pb-steps {
            flex-direction: column;
            gap: 24px;
        }

        .pb-steps::before,
        .pb-step-progress {
            display: none;
        }

        .pb-button-group {
            flex-direction: column;
        }

        .pb-btn {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        .pb-header-section {
            padding: 40px 24px;
        }

        .pb-animation-box {
            width: 150px;
            height: 150px;
        }

        .pb-title {
            font-size: 1.75rem;
        }

        .pb-step-container {
            padding: 24px 20px;
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
                <h2>PEMASANGAN BARU</h2>
                <ol>
                    <li><a href="<?= BASE_URL . '/' ?>">Beranda</a></li>
                    <li>Pasang Baru</li>
                </ol>
            </div>
        </div>

        <?php include(ROOT_PATH . '/include/webticker.php') ?>

        <!-- Main Content -->
        <section id="about" class="about section-bg">
            <div class="container pb-container" data-aos="fade-up">

                <!-- Header with Animation -->
                <div class="pb-header-section" data-aos="zoom-in">
                    <div class="pb-header-content">
                        <div class="pb-animation-box">
                            <script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.8.5/dist/dotlottie-wc.js"
                                type="module"></script>
                            <dotlottie-wc
                                src="https://lottie.host/188d39df-296b-4795-b2b7-8a10f7ef4145/eNuxuAbH6X.lottie"
                                style="width: 100%;height: 100%" autoplay loop></dotlottie-wc>
                        </div>
                        <div class="pb-header-text">
                            <span class="pb-badge">
                                <i class="bi bi-plus-circle me-2"></i>
                                Registrasi Online
                            </span>
                            <h1 class="pb-title">Daftar Pemasangan Sambungan Baru</h1>
                            <p class="pb-subtitle">
                                Proses pendaftaran mudah dan cepat. Lengkapi formulir di bawah ini untuk mendapatkan
                                sambungan air bersih PDAM Muara Tirta.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Step Progress -->
                <div class="pb-step-container" data-aos="fade-up">
                    <div class="pb-steps">
                        <div class="pb-step-progress" id="stepProgress"></div>

                        <div class="pb-step active" data-step="1">
                            <div class="pb-step-circle">
                                <i class="bi bi-file-earmark-text"></i>
                            </div>
                            <div class="pb-step-label">Persyaratan</div>
                        </div>

                        <div class="pb-step" data-step="2">
                            <div class="pb-step-circle">
                                <i class="bi bi-cloud-upload"></i>
                            </div>
                            <div class="pb-step-label">Upload Dokumen</div>
                        </div>

                        <div class="pb-step" data-step="3">
                            <div class="pb-step-circle">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div class="pb-step-label">Data Lokasi</div>
                        </div>

                        <div class="pb-step" data-step="4">
                            <div class="pb-step-circle">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <div class="pb-step-label">Konfirmasi</div>
                        </div>
                    </div>

                    <form method="post" enctype="multipart/form-data" id="pasangBaruForm">

                        <!-- Step 1: Requirements -->
                        <div class="pb-form-section active" data-section="1">
                            <h3 class="pb-section-title">
                                <i class="bi bi-clipboard-check"></i>
                                Persyaratan Pendaftaran
                            </h3>

                            <ul class="pb-requirements">
                                <li class="pb-requirement-item" data-aos="fade-right" data-aos-delay="100">
                                    <div class="pb-requirement-icon">
                                        <i class="bi bi-card-heading"></i>
                                    </div>
                                    <div class="pb-requirement-text">
                                        <div class="pb-requirement-title">Foto KTP Asli</div>
                                        <div class="pb-requirement-desc">Scan atau foto KTP yang masih berlaku dengan
                                            jelas dan tidak blur</div>
                                    </div>
                                </li>

                                <li class="pb-requirement-item" data-aos="fade-right" data-aos-delay="200">
                                    <div class="pb-requirement-icon">
                                        <i class="bi bi-house-door"></i>
                                    </div>
                                    <div class="pb-requirement-text">
                                        <div class="pb-requirement-title">Foto Rumah Tampak Depan</div>
                                        <div class="pb-requirement-desc">Foto bagian depan rumah yang akan dipasang
                                            sambungan air</div>
                                    </div>
                                </li>

                                <li class="pb-requirement-item" data-aos="fade-right" data-aos-delay="300">
                                    <div class="pb-requirement-icon">
                                        <i class="bi bi-geo-alt"></i>
                                    </div>
                                    <div class="pb-requirement-text">
                                        <div class="pb-requirement-title">Alamat Lengkap</div>
                                        <div class="pb-requirement-desc">Alamat lengkap beserta koordinat GPS lokasi
                                            pemasangan</div>
                                    </div>
                                </li>

                                <li class="pb-requirement-item" data-aos="fade-right" data-aos-delay="400">
                                    <div class="pb-requirement-icon">
                                        <i class="bi bi-phone"></i>
                                    </div>
                                    <div class="pb-requirement-text">
                                        <div class="pb-requirement-title">Nomor Telepon/WhatsApp Aktif</div>
                                        <div class="pb-requirement-desc">Nomor yang dapat dihubungi untuk konfirmasi dan
                                            informasi lebih lanjut</div>
                                    </div>
                                </li>
                            </ul>

                            <div class="pb-info-box" data-aos="fade-up" data-aos-delay="500">
                                <div class="pb-info-box-header">
                                    <div class="pb-info-icon">
                                        <i class="bi bi-cash-coin"></i>
                                    </div>
                                    <h4 class="pb-info-title">Biaya Administrasi</h4>
                                </div>
                                <p class="pb-info-text">
                                    Calon pelanggan dikenakan biaya administrasi pendaftaran sebesar <strong>Rp
                                        20.000</strong>. Biaya ini sudah termasuk proses verifikasi dan survei lokasi.
                                </p>
                            </div>
                        </div>

                        <!-- Step 2: Upload Documents -->
                        <div class="pb-form-section" data-section="2">
                            <h3 class="pb-section-title">
                                <i class="bi bi-cloud-upload"></i>
                                Upload Dokumen Persyaratan
                            </h3>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="pb-form-group">
                                        <label class="pb-form-label">
                                            Foto KTP <span class="required">*</span>
                                        </label>
                                        <div class="pb-upload-area" id="ktpUploadArea">
                                            <input type="file" name="foto_ktp" id="foto_ktp" class="pb-file-input"
                                                accept="image/*" required>
                                            <div class="pb-upload-icon">
                                                <i class="bi bi-card-image"></i>
                                            </div>
                                            <div class="pb-upload-text">Klik atau seret file KTP</div>
                                            <div class="pb-upload-hint">Format: JPG, PNG (Max: 5MB)</div>
                                            <div class="pb-file-name d-none" id="ktpFileName">
                                                <i class="bi bi-check-circle-fill"></i>
                                                <span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="pb-form-group">
                                        <label class="pb-form-label">
                                            Foto Rumah <span class="required">*</span>
                                        </label>
                                        <div class="pb-upload-area" id="rumahUploadArea">
                                            <input type="file" name="foto_rumah" id="foto_rumah" class="pb-file-input"
                                                accept="image/*" required>
                                            <div class="pb-upload-icon">
                                                <i class="bi bi-house-door"></i>
                                            </div>
                                            <div class="pb-upload-text">Klik atau seret foto rumah</div>
                                            <div class="pb-upload-hint">Format: JPG, PNG (Max: 5MB)</div>
                                            <div class="pb-file-name d-none" id="rumahFileName">
                                                <i class="bi bi-check-circle-fill"></i>
                                                <span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pb-info-box">
                                <div class="pb-info-box-header">
                                    <div class="pb-info-icon">
                                        <i class="bi bi-info-circle"></i>
                                    </div>
                                    <h4 class="pb-info-title">Tips Upload Dokumen</h4>
                                </div>
                                <p class="pb-info-text">
                                    • Pastikan foto terlihat jelas dan tidak blur<br>
                                    • Hindari pantulan cahaya yang berlebihan<br>
                                    • Gunakan pencahayaan yang cukup<br>
                                    • Pastikan seluruh area dokumen/rumah terlihat
                                </p>
                            </div>
                        </div>

                        <!-- Step 3: Location Data -->
                        <div class="pb-form-section" data-section="3">
                            <h3 class="pb-section-title">
                                <i class="bi bi-geo-alt"></i>
                                Data Lokasi Pemasangan
                            </h3>

                            <div class="pb-form-group">
                                <label class="pb-form-label">
                                    Alamat Lengkap <span class="required">*</span>
                                </label>
                                <textarea name="alamat" id="alamat" class="pb-form-control" rows="4"
                                    placeholder="Masukkan alamat lengkap lokasi pemasangan..." required></textarea>

                                <input type="hidden" name="latitude" id="lat">
                                <input type="hidden" name="longitude" id="long">

                                <button type="button" class="pb-location-btn" onclick="getLocation()">
                                    <i class="bi bi-crosshair"></i>
                                    Dapatkan Lokasi Saya
                                </button>

                                <div class="pb-spinner" id="spinner">
                                    <i class="bi bi-arrow-repeat"></i>
                                    <span>Mendapatkan lokasi...</span>
                                </div>
                            </div>

                            <div class="pb-form-group">
                                <label class="pb-form-label">
                                    Nomor Telepon/WhatsApp <span class="required">*</span>
                                </label>
                                <input type="tel" name="no_hp" id="no_hp" class="pb-form-control"
                                    placeholder="Contoh: 081234567890" required>
                            </div>

                            <div class="pb-info-box">
                                <div class="pb-info-box-header">
                                    <div class="pb-info-icon">
                                        <i class="bi bi-shield-check"></i>
                                    </div>
                                    <h4 class="pb-info-title">Privasi & Keamanan Data</h4>
                                </div>
                                <p class="pb-info-text">
                                    Data lokasi Anda akan digunakan hanya untuk keperluan survei dan pemasangan
                                    sambungan air.
                                    Kami menjaga kerahasiaan dan keamanan data pribadi Anda sesuai dengan peraturan yang
                                    berlaku.
                                </p>
                            </div>
                        </div>

                        <!-- Step 4: Confirmation -->
                        <div class="pb-form-section" data-section="4">
                            <h3 class="pb-section-title">
                                <i class="bi bi-check-circle"></i>
                                Konfirmasi & Persetujuan
                            </h3>

                            <div class="pb-agreement-box">
                                <h4 class="pb-agreement-title">
                                    <i class="bi bi-exclamation-triangle"></i>
                                    Syarat & Ketentuan
                                </h4>

                                <div class="pb-agreement-content">
                                    <div class="pb-agreement-text">
                                        <strong>1. Biaya Administrasi</strong><br>
                                        Saya menyetujui untuk membayar biaya administrasi pendaftaran sebesar Rp 20.000
                                        (Dua Puluh Ribu Rupiah).<br><br>

                                        <strong>2. Verifikasi Data</strong><br>
                                        Saya menjamin bahwa seluruh data dan dokumen yang saya berikan adalah benar dan
                                        sah. Jika ditemukan pemalsuan data, PERUMDA Muara Tirta berhak membatalkan
                                        permohonan tanpa pengembalian biaya.<br><br>

                                        <strong>3. Survei Lokasi</strong><br>
                                        Saya menyetujui untuk dilakukan survei lokasi oleh petugas PERUMDA untuk
                                        memastikan kelayakan pemasangan sambungan air.<br><br>

                                        <strong>4. Waktu Proses</strong><br>
                                        Proses verifikasi dan survei akan dilakukan maksimal 7 hari kerja setelah
                                        pendaftaran. Pemasangan akan dijadwalkan setelah survei selesai dan
                                        disetujui.<br><br>

                                        <strong>5. Pembayaran</strong><br>
                                        Biaya pemasangan dan deposit akan diinformasikan setelah survei selesai dan
                                        harus dibayarkan sebelum proses pemasangan dimulai.<br><br>

                                        <strong>6. Kontak</strong><br>
                                        Saya bersedia dihubungi melalui nomor telepon/WhatsApp yang telah saya berikan
                                        untuk keperluan konfirmasi dan penjadwalan.
                                    </div>
                                </div>

                                <div class="pb-checkbox-wrapper">
                                    <input type="checkbox" id="biaya_regist" class="pb-checkbox">
                                    <label for="biaya_regist" class="pb-checkbox-label">
                                        Saya telah membaca dan menyetujui semua syarat & ketentuan di atas
                                    </label>
                                </div>
                            </div>

                            <div class="pb-info-box">
                                <div class="pb-info-box-header">
                                    <div class="pb-info-icon">
                                        <i class="bi bi-telephone"></i>
                                    </div>
                                    <h4 class="pb-info-title">Butuh Bantuan?</h4>
                                </div>
                                <p class="pb-info-text">
                                    Jika ada pertanyaan atau memerlukan bantuan, silakan hubungi Customer Service kami
                                    di:<br>
                                    <strong>WA: 0812-4469-7154</strong> atau <strong>Telp: (0435) 821234</strong>
                                </p>
                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="pb-button-group">
                            <button type="button" class="pb-btn pb-btn-secondary" id="prevBtn" style="display: none;">
                                <i class="bi bi-arrow-left"></i>
                                Sebelumnya
                            </button>

                            <button type="button" class="pb-btn pb-btn-primary" id="nextBtn">
                                Selanjutnya
                                <i class="bi bi-arrow-right"></i>
                            </button>

                            <button type="submit" name="daftar-baru" id="submitBtn" class="pb-btn pb-btn-primary"
                                style="display: none;" disabled>
                                <i class="bi bi-send"></i>
                                Kirim Pendaftaran
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </section>
    </main>

    <!-- Confirmation Modal -->
    <div class="pb-modal" id="confirmModal">
        <div class="pb-modal-content">
            <div class="pb-modal-icon">
                <i class="bi bi-info-circle"></i>
            </div>
            <h3 class="pb-modal-title">Konfirmasi Persetujuan</h3>
            <p class="pb-modal-text">
                Calon pelanggan dikenakan biaya administrasi sebesar:
            </p>
            <div class="pb-modal-price">Rp 20.000</div>

            <div class="pb-checkbox-wrapper" style="margin-bottom: 24px;">
                <input type="checkbox" id="sy_setuju" class="pb-checkbox">
                <label for="sy_setuju" class="pb-checkbox-label">
                    Saya Setuju
                </label>
            </div>

            <button type="button" id="confirm" class="pb-btn pb-btn-primary"
                style="width: 100%; justify-content: center;" disabled>
                <i class="bi bi-check-circle"></i>
                Konfirmasi
            </button>
        </div>
    </div>

    <?php include(ROOT_PATH . '/include/footer.php'); ?>

    <a href="#" class="scroll-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <div id="preloader"></div>

    <?php include(ROOT_PATH . '/include/scripts.php'); ?>

    <script>
    // Multi-step Form Logic
    let currentStep = 1;
    const totalSteps = 4;

    function showStep(step) {
        // Hide all sections
        document.querySelectorAll('.pb-form-section').forEach(section => {
            section.classList.remove('active');
        });

        // Show current section
        document.querySelector(`[data-section="${step}"]`).classList.add('active');

        // Update step indicators
        document.querySelectorAll('.pb-step').forEach(stepEl => {
            const stepNum = parseInt(stepEl.dataset.step);
            stepEl.classList.remove('active', 'completed');

            if (stepNum === step) {
                stepEl.classList.add('active');
            } else if (stepNum < step) {
                stepEl.classList.add('completed');
            }
        });

        // Update progress bar
        const progress = ((step - 1) / (totalSteps - 1)) * 80;
        document.getElementById('stepProgress').style.width = progress + '%';

        // Update buttons
        document.getElementById('prevBtn').style.display = step === 1 ? 'none' : 'inline-flex';
        document.getElementById('nextBtn').style.display = step === totalSteps ? 'none' : 'inline-flex';
        document.getElementById('submitBtn').style.display = step === totalSteps ? 'inline-flex' : 'none';

        // Scroll to top
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    // Navigation
    document.getElementById('nextBtn').addEventListener('click', function() {
        if (validateStep(currentStep)) {
            currentStep++;
            showStep(currentStep);
        }
    });

    document.getElementById('prevBtn').addEventListener('click', function() {
        currentStep--;
        showStep(currentStep);
    });

    // Validation
    function validateStep(step) {
        if (step === 2) {
            const ktp = document.getElementById('foto_ktp').files[0];
            const rumah = document.getElementById('foto_rumah').files[0];

            if (!ktp || !rumah) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Dokumen Belum Lengkap',
                    text: 'Mohon upload foto KTP dan foto rumah terlebih dahulu',
                });
                return false;
            }
        }

        if (step === 3) {
            const alamat = document.getElementById('alamat').value;
            const noHp = document.getElementById('no_hp').value;

            if (!alamat || !noHp) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Belum Lengkap',
                    text: 'Mohon lengkapi alamat dan nomor telepon',
                });
                return false;
            }

            if (noHp.length < 10) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Nomor Tidak Valid',
                    text: 'Nomor telepon minimal 10 digit',
                });
                return false;
            }
        }

        return true;
    }

    // File Upload Handling
    document.getElementById('foto_ktp').addEventListener('change', function(e) {
        handleFileUpload(e.target, 'ktpUploadArea', 'ktpFileName');
    });

    document.getElementById('foto_rumah').addEventListener('change', function(e) {
        handleFileUpload(e.target, 'rumahUploadArea', 'rumahFileName');
    });

    function handleFileUpload(input, areaId, fileNameId) {
        const file = input.files[0];
        const area = document.getElementById(areaId);
        const fileName = document.getElementById(fileNameId);

        if (file) {
            if (file.size > 5 * 1024 * 1024) {
                Swal.fire({
                    icon: 'error',
                    title: 'File Terlalu Besar',
                    text: 'Ukuran file maksimal 5MB',
                });
                input.value = '';
                return;
            }

            area.classList.add('has-file');
            fileName.classList.remove('d-none');
            fileName.querySelector('span').textContent = file.name;
        } else {
            area.classList.remove('has-file');
            fileName.classList.add('d-none');
        }
    }

    // Checkbox Agreement
    document.getElementById('biaya_regist').addEventListener('change', function() {
        if (this.checked) {
            document.getElementById('confirmModal').classList.add('active');
        } else {
            document.getElementById('submitBtn').disabled = true;
        }
    });

    document.getElementById('sy_setuju').addEventListener('change', function() {
        document.getElementById('confirm').disabled = !this.checked;
    });

    document.getElementById('confirm').addEventListener('click', function() {
        document.getElementById('confirmModal').classList.remove('active');
        document.getElementById('submitBtn').disabled = false;

        Swal.fire({
            icon: 'success',
            title: 'Persetujuan Dikonfirmasi',
            text: 'Anda dapat melanjutkan untuk mengirim pendaftaran',
            timer: 2000,
            showConfirmButton: false
        });
    });

    // Geolocation
    function getLocation() {
        const spinner = document.getElementById('spinner');

        if (navigator.geolocation) {
            spinner.classList.add('active');

            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const lat = position.coords.latitude;
                    const long = position.coords.longitude;

                    document.getElementById('lat').value = lat;
                    document.getElementById('long').value = long;

                    sendCoordinates(lat, long);
                },
                function(error) {
                    spinner.classList.remove('active');

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Mendapatkan Lokasi',
                        text: 'Mohon aktifkan GPS atau masukkan alamat secara manual',
                    });
                }, {
                    enableHighAccuracy: true,
                    timeout: 20000,
                    maximumAge: 0
                }
            );
        } else {
            Swal.fire({
                icon: 'error',
                title: 'GPS Tidak Didukung',
                text: 'Browser Anda tidak mendukung geolocation. Mohon masukkan alamat secara manual',
            });
        }
    }

    function sendCoordinates(lat, long) {
        $.ajax({
            type: 'GET',
            url: 'reverse_geocode.php',
            data: {
                lat: lat,
                long: long
            },
            success: function(response) {
                $('#alamat').val(response);
                $('#spinner').removeClass('active');

                Swal.fire({
                    icon: 'success',
                    title: 'Lokasi Ditemukan',
                    text: 'Alamat berhasil diisi otomatis',
                    timer: 2000,
                    showConfirmButton: false
                });
            },
            error: function() {
                $('#spinner').removeClass('active');

                Swal.fire({
                    icon: 'warning',
                    title: 'Gagal Mendapatkan Alamat',
                    text: 'Koordinat berhasil didapat, mohon lengkapi alamat secara manual',
                });
            }
        });
    }

    // Session Messages
    <?php if (isset($_SESSION['messages']) && isset($_SESSION['type'])) : ?>
    Swal.fire({
        icon: '<?php echo $_SESSION['type'] ?>',
        title: '<?php echo $_SESSION['title'] ?>',
        text: '<?php echo $_SESSION['messages'] ?>',
    });
    <?php
            unset($_SESSION['messages']);
            unset($_SESSION['type']);
            unset($_SESSION['title']);
            ?>
    <?php endif; ?>

    // Initialize
    showStep(1);
    </script>

    <?php include(ROOT_PATH . '/include/msgErr.php') ?>
</body>

</html>