<?php

include('../../path.php');
include(ROOT_PATH . '/app/controllers/info.php');
include(ROOT_PATH . '/app/helpers/middleware.php');
require_once(ROOT_PATH . '/app/helpers/r2_helper.php');
adminOnly();
if (!empty($_GET['id']) && $_GET['id'] != null) {
    $id = $_GET['id'];
    $pengaduan = selectOne('pengaduan', ['id' => $id]);
    if ($pengaduan == null) {
        header('Location:' . BASE_URL . '/404');
    }
} else {
    header('Location:' . BASE_URL . '/404');
}

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
    .square {
        height: 200px;
        width: 200px;
        border: 1px solid black;
        margin-top: 12px;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 12px 0;
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
        <div class="xs-pd-20-10 pd-ltr-20 ">

            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Keluhan Pelanggan</h4>
                        </div>

                        <div class="status mt-2 d-flex align-items-center" data-pengaduan-id="<?= $pengaduan['id'] ?>">
                            <div class="date" style="padding-right: 27px ;">
                                <?= date('d M,Y', strtotime($pengaduan['created_at'])) ?> </div>
                            <span class="badge badge-<?= $pengaduan['status'] == 0 ? 'info' : 'success' ?>">
                                <?= $pengaduan['status'] == 0 ? 'Proses' : 'Selesai' ?>
                            </span>
                        </div>

                    </div>

                </div>
            </div>
            <div class="card-box pd-20 mb-5">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="form-label">ID Pelanggan</label>
                            <input type="text" name="" class="form-control" readonly
                                value="<?= $pengaduan['id_pel'] ?>">
                        </div>
                    </div>



                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="" class="form-label">Alamat</label>
                            <input type="text" readonly value="<?= $pengaduan['alamat'] ?>" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="form-label">Nama Pelanggan</label>
                            <input type="text" name="" class="form-control" readonly
                                value="<?= $pengaduan['nm_lengkap'] ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="" class="form-label">No HP</label>
                            <input type="text" readonly value="<?= $pengaduan['no_hp'] ?>" class="form-control">
                        </div>
                    </div>


                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="" class="form-label">Isi Pengaduan</label>
                            <input type="text" readonly value="<?= $pengaduan['isi_pengaduan'] ?>" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="" class="form-label">Foto</label>
                            <br>
                            <?php
                            if ($pengaduan['foto'] != null && $pengaduan['foto'] != '') {
                                $file_extension = strtolower(pathinfo($pengaduan['foto'], PATHINFO_EXTENSION));
                                $pengaduan_foto_url = resolveImageUrl($pengaduan['foto'], 'pengaduan', ['assets/keluhan', 'image/pengaduan']);
                                if (in_array($file_extension, ['jpg', 'jpeg', 'png']) && $pengaduan_foto_url !== '') { ?>
                            <a href="<?= $pengaduan_foto_url ?>">
                                <img src="<?= $pengaduan_foto_url ?>" alt=""
                                    class="img-fluid" width="300" height="300">
                            </a>
                            <?php } else { ?>
                            <div class="square">
                                <div class="center">
                                    <i class="fa fa-image"></i> Tidak ada gambar di temukan
                                </div>
                            </div>
                            <?php }
                            } else { ?>
                            <div class="square">
                                <div class="center">
                                    <i class="fa fa-image"></i> Tidak ada gambar di temukan
                                </div>
                            </div>
                            <?php } ?>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="form-group ml-2">
                        <a href="#" data-id="<?= $pengaduan['id'] ?>"
                            class="btn btn-primary update-status <?= $pengaduan['status'] == 1 ? 'd-none' : '' ?>"><i
                                class="fa fa-check"></i> Tandai Selesai</a>
                        <a href="#" data-id="<?= $pengaduan['id'] ?>"
                            class="btn btn-danger hapus <?= $pengaduan['status'] == 0 ? 'd-none' : '' ?>"><i
                                class="fa fa-trash"></i> Hapus </a>

                        <a href="<?= BASE_URL . '/admin/pengaduan/cetak_pengaduan.php?id=' . $pengaduan['id'] ?>"
                            target="_blank">
                            <button type="submit" class="btn btn-success" data-id="<?= $pengaduan['id'] ?>"><i
                                    class="fa fa-print"></i>
                                Cetak</button>
                        </a>
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
                    url: '<?= BASE_URL . '/admin/pengaduan/update-keluhan.php' ?>',
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
                        id: id
                    },
                    success: function(response) {
                        toastr.success('Berhasil Hapus Data');
                        window.location.href = '<?= BASE_URL . '/admin/pengaduan.php' ?>'
                    }
                })
            }
        })
    });
    </script>


</body>

</html>