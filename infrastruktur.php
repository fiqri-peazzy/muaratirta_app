<?php
include("path.php");

include(ROOT_PATH . '/app/controllers/users.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>
        Infrastruktur | Muaratirta Kota Gorontalo
    </title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <!-- <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon"> -->

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Roboto:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Work+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">
    <link href="assets/logo/Logo-PDAM-MT-min.ico" rel="icon">

    <?php include(ROOT_PATH . '/include/styles.php'); ?>
    <style>
    /* .infrastruktur {
        padding: 80px 0;
        background: linear-gradient(180deg, var(--light-bg) 0%, var(--white) 100%);
    } */

    /* Accordion Modern Styling */
    .accordion {
        border-radius: 12px;
        overflow: hidden;
    }

    .accordion-item {
        border: none;
        background: var(--white);
        margin-bottom: 1rem;
        border-radius: 12px !important;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        overflow: hidden;
    }

    .accordion-item:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }

    .accordion-header {
        border-radius: 12px;
    }

    .accordion-button {
        /* padding: 1.5rem 1.75rem; */
        background: var(--white);
        border: none;
        font-weight: 600;
        font-size: 1.1rem;
        color: #212529;
        transition: var(--transition);
        border-radius: 12px !important;
        position: relative;
    }

    .accordion-button:not(.collapsed) {
        background: linear-gradient(135deg, var(--primary-color), #0a58ca);
        color: var(--white);
        box-shadow: var(--shadow-md);
    }

    .accordion-button:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        border: none;
    }

    .accordion-button::after {
        display: none;
    }

    .accordion-button .head {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .accordion-button .head::before {
        content: '';
        width: 4px;
        height: 24px;
        background: var(--primary-color);
        border-radius: 2px;
        transition: var(--transition);
    }

    .accordion-button:not(.collapsed) .head::before {
        background: var(--white);
    }

    .accordion-button i {
        font-size: 1rem;
        transition: var(--transition);
        color: var(--primary-color);
    }

    .accordion-button:not(.collapsed) i {
        transform: rotate(45deg);
        color: var(--white);
    }

    .accordion-body {
        padding: 2rem 1.75rem;
        background: var(--white);
        line-height: 1.8;
        color: #495057;
    }

    /* Statistics Cards */
    .accordion-body h4 {
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 3px solid var(--primary-color);
        display: inline-block;
    }

    .accordion-body hr {
        margin: 2rem 0;
        border: none;
        height: 2px;
        background: linear-gradient(90deg, var(--primary-color), transparent);
        opacity: 0.3;
    }

    /* Stat Box */
    .accordion-body .row>div {
        padding: 1.25rem;
        margin-bottom: 1rem;
        background: var(--light-bg);
        border-radius: 10px;
        transition: var(--transition);
        border-left: 4px solid var(--primary-color);
    }

    .accordion-body .row>div:hover {
        background: #e7f1ff;
        transform: translateX(5px);
        box-shadow: var(--shadow-sm);
    }

    .accordion-body .text-muted {
        font-size: 0.875rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--secondary-color) !important;
        margin-bottom: 0.5rem;
        display: block;
    }

    .accordion-body .fw-semibold {
        font-size: 1.5rem;
        color: #212529;
        font-weight: 700;
    }

    .accordion-body .text-success {
        color: var(--success-color) !important;
        font-size: 0.875rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        margin-left: 0.5rem;
    }

    /* List Styling */
    .accordion-body ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .accordion-body ul li {
        padding: 0.875rem 1.25rem;
        margin-bottom: 0.75rem;
        background: var(--light-bg);
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: var(--transition);
        border-left: 3px solid var(--success-color);
    }

    .accordion-body ul li:hover {
        background: #e7f1ff;
        transform: translateX(8px);
        box-shadow: var(--shadow-sm);
    }

    .accordion-body ul li i {
        color: var(--success-color);
        font-size: 1.25rem;
    }

    /* Image Container */
    .accordion-body img {
        border-radius: 12px;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
    }

    .accordion-body img:hover {
        transform: scale(1.02);
        box-shadow: var(--shadow-lg);
    }

    /* Pompanisasi List */
    .accordion-body p {
        margin-bottom: 0.75rem;
        padding: 0.75rem 1rem;
        background: var(--light-bg);
        border-radius: 6px;
        border-left: 3px solid var(--info-color);
        transition: var(--transition);
    }

    .accordion-body p:hover {
        background: #e7f1ff;
        transform: translateX(5px);
    }

    .accordion-body p b {
        color: var(--primary-color);
        font-weight: 600;
    }

    .accordion-body p u {
        text-decoration: none;
        border-bottom: 2px solid var(--primary-color);
        padding-bottom: 2px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {

        .infrastruktur {
            padding: 60px 0;
        }

        .accordion-button {
            padding: 1.25rem 1rem;
            font-size: 1rem;
        }

        .accordion-body {
            padding: 1.5rem 1rem;
        }

        .accordion-body .fw-semibold {
            font-size: 1.25rem;
        }

        .accordion-body .row>div {
            margin-bottom: 0.75rem;
        }

        .accordion-item .accordion-button .head {
            padding-left: 12px !important;
        }
    }

    @media (max-width: 576px) {
        .breadcrumbs h2 {
            font-size: 1.75rem;
        }

        .accordion-button {
            padding: 1rem 0.875rem;
            font-size: 0.95rem;
        }

        .accordion-body {
            padding: 1.25rem 0.875rem;
            font-size: 0.9rem;
        }

        .accordion-body .fw-semibold {
            font-size: 1.1rem;
        }

        .accordion-body ul li {
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
        }

        .accordion-item .accordion-button .head {
            padding-left: 12px !important;
        }
    }

    /* Animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .accordion-item {
        animation: fadeIn 0.5s ease-out backwards;
    }

    .accordion-item:nth-child(1) {
        animation-delay: 0.1s;
    }

    .accordion-item:nth-child(2) {
        animation-delay: 0.15s;
    }

    .accordion-item:nth-child(3) {
        animation-delay: 0.2s;
    }

    .accordion-item:nth-child(4) {
        animation-delay: 0.25s;
    }

    .accordion-item:nth-child(5) {
        animation-delay: 0.3s;
    }

    .accordion-item:nth-child(6) {
        animation-delay: 0.35s;
    }

    .accordion-item:nth-child(7) {
        animation-delay: 0.4s;
    }

    .accordion-item:nth-child(8) {
        animation-delay: 0.45s;
    }

    .accordion-item:nth-child(9) {
        animation-delay: 0.5s;
    }
    </style>


</head>

<body>

    <?php include(ROOT_PATH . '/include/header.php'); ?>
    <main id="main">

        <!-- ======= Breadcrumbs ======= -->
        <div class="breadcrumbs d-flex align-items-center"
            style="background-image: url('assets/image/RLC_1016-1-min.jpg');">
            <div class="container position-relative d-flex flex-column align-items-center" data-aos="fade">

                <h2>Infrastruktur</h2>
                <ol>
                    <li><a href="<?php echo BASE_URL . '/' ?>">Beranda</a></li>
                    <li>Infrastruktur</li>
                </ol>


            </div>
        </div><!-- End Breadcrumbs -->
        <?php include(ROOT_PATH . '/include/webticker.php') ?>

        <section id="infrastrktur" class="infrastruktur section-bg">

            <div class="container" data-aos="fade-up">
                <div class="detail-inner mt-5 mb-5">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-heading">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapse" aria-expanded="false"
                                    aria-controls="flush-collapse">
                                    <span class="head">Data Existing</span><i class="fa fa-plus"></i>
                                </button>
                            </h2>
                            <div id="flush-collapse" class="accordion-collapse collapse" aria-labelledby="flush-heading"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <h4 class="text-primary">Jumlah penduduk Tahun 2023 ( Semester 1 – data DKPS Kota
                                        Gorontalo )</h4>
                                    Kota Gorontalo merupakan ibu kota Provinsi Gorontalo, Indonesia sekaligus menjadi
                                    ibu kota Kawasan
                                    Teluk Tomini di Semenanjung Utara Pulau Sulawesi.
                                    <br><br>
                                    Kota Gorontalo merupakan kota terbesar dan terpadat penduduknya di wilayah Teluk
                                    Tomini (Teluk Gorontalo), sehingga menjadikan Kota Gorontalo sebagai pusat ekonomi,
                                    jasa dan perdagangan, pendidikan, hingga pusat penyebaran agama Islam di Kawasan
                                    Indonesia Timur
                                    <br><br>
                                    Dalam catatan manuskrip sejarah Kesultanan Gorontalo, Kota Gorontalo yang lebih
                                    tertata dan memadai terbentuk secara resmi pada hari Kamis, 18 Maret 1728 (06
                                    Syakban 1140 Hijriah).
                                    <br><br>
                                    Kota ini memiliki luas wilayah 79,03 km² (0,65% dari luas Provinsi Gorontalo) yang
                                    terdiri dari 9 kecamatan dan 50 Kelurahan. Kota Gorontalo memiliki penduduk pada
                                    tahun 2022 sebanyak 219.399 jiwa.
                                    <br><br>
                                    <hr>

                                    <div class="row">
                                        <h4 class="text-primary">Jumlah penduduk Tahun 2023 semester 1 - data DKPS Kota
                                            Gorontalo</h4>
                                        <div class="col-md-4">
                                            <span class="text-muted">Pria</span>
                                            <h5 class="fw-semibold">49.85% </h5>
                                        </div>
                                        <div class="col-md-4">
                                            <span class="text-muted">Wanita</span>
                                            <h5 class="fw-semibold">50.22% </h5>
                                        </div>
                                        <div class="col-md-4"><span class="text-muted">Pertumbuhan Penduduk</span>
                                            <h5 class="fw-semibold">1.16% / Tahun</h5>
                                        </div>
                                    </div>
                                    <br>
                                    <hr>
                                    <div class="row">

                                        <h4 class="text-primary">Cakupan Layanan Air Minum Perumda Air Muara Tirta Kota
                                            Gorontalo</h4>
                                        <div class="col-md-4">
                                            <span class="text-muted">2020</span>
                                            <h5 class="fw-semibold">50.85%</h5>
                                        </div>
                                        <div class="col-md-4">
                                            <span class="text-muted">2021</span>
                                            <h5 class="fw-semibold">59.61% <span class="text-success">Naik 3.76%</span>
                                            </h5>
                                        </div>
                                        <div class="col-md-4">

                                            <span class="text-muted">2021</span>
                                            <h5 class="fw-semibold">74.83% <span class="text-success">Naik 15.22%</span>
                                            </h5>
                                        </div>
                                    </div>
                                    <br>
                                    <hr>
                                    <div class="row">

                                        <h4 class="text-primary">Pelanggan dan Pegawai</h4>
                                        <div class="col-md-3">
                                            <span class="text-muted">Jumlah Pelanggan</span>
                                            <h5 class="fw-semibold">31.130 Pelanggan</h5>
                                        </div>
                                        <div class="col-md-3">
                                            <span class="text-muted">Jumlah Pegawai Perumda</span>
                                            <h5 class="fw-semibold">179 Pegawai
                                            </h5>
                                        </div>
                                        <div class="col-md-3">

                                            <span class="text-muted">Rasio Pegawai</span>
                                            <h5 class="fw-semibold">5.75%
                                            </h5>
                                        </div>
                                    </div>
                                    <br>
                                    <hr>
                                    <div class="row">

                                        <h4 class="text-primary">Konsumsi Air Domestik</h4>
                                        <div class="col-md-3">
                                            <span class="text-muted">2020-2021</span>
                                            <h5 class="fw-semibold">17.18m<sup>3</sup> </h5>
                                            <span class="text-success">Meningkat 0.3 <sup>3</sup></span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseOne" aria-expanded="false"
                                    aria-controls="flush-collapseOne">
                                    <span class="head">Sumber Air Baku</span><i class="fa fa-plus"></i>
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <ul>
                                        <li><i class="fas fa-check-circle"></i> Air Sungai Bone</li>
                                        <li><i class="fas fa-check-circle"></i> Air Sungai Bolango</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseTwo" aria-expanded="false"
                                    aria-controls="flush-collapseTwo">
                                    <span class="head">Peta Pelayanan</span><i class="fa fa-plus"></i>
                                </button>
                            </h2>
                            <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div class="col-lg-6">
                                        <img src="<?php echo BASE_URL . '/assets/image/map-300x235.png' ?>"
                                            class="img-fluid" width="100%" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseThree" aria-expanded="false"
                                    aria-controls="flush-collapseThree">
                                    <span class="head">Sistem Penyediaan Air
                                        Minum</span><i class="fa fa-plus"></i>
                                </button>
                            </h2>
                            <div id="flush-collapseThree" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">Sistem penyediaan air minum yang dikelola oleh PDAM Kota
                                    Gorontalo adalah satu sistem yaitu sistem kota, yang dibangun berdasarkan
                                    feasibility studi dengan master plan penyediaan air minum untuk Kota Gorontalo yang
                                    dibuat oleh PT.Encona Engineering Inc, pada tahun 1975. Pengadaan peralatan dan
                                    perpipaan dilaksanakan oleh DEGREMONT S.A dari Negera Perancis. Pembangunan gedung
                                    serta pemasangan peralatan (mesin, pompa dan listrik) mulai dilaksanakan pada tahun
                                    1979 – 1980 melalui Proyek Penyediaan Air Bersih Sulawesi Utara dan mulai di uji
                                    coba pada tahun 1982. Pengoperasian Instalasi Pengolahan Air Minum diresmikan pada
                                    tanggal 17 April 1986 oleh Menteri Pekerjaan Umum Prof.Dr.Ir.Suyono Sostrodarsono.
                                    Sistem kota ini melayani daerah pelayanan yang mencakup seluruh Kota Gorontalo yang
                                    terdiri dari 9 Kecamatan dan 2 Kecamatan berada di wilayah Kabupaten Bone Bolango.
                                    Sistem penyediaan air bersih ini berupa Instalasi Pengolahan Lengkap (IPA) dari
                                    bahan beton “The Gremount” dengan kapasitas terpasang 218 ltr/dtk.</div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseFour" aria-expanded="false"
                                    aria-controls="flush-collapseFour">
                                    <span class="head">Water Treatment Plant</span><i class="fa fa-plus"></i>
                                </button>
                            </h2>
                            <div id="flush-collapseFour" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">Untuk menunjang sistem penyediaan air minum yang ada saat
                                    ini, pada awal tahun 2007 telah dioperasikan Instalasi Pengolahan Air (IPA) atau
                                    yang dikenal dengan Water Treatment Plant kapasitas 20 ltr/dtk yang dibangun di
                                    wilayah Kel. Bulotadaa Kec. Kota Utara Kota Gorontalo dengan menggunakan sumber air
                                    baku Sungai Bolango. Dan pada tahun 2009 dibangun Instalasi Pengolahan Air (IPA)
                                    dengan kapasitas 10 ltr/dtk diwilayah Kelurahan Pilolodaa Kec. Kota Barat Kota
                                    Gorontalo. Tahun 2016 PDAM Kota Gorontalo membangun kembali IPA Bulotadaa dengan
                                    Kapasitas 50 ltr/dtk, dan mendapat hibah dari Kementerian PU berupa IPA Botu
                                    berkapasitas 20 ltr/dtk dan IPA Dungingi kapasitas 20 ltr/dtk.</div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseFive" aria-expanded="false"
                                    aria-controls="flush-collapseFive">
                                    <span class="head">Sistem Pengaliran</span><i class="fa fa-plus"></i>
                                </button>
                            </h2>
                            <div id="flush-collapseFive" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <p><u><b>POMPANISASI: </b></u></p>
                                    <p><b>IPA KABILA </b><b> </b><b>: </b><b>218
                                        </b><b>L</b><b>tr</b><b>/</b><b>dt</b><b>k</b></p>
                                    <p><b>IPA </b><b>BULOTADAA </b><b> </b><b> </b><b>: 70
                                            L</b><b>tr</b><b>/</b><b>dt</b><b>k</b></p>
                                    <p><b>IPA PILOLODAA </b><b> </b><b> </b><b> : </b><b>10
                                        </b><b>L</b><b>tr</b><b>/</b><b>dt</b><b>k</b></p>
                                    <p><b>IPA </b><b>DUNGINGI </b><b> : </b><b>20
                                        </b><b>L</b><b>tr</b><b>/</b><b>dt</b><b>k</b></p>
                                    <p><b>IPA </b><b>BOTU </b><b> : </b><b>20
                                        </b><b>L</b><b>tr</b><b>/</b><b>dt</b><b>k</b></p>
                                    <p><b>POMPA BOSTER PALMA : 5 L</b><b>tr</b><b>/</b><b>dt</b><b>k</b></p>
                                    <p><b>POMPA BOSTER SIENDENG </b><b> </b><b>: 5
                                            L</b><b>tr</b><b>/</b><b>dt</b><b>k</b></p>
                                    <p><b>POMPA BOSTER LOTU </b><b> </b><b>: 4 L</b><b>tr</b><b>/</b><b>dt</b><b>k</b>
                                    </p>
                                    <p><b>POMPA BOSTER PELABUHAN </b><b> </b><b>: 1.5
                                            L</b><b>tr</b><b>/</b><b>dt</b><b>k</b></p>
                                    <p><b>POMPA BOSTER POHE </b><b> </b><b>: 8 L</b><b>tr</b><b>/</b><b>dt</b><b>k</b>
                                    </p>
                                    <p><b>POMPA BOSTER TANJUNG KRAMAT : 5 L</b><b>tr</b><b>/</b><b>dt</b><b>k</b></p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingSix">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseSix" aria-expanded="false"
                                    aria-controls="flush-collapseSix">
                                    <span class="head">Insatalasi Perpipaan</span><i class="fa fa-plus"></i>
                                </button>
                            </h2>
                            <div id="flush-collapseSix" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingSix" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div class="col-lg-6">
                                        <img src="<?php echo BASE_URL . '/assets/image/mitra1-300x293.png' ?>"
                                            class="img-fluid" width="100%" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingSeven">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseSeven" aria-expanded="false"
                                    aria-controls="flush-collapseSeven">
                                    <span class="head">Intake</span><i class="fa fa-plus"></i>
                                </button>
                            </h2>
                            <div id="flush-collapseSeven" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingSeven" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">Intake berupa saluran dengan konstruksi beton sepanjang ± 20
                                    meter dengan 2 buah mulut intake, pada saluran intake terdapat 1 unit rumah pompa
                                    air baku dengan jumlah pompa sebanyak 4 unit. Pompa-pompa ini akan mendorong air
                                    dari saluran intake menuju bangunan pengolahan air bersih, masing-masing pompa
                                    berkapasitas 120 ltr/dtk dengan daya dorong (head) 15 meter. Kapasitas penyadapan
                                    pompa rata-rata 240 ltr/dtk dengan operasi ± 24 jam/hari, yang dilakukan oleh 2 unit
                                    pompa dan 2 unit pompa lainnya sebagai cadangan (IPA Kabila)</div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingEight">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseEight" aria-expanded="false"
                                    aria-controls="flush-collapseEight">
                                    <span class="head">Area Pelayanan</span><i class="fa fa-plus"></i>
                                </button>
                            </h2>
                            <div id="flush-collapseEight" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingEight" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">Wilayah pelayanan PDAM meliputi wilayah administrasi
                                    pemerintahan Kota Gorontalo dan sebagian wilayah Kabupaten Bone Bolango (Kecamatan
                                    Kabila dan Suwawa), luas Kota Gorontalo mencapai 64,79 Km2 hampir sebagian besar
                                    sudah dijangkau oleh jaringan perpipaan PDAM terutama pada daerah/wilayah permukiman
                                    diperkirakan ± 80 %. Dengan status sebagai Ibu Kota Provinsi Gorontalo, pertumbuhan
                                    penduduk dirasakan begitu pesat, jumlah penduduk Tahun 2012 adalah 201.509 jiwa.
                                    Jumlah penduduk sampai dengan Bulan Juni 2013 adalah 205.764 jiwa dan jumlah
                                    sambungan Aktif s/d Bulan Juni Tahun 2013 adalah 19.891 unit dengan cakupan wilayah
                                    pelayanan 65.14%.</div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingNine">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseNine" aria-expanded="false"
                                    aria-controls="flush-collapseNine">
                                    <span class="head">Perkembangan Jumlah
                                        Sambungan</span><i class="fa fa-plus"></i>
                                </button>
                            </h2>
                            <div id="flush-collapseNine" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingNine" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div class="col-lg-6">
                                        <img src="<?php echo BASE_URL . '/assets/image/mitra2-300x195.jpg' ?>"
                                            class="img-fluid" width="100%" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </section>



    </main><!-- End #main -->


    <?php include(ROOT_PATH . '/include/footer.php'); ?>

    <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <div id="preloader"></div>

    <?php include(ROOT_PATH . '/include/scripts.php'); ?>

</body>

</html>