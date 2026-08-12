<?php include('../../path.php'); ?>
<?php include(ROOT_PATH . '/app/controllers/info.php'); ?>
<?php
include(ROOT_PATH . '/app/helpers/middleware.php');
adminOnly();

if (empty($_GET['id']) && $_GET['id'] === null) {
    header('Location:' . BASE_URL . '/404');
} else {
    $pasang_baru = selectOne('pasang_baru', ['id' => $_GET['id']]);
    if ($pasang_baru == null) {
        header('Location:' . BASE_URL . '/404');
    }
}

if ($pasang_baru['latitude'] == null && $pasang_baru['longitude'] == null) {
    $q = $pasang_baru['alamat'];
} else {
    $q = $pasang_baru['latitude'] . ',' . $pasang_baru['longitude'];
}

?>

<?php adminOnly(); ?>

<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title>
        <?php echo isset($_GET['page-title']) && $_GET['page-title'] !== '' ? htmlspecialchars($_GET['page-title']) : 'Beranda | Muaratirta Kota Gorontalo'; ?>
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
    <link rel="stylesheet" href="../src/plugins/toastr/toastr.min.css">


    <style>
    .img-wrapper {
        width: auto;
        height: auto;
        padding: 20px;
        border: 1px solid red;
    }

    .img-wrapper img {
        border-radius: 12px;
    }
    </style>
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
                        <div class="title">
                            <h4>Keluhan Pelanggan</h4>
                        </div>

                        <div class="status mt-2 d-flex align-items-center"
                            data-pengaduan-id="<?= $pasang_baru['id'] ?>">
                            <div class="date" style="padding-right: 27px ;">
                                <?= date('d M,Y', strtotime($pasang_baru['created_at'])) ?> </div>
                            <span class="badge badge-<?= $pasang_baru['tindak_lanjut'] == 0 ? 'info' : 'success' ?>">
                                <?= $pasang_baru['tindak_lanjut'] == 0 ? 'Proses' : 'Selesai' ?>
                            </span>
                        </div>

                    </div>

                </div>
            </div>
            <div class="card-box pd-20">
                <h5 class="text-primary p-2">Info Pendaftar</h5><br>

                <div class="row">

                    <!-- <div class="col-lg-6">
                        <div class="form-group mb-1">
                            <label for="" class="form-label">Nama Lengkap</label>
                            <input type="text" name="" id="" class="form-control">
                        </div>
                        <div class="form-group mb-1">
                            <label for="" class="form-label">NIK</label>
                            <input type="text" name="" id="" class="form-control">
                        </div>


                    </div> -->

                    <div class="col-lg-6">
                        <div class="form-group mb-1">
                            <label for="" class="form-label">No.Telp / WA</label>
                            <input type="text" name="" id="" value="<?php echo $pasang_baru['no_hp'] ?>"
                                class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="" class="form-label">Alamat Lengkap</label>
                            <input type="text" class="form-control" name="" id=""
                                value="<?php echo $pasang_baru['alamat'] ?>">
                        </div>
                    </div>

                    <div class="col-md-6">

                        <div class="form-group mb-1">
                            <h6 class="fw-bold">Scan untuk alamat Gmaps</h6><br>
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=170x170&data=<?= urlencode('https://www.google.com/maps?q=' . str_replace(' ', '+', $pasang_baru['alamat'])) ?>"
                                alt="qr-gmaps">
                        </div>
                    </div>

                </div>
                <hr>

                <div class="row">
                    <div class="col-lg-6">
                        <h5 class="text-primary p-2">Foto Ktp</h5><br>
                        <div class="img-wrapper">
                            <img id="foto-ktp" class="img-fluid"
                                src="<?php echo resolveImageUrl($pasang_baru['foto_ktp'], 'daftar-baru', ['assets/daftar-baru']) ?>" alt="">

                        </div>


                    </div>
                    <div class="col-lg-6">
                        <h5 class="text-primary p-2">Foto Rumah</h5><br>
                        <div class="img-wrapper">
                            <img src="<?= resolveImageUrl($pasang_baru['foto_rumah'], 'daftar-baru', ['assets/daftar-baru']) ?>"
                                class="img-fluid" alt="">
                        </div>


                    </div>
                </div>

                <div class="row mb-4 mt-2">

                    <div class="col-lg-6">
                        <h5 class="text-primary p-2">Google Maps</h5><br>
                        <iframe src="https://www.google.com/maps?q=<?= $q ?>&h1=es;z=14&output=embed" frameborder="0"
                            width="100%" height="350px"></iframe>

                    </div>
                </div>
                <div class="row">
                    <div class="form-group mb-3">
                        <a href="<?php echo BASE_URL . '/admin/pasang-baru/cetak_pdf.php?id=' . $pasang_baru['id'] ?>"
                            target="_blank">
                            <button type="submit" class="btn btn-primary" data-id="<?php echo $pasang_baru['id'] ?>"><i
                                    class="fa fa-print"></i>
                                Cetak</button>
                        </a>


                        <a href="#" data-id="<?= $pasang_baru['id'] ?>"
                            class="btn btn-primary update-status <?= $pasang_baru['tindak_lanjut'] == 1 ? 'd-none' : '' ?>"><i
                                class="fa fa-check"></i> Tandai Selesai</a>
                        <a href="#" data-id="<?= $pasang_baru['id'] ?>"
                            class="btn btn-danger hapus <?= $pasang_baru['tindak_lanjut'] == 0 ? 'd-none' : '' ?>"><i
                                class="fa fa-trash"></i> Hapus </a>


                    </div>
                </div>

            </div>

        </div>
    </div>

    <script src="../vendors/scripts/core.js"></script>
    <script src="../vendors/scripts/script.min.js"></script>
    <script src="../vendors/scripts/process.js"></script>
    <script src="../vendors/scripts/layout-settings.js"></script>
    <!-- <script src="../src/plugins/apexcharts/apexcharts.min.js"></script> -->
    <script src="../src/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="../src/plugins/datatables/js/dataTables.responsive.min.js"></script>
    <script src="../src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
    <!-- <script src="../vendors/scripts/dashboard3.js"></script> -->
    <script src="../src/plugins/sweetalert2/sweetalert2.all.js"></script>
    <script src="../src/plugins/toastr/toastr.min.js"></script>



    <script>
    function preview() {
        frame.src = URL.createObjectURL(event.target.files[0]);
    }

    function clearImage() {
        document.getElementById('formFile').value = null;
        frame.src = "";
    }

    $(document).on('click', '.update-status', function(e) {
        e.preventDefault();

        var id = $(this).data('id');
        console.log(id);
        swal({
            title: 'Tandai Telah Selesai ?',
            text: '',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Konfirmasi'
        }).then(function(isConfirmed) {
            if (isConfirmed.value) {
                $.ajax({
                    method: 'POST',
                    url: '<?= BASE_URL . '/admin/pasang-baru/update-p-baru.php' ?>',
                    data: {
                        id: id
                    },

                    dataType: 'json',

                    success: function(response) {
                        if ($.isEmptyObject(response.error)) {
                            if (response.success == 1) {

                                var statusElement = $('.badge');

                                statusElement.removeClass('badge-info badge-success');
                                statusElement.addClass(response.status == 0 ? 'badge-info' :
                                    'badge-success');
                                statusElement.text(response.status == 0 ? 'Proses' :
                                    'Selesai');
                                $('.update-status').addClass('d-none');
                                $('.hapus').removeClass('d-none');

                                toastr.success(response.msg);

                            } else {
                                console.log(response.error);
                                toastr.error(response.msg);

                            }
                        }

                    }
                });
            }
        });

    });

    $('.hapus').on('click', function(e) {
        var id = $(this).data('id');
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
                $.ajax({
                    method: 'POST',
                    url: '<?= BASE_URL . '/admin/pengaduan/hapus-keluhan.php' ?>',
                    data: {
                        id_p: id
                    },
                    success: function(response) {
                        toastr.success('Berhasil Hapus Data');
                        window.location.href = '<?= BASE_URL . '/admin/pasang-baru.php' ?>'
                    }
                })
            }
        })
    });
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