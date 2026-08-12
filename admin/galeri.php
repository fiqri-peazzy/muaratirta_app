<?php
include("../path.php");
include(ROOT_PATH . "/app/controllers/galeri.php");
include(ROOT_PATH . '/app/helpers/middleware.php');
adminOnly();

?>

<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title>
        <?php echo isset($_GET['page-title']) && $_GET['page-title'] !== '' ? $_GET['page-title'] : 'Beranda | Muaratirta Kota Gorontalo'; ?>
    </title>

    <!-- Site favicon -->
    <link href="../assets/logo/Logo-PDAM-MT-min.ico" rel="icon">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <?php include ROOT_PATH . '/admin/inc/styleAdmin.php'; ?>
</head>

<body>
    <!-- <div class="pre-loader">
        <div class="pre-loader-box">
            <div class="loader-logo">
                <img src="vendors/images/deskapp-logo.svg" alt="" />
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
                        <div class="title">
                            <h4> Galeri</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php echo BASE_URL . '/admin/?page-title=Dashboard-Admin' ?>">Beranda</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Galeri
                                </li>
                            </ol>
                        </nav>
                    </div>

                </div>
            </div>
            <div class="gallery-wrap">
                <ul class="row">
                    <?php $all_img = selectAll('galeri'); ?>
                    <?php foreach ($all_img as $img) : ?>
                        <li class="col-lg-4 col-md-6 col-sm-12">
                            <div class="da-card box-shadow">
                                <div class="da-card-photo">
                                    <img src="<?php echo resolveImageUrl($img['image'], 'galeri', ['assets/galeri']) ?>" alt="" />
                                    <div class="da-overlay">
                                        <div class="da-social">
                                            <h5 class="mb-10 color-white pd-20">
                                                <?php echo $img['judul'] ?>
                                            </h5>
                                            <ul class="clearfix">
                                                <li>
                                                    <a href="<?php echo resolveImageUrl($img['image'], 'galeri', ['assets/galeri']) ?>" data-fancybox="images"><i class="fa fa-picture-o"></i></a>
                                                </li>
                                                <li>
                                                    <a id="hapus-img" class="hapus-img" data-id="<?= $img['id'] ?>"><i class="fa fa-trash"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                    <li class="col-lg-4 col-md-6 col-sm-12">
                        <div class="da-card box-shadow">
                            <div class="da-card-photo">
                                <img src="vendors/images/product-img1.jpg" alt="" />
                                <div class="da-overlay">
                                    <div class="da-social">
                                        <h5 class="mb-10 color-white pd-20">
                                            Tambah Gambar Baru
                                        </h5>
                                        <ul class="clearfix">

                                            <li>
                                                <a href="<?php echo BASE_URL . '/admin/galeri/tambah.php' ?>"><i class="fa fa-plus"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                </ul>
            </div>

        </div>
    </div>

    <?php include ROOT_PATH . '/admin/inc/scriptAdmin.php' ?>
    <script>
        $(document).ready(function() {

            $('.hapus-img').on('click', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var url = '<?php echo BASE_URL . '/admin/galeri.php?hapus-img=' ?>';
                var delete_url = url + id;
                console.log(delete_url);
                console.log(id);

                // Show SweetAlert2 confirmation dialog
                swal({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then(function(isConfirmed) {
                    if (isConfirmed.value) {
                        // User clicked the confirm button
                        $.ajax({
                            url: delete_url,
                            type: 'GET',
                            success: function(response) {
                                // Handle success (e.g., remove the deleted item from the UI)
                                swal('Deleted!', 'Your file has been deleted.',
                                    'success');
                                window.location.href =
                                    '<?php echo BASE_URL . '/admin/galeri.php' ?>'
                            },
                            error: function(error) {
                                // Handle error
                                swal('Error!', 'There was an error while deleting.',
                                    'error');
                            }
                        });
                    } else {
                        // User clicked the cancel button or closed the dialog
                        swal('Cancelled', 'Your file is safe :)', 'info');
                        // Additional logic for cancel handling if needed
                    }
                });

            });
        });
    </script>

</body>

</html>