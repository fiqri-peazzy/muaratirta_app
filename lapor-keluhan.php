<?php
include("path.php");
include(ROOT_PATH . '/app/controllers/users.php');
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Lapor Keluhan | Muara Tirta Kota Gorontalo</title>
    <meta content="Laporkan keluhan atau gangguan pelayanan air PDAM Muara Tirta secara online" name="description">
    <meta content="lapor keluhan, pengaduan, gangguan air, pdam gorontalo" name="keywords">

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
       LAPOR KELUHAN - MODERN STYLES
       ======================================== */

    :root {
        --lk-primary: #0D6EFD;
        --lk-primary-dark: #0B5ED7;
        --lk-secondary: #0DCAF0;
        --lk-success: #198754;
        --lk-warning: #FFC107;
        --lk-danger: #DC3545;
        --lk-dark: #1a2332;
        --lk-light: #F8F9FA;
        --lk-white: #FFFFFF;
        --lk-text: #2C3E50;
        --lk-muted: #6C757D;
        --lk-shadow-sm: 0 2px 12px rgba(13, 110, 253, 0.1);
        --lk-shadow-md: 0 4px 20px rgba(13, 110, 253, 0.15);
        --lk-shadow-lg: 0 8px 32px rgba(13, 110, 253, 0.2);
        --lk-radius: 20px;
        --lk-transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Header Banner */
    .lk-header-banner {
        background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%);
        border-radius: var(--lk-radius);
        padding: 60px 40px;
        margin-bottom: 40px;
        position: relative;
        overflow: hidden;
        box-shadow: var(--lk-shadow-md);
    }

    .lk-header-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, transparent 70%);
        animation: lk-rotate 20s linear infinite;
    }

    @keyframes lk-rotate {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    .lk-header-content {
        display: flex;
        align-items: center;
        gap: 40px;
        position: relative;
        z-index: 1;
    }

    .lk-animation-box {
        width: 200px;
        height: 200px;
        flex-shrink: 0;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: var(--lk-shadow-md);
    }

    .lk-header-text {
        flex: 1;
    }

    .lk-badge {
        display: inline-block;
        padding: 8px 20px;
        background: rgba(220, 53, 69, 0.15);
        color: var(--lk-danger);
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 16px;
    }

    .lk-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--lk-text);
        margin-bottom: 12px;
        line-height: 1.2;
    }

    .lk-subtitle {
        font-size: 1.125rem;
        color: var(--lk-muted);
        line-height: 1.6;
    }

    /* Main Content Layout */
    .lk-content-wrapper {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        margin-bottom: 60px;
    }

    /* Form Card */
    .lk-form-card {
        background: white;
        border-radius: var(--lk-radius);
        padding: 40px;
        box-shadow: var(--lk-shadow-md);
        height: fit-content;
    }

    .lk-form-header {
        margin-bottom: 32px;
        padding-bottom: 24px;
        border-bottom: 3px solid var(--lk-light);
    }

    .lk-form-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--lk-text);
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .lk-form-title i {
        color: var(--lk-primary);
        font-size: 2rem;
    }

    .lk-form-subtitle {
        font-size: 1rem;
        color: var(--lk-muted);
    }

    /* Form Groups */
    .lk-form-group {
        margin-bottom: 24px;
    }

    .lk-form-label {
        display: block;
        font-size: 0.9375rem;
        font-weight: 700;
        color: var(--lk-text);
        margin-bottom: 8px;
    }

    .lk-form-label .required {
        color: var(--lk-danger);
        margin-left: 4px;
    }

    .lk-form-control {
        width: 100%;
        padding: 14px 20px;
        border: 2px solid #E0E0E0;
        border-radius: 12px;
        font-size: 1rem;
        color: var(--lk-text);
        transition: var(--lk-transition);
        background: white;
    }

    .lk-form-control:focus {
        outline: none;
        border-color: var(--lk-primary);
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
    }

    textarea.lk-form-control {
        min-height: 150px;
        resize: vertical;
    }

    /* File Upload */
    .lk-upload-area {
        border: 3px dashed #E0E0E0;
        border-radius: 12px;
        padding: 32px;
        text-align: center;
        background: var(--lk-light);
        cursor: pointer;
        transition: var(--lk-transition);
        position: relative;
    }

    .lk-upload-area:hover {
        border-color: var(--lk-primary);
        background: #E3F2FD;
    }

    .lk-upload-area.has-file {
        border-color: var(--lk-success);
        background: #E8F5E9;
    }

    .lk-upload-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--lk-primary) 0%, var(--lk-secondary) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        color: white;
        font-size: 2rem;
    }

    .lk-upload-area.has-file .lk-upload-icon {
        background: var(--lk-success);
    }

    .lk-upload-text {
        font-size: 1rem;
        font-weight: 600;
        color: var(--lk-text);
        margin-bottom: 8px;
    }

    .lk-upload-hint {
        font-size: 0.875rem;
        color: var(--lk-muted);
    }

    .lk-file-input {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        cursor: pointer;
    }

    .lk-file-name {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: white;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--lk-success);
        margin-top: 12px;
    }

    /* Submit Button */
    .lk-btn-submit {
        width: 100%;
        padding: 16px 32px;
        background: linear-gradient(135deg, var(--lk-primary) 0%, var(--lk-secondary) 100%);
        color: white;
        border: none;
        border-radius: 50px;
        font-size: 1.125rem;
        font-weight: 700;
        cursor: pointer;
        transition: var(--lk-transition);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
    }

    .lk-btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(13, 110, 253, 0.4);
    }

    .lk-btn-submit i {
        font-size: 1.25rem;
    }

    /* Contact Section */
    .lk-contact-section {
        position: sticky;
        top: 100px;
    }

    .lk-contact-intro {
        background: white;
        border-radius: var(--lk-radius);
        padding: 32px;
        margin-bottom: 24px;
        box-shadow: var(--lk-shadow-sm);
    }

    .lk-contact-title {
        font-size: 1.375rem;
        font-weight: 800;
        color: var(--lk-text);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .lk-contact-title i {
        color: var(--lk-primary);
        font-size: 1.75rem;
    }

    .lk-contact-text {
        font-size: 1rem;
        color: var(--lk-muted);
        line-height: 1.6;
    }

    /* Contact Cards */
    .lk-contact-cards {
        display: grid;
        gap: 20px;
    }

    .lk-contact-card {
        background: white;
        border-radius: var(--lk-radius);
        padding: 32px;
        text-align: center;
        box-shadow: var(--lk-shadow-sm);
        transition: var(--lk-transition);
        border: 2px solid transparent;
    }

    .lk-contact-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--lk-shadow-lg);
        border-color: var(--lk-primary);
    }

    .lk-contact-icon {
        width: 100px;
        height: 100px;
        margin: 0 auto 24px;
        background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--lk-transition);
    }

    .lk-contact-card:hover .lk-contact-icon {
        background: linear-gradient(135deg, var(--lk-primary) 0%, var(--lk-secondary) 100%);
        transform: scale(1.1) rotate(5deg);
    }

    .lk-contact-icon img {
        width: 60px;
        height: 60px;
        object-fit: contain;
        transition: var(--lk-transition);
    }

    .lk-contact-card:hover .lk-contact-icon img {
        /*filter: brightness(0) invert(1);*/
    }

    .lk-contact-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--lk-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .lk-contact-value {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--lk-text);
        margin-bottom: 20px;
    }

    .lk-contact-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 32px;
        background: linear-gradient(135deg, var(--lk-primary) 0%, var(--lk-secondary) 100%);
        color: white;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 700;
        font-size: 1rem;
        transition: var(--lk-transition);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    }

    .lk-contact-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(13, 110, 253, 0.4);
        color: white;
    }

    .lk-contact-btn.whatsapp {
        background: linear-gradient(135deg, #25D366 0%, #20BA5A 100%);
        box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
    }

    .lk-contact-btn.whatsapp:hover {
        box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4);
    }

    .lk-contact-btn i {
        font-size: 1.25rem;
    }

    /* Info Box */
    .lk-info-box {
        background: linear-gradient(135deg, #FFF3CD 0%, #FFE69C 100%);
        border-left: 5px solid var(--lk-warning);
        border-radius: 12px;
        padding: 24px;
        margin-top: 24px;
        box-shadow: var(--lk-shadow-sm);
    }

    .lk-info-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }

    .lk-info-icon {
        width: 40px;
        height: 40px;
        background: var(--lk-warning);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
    }

    .lk-info-title {
        font-size: 1rem;
        font-weight: 700;
        color: #856404;
        margin: 0;
    }

    .lk-info-text {
        font-size: 0.9375rem;
        color: #856404;
        line-height: 1.6;
        margin: 0;
    }

    /* FAQ Section */
    .lk-faq-section {
        background: white;
        border-radius: var(--lk-radius);
        padding: 40px;
        margin-top: 60px;
        box-shadow: var(--lk-shadow-md);
    }

    .lk-faq-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .lk-faq-title {
        font-size: 2rem;
        font-weight: 800;
        color: var(--lk-text);
        margin-bottom: 12px;
    }

    .lk-faq-subtitle {
        font-size: 1rem;
        color: var(--lk-muted);
    }

    .lk-faq-list {
        display: grid;
        gap: 16px;
        max-width: 900px;
        margin: 0 auto;
    }

    .lk-faq-item {
        border: 2px solid var(--lk-light);
        border-radius: 12px;
        overflow: hidden;
        transition: var(--lk-transition);
    }

    .lk-faq-item:hover {
        border-color: var(--lk-primary);
    }

    .lk-faq-question {
        padding: 20px 24px;
        background: var(--lk-light);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        transition: var(--lk-transition);
    }

    .lk-faq-question:hover {
        background: #E3F2FD;
    }

    .lk-faq-question-text {
        font-size: 1.0625rem;
        font-weight: 700;
        color: var(--lk-text);
        margin: 0;
    }

    .lk-faq-icon {
        width: 32px;
        height: 32px;
        background: var(--lk-primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1rem;
        transition: var(--lk-transition);
        flex-shrink: 0;
    }

    .lk-faq-item.active .lk-faq-icon {
        transform: rotate(180deg);
    }

    .lk-faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease;
    }

    .lk-faq-item.active .lk-faq-answer {
        max-height: 500px;
    }

    .lk-faq-answer-content {
        padding: 24px;
        background: white;
        font-size: 1rem;
        color: var(--lk-muted);
        line-height: 1.8;
    }

    /* Success Modal */
    .lk-success-modal {
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

    .lk-success-modal.active {
        display: flex;
        animation: lk-fadeIn 0.3s ease;
    }

    @keyframes lk-fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .lk-success-content {
        background: white;
        border-radius: var(--lk-radius);
        max-width: 500px;
        width: 90%;
        padding: 60px 40px;
        text-align: center;
        position: relative;
        animation: lk-scaleIn 0.3s ease;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    }

    @keyframes lk-scaleIn {
        from {
            transform: scale(0.9);
            opacity: 0;
        }

        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    .lk-success-icon {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, var(--lk-success) 0%, #20BA5A 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
        color: white;
        font-size: 4rem;
        animation: lk-checkmark 0.6s ease 0.3s both;
    }

    @keyframes lk-checkmark {
        0% {
            transform: scale(0);
        }

        50% {
            transform: scale(1.2);
        }

        100% {
            transform: scale(1);
        }
    }

    .lk-success-title {
        font-size: 2rem;
        font-weight: 800;
        color: var(--lk-text);
        margin-bottom: 16px;
    }

    .lk-success-text {
        font-size: 1.125rem;
        color: var(--lk-muted);
        line-height: 1.6;
        margin-bottom: 32px;
    }

    .lk-success-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 14px 32px;
        background: linear-gradient(135deg, var(--lk-primary) 0%, var(--lk-secondary) 100%);
        color: white;
        border: none;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: var(--lk-transition);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    }

    .lk-success-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(13, 110, 253, 0.4);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .lk-content-wrapper {
            grid-template-columns: 1fr;
        }

        .lk-contact-section {
            position: static;
        }
    }

    @media (max-width: 768px) {
        .lk-header-content {
            flex-direction: column;
            text-align: center;
        }

        .lk-animation-box {
            width: 160px;
            height: 160px;
        }

        .lk-title {
            font-size: 2rem;
        }

        .lk-form-card,
        .lk-contact-intro,
        .lk-faq-section {
            padding: 24px 20px;
        }
    }

    @media (max-width: 576px) {
        .lk-header-banner {
            padding: 40px 24px;
        }

        .lk-title {
            font-size: 1.75rem;
        }

        .lk-animation-box {
            width: 140px;
            height: 140px;
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
                <h2>LAPOR KELUHAN</h2>
                <ol>
                    <li><a href="<?= BASE_URL . '/index' ?>">Beranda</a></li>
                    <li>Lapor Keluhan</li>
                </ol>
            </div>
        </div>

        <?php include(ROOT_PATH . '/include/webticker.php') ?>

        <!-- Main Content -->
        <section id="about" class="about section-bg">
            <div class="container" data-aos="fade-up">

                <!-- Header with Animation -->
                <div class="lk-header-banner" data-aos="zoom-in">
                    <div class="lk-header-content">
                        <div class="lk-animation-box">
                            <script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.8.5/dist/dotlottie-wc.js"
                                type="module"></script>
                            <dotlottie-wc
                                src="https://lottie.host/e20386d5-f932-4265-91b0-001770e7b3d0/aKBuPw0vYQ.lottie"
                                style="width: 100%;height: 100%" autoplay loop></dotlottie-wc>
                        </div>
                        <div class="lk-header-text">
                            <span class="lk-badge">
                                <i class="bi bi-megaphone me-2"></i>
                                Pengaduan Online
                            </span>
                            <h1 class="lk-title">Laporkan Keluhan Anda</h1>
                            <p class="lk-subtitle">
                                Kami siap membantu menyelesaikan setiap keluhan dan gangguan pelayanan air Anda.
                                Laporkan masalah Anda secara online untuk respons yang lebih cepat.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Content Grid -->
                <div class="lk-content-wrapper">

                    <!-- Form Section -->
                    <div class="lk-form-wrapper" data-aos="fade-right">
                        <div class="lk-form-card">
                            <div class="lk-form-header">
                                <h3 class="lk-form-title">
                                    <i class="bi bi-file-earmark-text"></i>
                                    Form Pengaduan
                                </h3>
                                <p class="lk-form-subtitle">Lengkapi formulir di bawah ini dengan detail keluhan Anda
                                </p>
                            </div>

                            <form method="post" enctype="multipart/form-data" id="keluhanForm">
                                <div class="lk-form-group">
                                    <label class="lk-form-label">
                                        ID Pelanggan
                                        <span class="required">*</span>
                                    </label>
                                    <input type="text" name="id_pel" class="lk-form-control"
                                        placeholder="Masukkan ID Pelanggan Anda" required maxlength="7">
                                </div>

                                <div class="lk-form-group">
                                    <label class="lk-form-label">
                                        Nama Lengkap
                                        <span class="required">*</span>
                                    </label>
                                    <input type="text" name="nm_lengkap" class="lk-form-control"
                                        placeholder="Masukkan nama lengkap Anda" required>
                                </div>

                                <div class="lk-form-group">
                                    <label class="lk-form-label">
                                        Alamat
                                        <span class="required">*</span>
                                    </label>
                                    <input type="text" name="alamat" class="lk-form-control"
                                        placeholder="Masukkan alamat lengkap" required>
                                </div>

                                <div class="lk-form-group">
                                    <label class="lk-form-label">
                                        No. HP / WhatsApp
                                        <span class="required">*</span>
                                    </label>
                                    <input type="tel" name="no_hp" class="lk-form-control" placeholder="08xxxxxxxxxx"
                                        required pattern="[0-9]{10,13}">
                                </div>
                                <div class="lk-form-group">
                                    <label class="lk-form-label">
                                        Isi Pengaduan
                                        <span class="required">*</span>
                                    </label>
                                    <textarea name="isi_pengaduan" class="lk-form-control"
                                        placeholder="Jelaskan keluhan Anda secara detail..." required></textarea>
                                </div>

                                <div class="lk-form-group">
                                    <label class="lk-form-label">
                                        Upload Foto (Opsional)
                                    </label>
                                    <div class="lk-upload-area" id="uploadArea">
                                        <div class="lk-upload-icon">
                                            <i class="bi bi-cloud-upload"></i>
                                        </div>
                                        <div class="lk-upload-text">Klik atau seret foto ke sini</div>
                                        <div class="lk-upload-hint">Format: JPG, PNG, JPEG (Max 2MB)</div>
                                        <input type="file" name="foto" class="lk-file-input" id="fotoInput"
                                            accept="image/jpeg,image/jpg,image/png">
                                        <div class="lk-file-name" id="fileName" style="display:none;">
                                            <i class="bi bi-check-circle"></i>
                                            <span id="fileNameText"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="lk-info-box">
                                    <div class="lk-info-header">
                                        <div class="lk-info-icon">
                                            <i class="bi bi-info-circle"></i>
                                        </div>
                                        <h5 class="lk-info-title">Catatan Penting</h5>
                                    </div>
                                    <p class="lk-info-text">
                                        Pastikan informasi yang Anda berikan akurat dan lengkap untuk mempercepat proses
                                        penanganan keluhan.
                                    </p>
                                </div>

                                <button type="submit" name="submit-keluhan" class="lk-btn-submit">
                                    <i class="bi bi-send-fill"></i>
                                    Kirim Pengaduan
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Contact Section -->
                    <div class="lk-contact-section" data-aos="fade-left">
                        <div class="lk-contact-intro">
                            <h3 class="lk-contact-title">
                                <i class="bi bi-headset"></i>
                                Hubungi Kami
                            </h3>
                            <p class="lk-contact-text">
                                Untuk informasi lebih lanjut atau bantuan langsung, silahkan hubungi kami melalui:
                            </p>
                        </div>

                        <div class="lk-contact-cards">
                            <div class="lk-contact-card" data-aos="zoom-in" data-aos-delay="100">
                                <div class="lk-contact-icon">
                                    <img src="<?= BASE_URL . '/assets/image/email.png' ?>" alt="Email">
                                </div>
                                <div class="lk-contact-label">Email Customer Service</div>
                                <div class="lk-contact-value">cs@muaratirta.co.id</div>
                                <a href="mailto:cs@muaratirta.co.id" class="lk-contact-btn">
                                    <i class="bi bi-envelope-fill"></i>
                                    Kirim Email
                                </a>
                            </div>

                            <div class="lk-contact-card" data-aos="zoom-in" data-aos-delay="200">
                                <div class="lk-contact-icon">
                                    <img src="<?= BASE_URL . '/assets/image/wa.png' ?>" alt="WhatsApp">
                                </div>
                                <div class="lk-contact-label">WhatsApp Customer Service</div>
                                <div class="lk-contact-value">+62 822-9275-4405</div>
                                <a href="https://wa.me/6282292754405" target="_blank" class="lk-contact-btn whatsapp">
                                    <i class="bi bi-whatsapp"></i>
                                    Chat WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Section -->
                <div class="lk-faq-section" data-aos="fade-up">
                    <div class="lk-faq-header">
                        <h2 class="lk-faq-title">Pertanyaan yang Sering Diajukan</h2>
                        <p class="lk-faq-subtitle">Temukan jawaban untuk pertanyaan umum seputar pengaduan</p>
                    </div>

                    <div class="lk-faq-list">
                        <div class="lk-faq-item" data-aos="fade-up" data-aos-delay="100">
                            <div class="lk-faq-question" onclick="toggleFaq(this)">
                                <h4 class="lk-faq-question-text">Berapa lama proses penanganan keluhan?</h4>
                                <div class="lk-faq-icon">
                                    <i class="bi bi-chevron-down"></i>
                                </div>
                            </div>
                            <div class="lk-faq-answer">
                                <div class="lk-faq-answer-content">
                                    Proses penanganan keluhan biasanya memakan waktu 1-3 hari kerja tergantung jenis dan
                                    kompleksitas masalah. Tim kami akan menghubungi Anda segera setelah keluhan diterima
                                    untuk memberikan update status.
                                </div>
                            </div>
                        </div>

                        <div class="lk-faq-item" data-aos="fade-up" data-aos-delay="200">
                            <div class="lk-faq-question" onclick="toggleFaq(this)">
                                <h4 class="lk-faq-question-text">Apakah saya bisa melacak status pengaduan saya?</h4>
                                <div class="lk-faq-icon">
                                    <i class="bi bi-chevron-down"></i>
                                </div>
                            </div>
                            <div class="lk-faq-answer">
                                <div class="lk-faq-answer-content">
                                    Ya, Anda akan menerima nomor tiket pengaduan setelah mengirimkan formulir. Anda
                                    dapat menghubungi customer service kami melalui WhatsApp atau email dengan
                                    menyertakan nomor tiket untuk mengecek status pengaduan.
                                </div>
                            </div>
                        </div>

                        <div class="lk-faq-item" data-aos="fade-up" data-aos-delay="300">
                            <div class="lk-faq-question" onclick="toggleFaq(this)">
                                <h4 class="lk-faq-question-text">Jenis keluhan apa saja yang bisa dilaporkan?</h4>
                                <div class="lk-faq-icon">
                                    <i class="bi bi-chevron-down"></i>
                                </div>
                            </div>
                            <div class="lk-faq-answer">
                                <div class="lk-faq-answer-content">
                                    Anda dapat melaporkan berbagai jenis keluhan seperti: air tidak mengalir, air keruh,
                                    kebocoran pipa, tagihan tidak sesuai, meter air rusak, dan masalah teknis lainnya
                                    terkait pelayanan air PDAM.
                                </div>
                            </div>
                        </div>

                        <div class="lk-faq-item" data-aos="fade-up" data-aos-delay="400">
                            <div class="lk-faq-question" onclick="toggleFaq(this)">
                                <h4 class="lk-faq-question-text">Apakah ada biaya untuk melaporkan keluhan?</h4>
                                <div class="lk-faq-icon">
                                    <i class="bi bi-chevron-down"></i>
                                </div>
                            </div>
                            <div class="lk-faq-answer">
                                <div class="lk-faq-answer-content">
                                    Tidak ada biaya untuk melaporkan keluhan. Layanan pengaduan kami sepenuhnya GRATIS.
                                    Namun, jika keluhan memerlukan perbaikan atau penggantian komponen, maka biaya akan
                                    diinformasikan terlebih dahulu sebelum pekerjaan dilakukan.
                                </div>
                            </div>
                        </div>

                        <div class="lk-faq-item" data-aos="fade-up" data-aos-delay="500">
                            <div class="lk-faq-question" onclick="toggleFaq(this)">
                                <h4 class="lk-faq-question-text">Bagaimana jika masalah sangat mendesak?</h4>
                                <div class="lk-faq-icon">
                                    <i class="bi bi-chevron-down"></i>
                                </div>
                            </div>
                            <div class="lk-faq-answer">
                                <div class="lk-faq-answer-content">
                                    Untuk masalah yang sangat mendesak seperti kebocoran besar atau tidak ada aliran air
                                    sama sekali, kami sarankan untuk segera menghubungi customer service kami melalui
                                    WhatsApp di +62 822-9275-4405 untuk penanganan lebih cepat.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </main>

    <!-- Success Modal -->
    <div class="lk-success-modal" id="successModal">
        <div class="lk-success-content">
            <div class="lk-success-icon">
                <i class="bi bi-check-lg"></i>
            </div>
            <h2 class="lk-success-title">Pengaduan Terkirim!</h2>
            <p class="lk-success-text">
                Terima kasih telah melaporkan keluhan Anda. Tim kami akan segera menindaklanjuti laporan Anda dalam
                waktu 1x24 jam.
            </p>
            <button class="lk-success-btn" onclick="closeSuccessModal()">
                <i class="bi bi-check-circle"></i>
                Tutup
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
    // File Upload Handler
    const fotoInput = document.getElementById('fotoInput');
    const uploadArea = document.getElementById('uploadArea');
    const fileName = document.getElementById('fileName');
    const fileNameText = document.getElementById('fileNameText');

    if (fotoInput) {
        fotoInput.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                const fileSize = file.size / 1024 / 1024; // in MB

                if (fileSize > 2) {
                    alert('Ukuran file terlalu besar! Maksimal 2MB');
                    this.value = '';
                    return;
                }

                uploadArea.classList.add('has-file');
                fileName.style.display = 'inline-flex';
                fileNameText.textContent = file.name;
            }
        });

        // Drag & Drop
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.style.borderColor = 'var(--lk-primary)';
            this.style.background = '#E3F2FD';
        });

        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            if (!this.classList.contains('has-file')) {
                this.style.borderColor = '#E0E0E0';
                this.style.background = 'var(--lk-light)';
            }
        });

        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fotoInput.files = files;
                fotoInput.dispatchEvent(new Event('change'));
            }
        });
    }

    // FAQ Toggle
    function toggleFaq(element) {
        const faqItem = element.parentElement;
        const isActive = faqItem.classList.contains('active');

        // Close all other FAQs
        document.querySelectorAll('.lk-faq-item').forEach(item => {
            item.classList.remove('active');
        });

        // Toggle current FAQ
        if (!isActive) {
            faqItem.classList.add('active');
        }
    }

    // Form Validation
    const keluhanForm = document.getElementById('keluhanForm');
    if (keluhanForm) {
        keluhanForm.addEventListener('submit', function(e) {
            const idPel = this.querySelector('input[name="id_pel"]').value;
            const noHp = this.querySelector('input[name="no_hp"]').value;

            // Validate ID Pelanggan (should be numeric)
            if (!/^\d+$/.test(idPel)) {
                e.preventDefault();
                alert('ID Pelanggan harus berupa angka!');
                return false;
            }

            // Validate phone number
            if (!/^[0-9]{10,13}$/.test(noHp)) {
                e.preventDefault();
                alert('Nomor HP harus 10-13 digit angka!');
                return false;
            }
        });
    }

    // Success Modal
    function closeSuccessModal() {
        document.getElementById('successModal').classList.remove('active');
        window.location.href = '<?= BASE_URL ?>/lapor-keluhan';
    }

    // SweetAlert Handler
    <?php if (isset($_SESSION['messages']) && isset($_SESSION['type'])) : ?>
    var pesan = '<?php echo $_SESSION['messages'] ?>';
    var type = '<?php echo $_SESSION['type'] ?>';

    if (type === 'success') {
        // Show custom success modal
        setTimeout(function() {
            document.getElementById('successModal').classList.add('active');
        }, 500);
    } else {
        swal({
            title: type === 'error' ? 'Gagal' : 'Pemberitahuan',
            text: pesan,
            type: type,
        });
    }

    <?php
            unset($_SESSION['messages']);
            unset($_SESSION['type']);
            ?>
    <?php endif; ?>

    // Smooth scroll to form on error
    <?php if (isset($_SESSION['errors'])) : ?>
    setTimeout(function() {
        document.querySelector('.lk-form-card').scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
    }, 300);
    <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>
    </script>

    <?php include(ROOT_PATH . '/include/msgErr.php') ?>
</body>

</html>