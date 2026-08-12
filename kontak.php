<?php
include("path.php");
include(ROOT_PATH . '/app/controllers/users.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Kontak Muaratirta | Muaratirta Kota Gorontalo</title>
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
    /* Contact Page Enhanced Styles - Prefix: ct- */
    .ct-enhanced-section {
        padding: 60px 0;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    }

    /* Header Section */
    .ct-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .ct-lottie-wrapper {
        display: flex;
        justify-content: center;
        margin-bottom: 30px;
    }

    .ct-title {
        font-size: 32px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 12px;
    }

    .ct-subtitle {
        color: #666;
        font-size: 16px;
    }

    /* Contact Cards Grid */
    .ct-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 24px;
        margin-bottom: 40px;
    }

    .ct-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 32px 24px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(0, 123, 255, 0.08);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .ct-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 16px 40px rgba(0, 123, 255, 0.12);
        border-color: #007bff;
    }

    /* Icon Styles with Modern SVG */
    .ct-icon-wrapper {
        width: 80px;
        height: 80px;
        margin: 0 auto 24px;
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 20px rgba(0, 123, 255, 0.25);
        transition: all 0.3s ease;
    }

    .ct-card:hover .ct-icon-wrapper {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 12px 28px rgba(0, 123, 255, 0.35);
    }

    .ct-icon-wrapper svg {
        width: 40px;
        height: 40px;
        fill: #ffffff;
    }

    .ct-card-title {
        font-size: 20px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 8px;
        text-align: center;
    }

    .ct-card-subtitle {
        font-size: 13px;
        color: #007bff;
        font-weight: 600;
        text-align: center;
        margin-bottom: 16px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .ct-contact-item {
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #f0f0f0;
    }

    .ct-contact-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .ct-contact-label {
        font-size: 14px;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 8px;
        display: block;
    }

    .ct-contact-value {
        font-size: 14px;
        color: #666;
        margin: 4px 0;
        display: block;
    }

    .ct-contact-value a {
        color: #007bff;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .ct-contact-value a:hover {
        color: #0056b3;
    }

    /* WhatsApp Button */
    .ct-wa-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
        color: #ffffff;
        padding: 10px 20px;
        border-radius: 25px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
    }

    .ct-wa-btn:hover {
        background: linear-gradient(135deg, #128C7E 0%, #075E54 100%);
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(37, 211, 102, 0.4);
    }

    .ct-wa-btn svg {
        width: 18px;
        height: 18px;
        fill: currentColor;
    }

    /* Map Card */
    .ct-map-card {
        grid-column: 1 / -1;
        padding: 40px;
    }

    .ct-map-wrapper {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        margin-top: 24px;
    }

    .ct-map-wrapper iframe {
        width: 100%;
        height: 400px;
        border: none;
    }

    .ct-address-text {
        text-align: center;
        color: #4a4a4a;
        font-size: 15px;
        line-height: 1.7;
        margin-bottom: 24px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    /* List Styles */
    .ct-list {
        list-style: none;
        padding: 0;
        margin: 12px 0;
    }

    .ct-list li {
        padding: 6px 0 6px 24px;
        position: relative;
        color: #666;
        font-size: 14px;
    }

    .ct-list li:before {
        content: "•";
        position: absolute;
        left: 8px;
        color: #007bff;
        font-weight: bold;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .ct-grid {
            grid-template-columns: 1fr;
        }

        .ct-map-card {
            padding: 24px;
        }

        .ct-map-wrapper iframe {
            height: 300px;
        }

        .ct-title {
            font-size: 26px;
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

    .ct-card {
        animation: fadeInUp 0.6s ease-out;
    }

    .ct-card:nth-child(1) {
        animation-delay: 0.1s;
    }

    .ct-card:nth-child(2) {
        animation-delay: 0.2s;
    }

    .ct-card:nth-child(3) {
        animation-delay: 0.3s;
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
                <h2>KONTAK KAMI</h2>
                <ol>
                    <li><a href="<?php echo BASE_URL . '/' ?>">Beranda</a></li>
                    <li>Kontak Kami</li>
                </ol>
            </div>
        </div>

        <?php include(ROOT_PATH . '/include/webticker.php') ?>

        <!-- Enhanced Contact Section -->
        <section class="ct-enhanced-section">
            <div class="container" data-aos="fade-up">

                <!-- Header with Lottie -->
                <div class="ct-header">
                    <div class="ct-lottie-wrapper" data-aos="zoom-in">
                        <dotlottie-wc src="https://lottie.host/cae803f1-93c6-4351-bbbe-529017f979be/71SatsY3K9.lottie"
                            style="width: 300px;height: 300px" autoplay loop></dotlottie-wc>
                    </div>
                    <h2 class="ct-title">Hubungi Kami</h2>
                    <p class="ct-subtitle">Kami siap melayani dan menjawab pertanyaan Anda</p>
                </div>

                <!-- Contact Cards Grid -->
                <div class="ct-grid">

                    <!-- Email Card -->
                    <div class="ct-card" data-aos="fade-up" data-aos-delay="100">
                        <div class="ct-icon-wrapper">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                            </svg>
                        </div>
                        <h3 class="ct-card-title">Email Kami</h3>
                        <p class="ct-card-subtitle">Kirim Email Kapan Saja</p>

                        <div class="ct-contact-item">
                            <span class="ct-contact-label">Customer Service</span>
                            <a href="mailto:cs@muaratirta.co.id" class="ct-contact-value">cs@muaratirta.co.id</a>
                        </div>

                        <div class="ct-contact-item">
                            <span class="ct-contact-label">Public Relation</span>
                            <a href="mailto:pdam@muaratirta.co.id" class="ct-contact-value">pdam@muaratirta.co.id</a>
                            <a href="mailto:perumda@muaratirta.co.id"
                                class="ct-contact-value">perumda@muaratirta.co.id</a>
                        </div>

                        <div class="ct-contact-item">
                            <span class="ct-contact-label">IT Support</span>
                            <a href="mailto:admin@muaratirta.co.id" class="ct-contact-value">admin@muaratirta.co.id</a>
                        </div>
                    </div>

                    <!-- Phone/WhatsApp Card -->
                    <div class="ct-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="ct-icon-wrapper">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56-.35-.12-.74-.03-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z" />
                            </svg>
                        </div>
                        <h3 class="ct-card-title">Hubungi Kami</h3>
                        <p class="ct-card-subtitle">Chat via WhatsApp</p>

                        <div class="ct-contact-item">
                            <span class="ct-contact-label">Customer Service</span>
                            <span class="ct-contact-value">Layanan Pelanggan 24/7</span>
                            <a href="https://wa.me/6282292754405" class="ct-wa-btn">
                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                </svg>
                                Chat Sekarang
                            </a>
                        </div>

                        <div class="ct-contact-item">
                            <span class="ct-contact-label">Humas</span>
                            <span class="ct-contact-value">Dedi Kiayi Demak</span>
                            <a href="https://wa.me/6281244782662" class="ct-wa-btn">
                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                </svg>
                                Chat Sekarang
                            </a>
                        </div>

                        <div class="ct-contact-item">
                            <span class="ct-contact-label">Penagihan</span>
                            <ul class="ct-list">
                                <li>Konfirmasi Bukti Transfer</li>
                            </ul>
                            <span class="ct-contact-value">Recky Pianaung</span>
                            <a href="https://wa.me/6281244697154" class="ct-wa-btn">
                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                </svg>
                                Chat Sekarang
                            </a>
                        </div>
                    </div>

                    <!-- Map Card - Full Width -->
                    <div class="ct-card" data-aos="fade-up" data-aos-delay="300">
                        <div class="ct-icon-wrapper">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                            </svg>
                        </div>
                        <h3 class="ct-card-title">Lokasi Kantor</h3>
                        <p class="ct-card-subtitle">Kunjungi Kami</p>
                        <p class="ct-address-text">
                            Jl. Drs. Achmad Nadjamuddin, Limba U Dua, Kota Sel., Kota Gorontalo, Gorontalo 96138
                        </p>
                        <div class="ct-map-wrapper">
                            <iframe
                                src="https://maps.google.com/maps?q=perumda+air+minum+muara+tirta&t=k&z=16&ie=UTF8&iwloc=&output=embed"
                                allowfullscreen loading="lazy">
                            </iframe>
                        </div>
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

    <!-- Lottie Player Script -->
    <script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.8.5/dist/dotlottie-wc.js" type="module"></script>

    <?php include(ROOT_PATH . '/include/scripts.php'); ?>
</body>

</html>