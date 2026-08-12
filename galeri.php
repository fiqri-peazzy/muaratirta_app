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
        Galeri Muaratirta | Muaratirta Kota Gorontalo
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

</head>

<body>

    <?php include(ROOT_PATH . '/include/header.php'); ?>
    <main id="main">

        <!-- ======= Breadcrumbs ======= -->
        <div class="breadcrumbs d-flex align-items-center"
            style="background-image: url('assets/image/RLC_1016-1-min.jpg');">
            <div class="container position-relative d-flex flex-column align-items-center" data-aos="fade">

                <h2>GALERI</h2>
                <ol>
                    <li><a href="<?php echo BASE_URL . '/' ?>">Beranda</a></li>
                    <li>Galeri</li>
                </ol>


            </div>
        </div><!-- End Breadcrumbs -->
        <?php include(ROOT_PATH . '/include/webticker.php') ?>

        <section id="galeri" class="galeri section-bg">
            <div class="container" data-aos="fade-up">
                <div class="gallery-wrap">
                    <ul class="row">
                        <?php $all_img = selectAll('galeri', [], 'tanggal'); ?>
                        <?php foreach ($all_img as $i) : ?>
                        <li class="col-lg-4 col-md-6 col-sm-12">
                            <div class="da-card box-shadow">
                                <div class="da-card-photo">
                                    <img src="<?php echo BASE_URL . '/assets/galeri/' . $i['image']; ?>" alt="" />
                                    <div class="da-overlay">
                                        <div class="da-social">
                                            <h5 class="mb-10 color-white pd-20">
                                                <?php echo $i['judul'] ?>
                                            </h5>
                                            <ul class="clearfix">
                                                <li style="list-style: none;">
                                                    <a href="<?php echo BASE_URL . '/assets/galeri/' . $i['image']; ?>"
                                                        data-fancybox="images"><i class="fa fa-image"></i></a>
                                                </li>
                                                <li>
                                                    <a href="#"><i class="fa fa-link"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
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