<?php require_once('../../path.php'); ?>
<?php require_once(ROOT_PATH . '/app/controllers/info.php'); ?>
<?php

include(ROOT_PATH . '/app/helpers/middleware.php');
adminOnly();

if (empty($_GET['id'])) {
    header('Location:' . BASE_URL . '/404');
} else {
    $informasi = selectOne('informasi', ['id' => $_GET['id']]);
    if ($informasi == null) {
        header('Location:' . BASE_URL . '/404');
    }
}

?>

<?php adminOnly(); ?>

<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title>
        <?php echo isset($_GET['page-title']) && $_GET['page-title'] !== '' ? $_GET['page-title'] : 'Beranda | Muaratirta Kota Gorontalo'; ?>
    </title>

    <!-- Site favicon -->
    <link href="../../assets/logo/Logo-PDAM-MT-min.ico" rel="icon">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="../vendors/styles/core.css" />
    <link rel="stylesheet" type="text/css" href="../vendors/styles/icon-font.min.css" />
    <link rel="stylesheet" type="text/css" href="../src/plugins/datatables/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="../src/plugins/datatables/css/responsive.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="../vendors/styles/style.css" />
    <link rel="stylesheet" href="../src/plugins/sweetalert2/sweetalert2.css">
</head>

<body>
    <!-- <div class="pre-loader">
        <div class="pre-loader-box">
            <div class="loader-logo">
                <img src="../vendors/images/deskapp-logo.svg" alt="" />
            </div>
            <div class="loader-progress" id="progress_div">
                <div class="bar" id="bar1"></div>
            </div>
            <div class="percent" id="percent1">0%</div>
            <div class="loading-text">Loading...</div>
        </div>
    </div> -->

    <?php include ROOT_PATH . '/admin/inc/headerAdmin.php' ?>

    <?php include ROOT_PATH . '/admin/inc/rightSidebar.php' ?>
    <?php include ROOT_PATH . '/admin/inc/leftSidebar.php' ?>



    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div class="xs-pd-20-10 pd-ltr-20">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">

                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a
                                        href="<?php echo BASE_URL . '/admin/index.php?page-title=Dashboard-Admin' ?>">Beranda</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Edit Data
                                </li>
                            </ol>
                        </nav>
                    </div>

                </div>
            </div>
            <div class="card-box pd-20">
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label">* Judul</label>
                        <div class="col-lg-6">
                            <input class="form-control" value="<?php echo $informasi['judul'] ?>" type="text"
                                name="judul">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label">Deskripsi</label>
                        <div class="col-lg-12">
                            <textarea class="textarea_editor form-control border-radius-0"
                                name="deskripsi"><?php echo $informasi['deskripsi'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-form-label col-sm-1">Tag</label>
                        <div class="col-lg-6">
                            <select name="tag" id="" class="selectpicker form-control" data-style="btn-outline-primary"
                                data-size="5">
                                <!-- <option value="" selected disabled>--Pilih</option> -->

                                <option <?php echo ($informasi['tag'] == 'Berita') ? 'selected' : ''; ?>>Berita</option>
                                <option <?php echo ($informasi['tag'] == 'Info Gangguan') ? 'selected' : ''; ?>>Info
                                    Gangguan</option>
                                <option <?php echo ($informasi['tag'] == 'Promo') ? 'selected' : ''; ?>>Promo</option>

                            </select>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-form-label col-sm-1">Gambar</label>
                        <div class="col-lg-6">

                            <input type="file" name="image" id="formFile" onchange="preview()">
                            <!-- <button onclick="clearImage()" class="btn btn-danger mt-3">clear</button> -->

                        </div>
                    </div>
                    <div class="form-group row" style="height:500px;width:500px;">
                        <?php if (!empty($informasi['image'])) : ?>

                        <img src="<?php echo resolveImageUrl($informasi['image'], 'informasi', ['assets/info']); ?>" id="frame"
                            alt="current_image" class="img-fluid mh-100">
                        <?php else : ?>
                        <img src="" id="frame" alt="" class="img-fluid mh-100">
                        <?php endif; ?>
                    </div>

                    <div class="form-group row">
                        <button type="submit" class="btn btn-primary" name="update-info">Update</button>
                    </div>

                </form>

            </div>

        </div>
    </div>

    <script src="../vendors/scripts/core.js"></script>
    <script src="../vendors/scripts/script.min.js"></script>
    <script src="../vendors/scripts/process.js"></script>
    <script src="../vendors/scripts/layout-settings.js"></script>
    <script src="../src/plugins/apexcharts/apexcharts.min.js"></script>
    <script src="../src/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="../src/plugins/datatables/js/dataTables.responsive.min.js"></script>
    <script src="../src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
    <script src="../vendors/scripts/dashboard3.js"></script>
    <script src="../src/plugins/sweetalert2/sweetalert2.all.js"></script>


    <script>
    function preview() {
        frame.src = URL.createObjectURL(event.target.files[0]);
    }

    function clearImage() {
        document.getElementById('formFile').value = null;
        frame.src = "";
    }
    </script>
    <script>
    <?php if (isset($_SESSION['message']) && $_SESSION['type']) : ?>
    var pesan = '<?php echo $_SESSION['message'] ?>'
    var type = '<?php echo $_SESSION['type'] ?>'

    swal({
        // title: 'Nice job',
        text: pesan,
        type: type,
    });

    <?php
            unset($_SESSION['message']);
            unset($_SESSION['type']);

            ?>


    <?php endif; ?>
    </script>
</body>

</html>