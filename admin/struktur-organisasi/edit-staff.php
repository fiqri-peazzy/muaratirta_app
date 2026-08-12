<?php include('../../path.php');
include(ROOT_PATH . '/app/controllers/struktur-organisasi.php');

include(ROOT_PATH . '/app/helpers/middleware.php');
adminOnly();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $staff = selectOne('staff', ['id' => $id]);
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
        <?php echo isset($_GET['page-title']) && $_GET['page-title'] !== '' ? $_GET['page-title'] : 'Admin | Muaratirta Kota Gorontalo'; ?>
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
                                    <a href="<?php echo BASE_URL . '/admin/index.php' ?>">Beranda</a>
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
                <form method="post" action="<?= BASE_URL . '/admin/struktur-organisasi/edit-staff-handler.php' ?>"
                    enctype="multipart/form-data" id="edit-staff-form">
                    <input type="hidden" name="id" value="<?= $staff['id'] ?>">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">* Nama Lengkap</label>
                        <div class="col-lg-6">
                            <input class="form-control" type="text" value="<?= $staff['nm_lengkap'] ?>"
                                name="nm_lengkap">
                            <span class="text-danger error-text nm_lengkap_error"></span>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-form-label col-sm-2">* Bagian</label>
                        <div class="col-lg-6">
                            <select name="kd_bagian" id="" class="selectpicker form-control"
                                data-style="btn-outline-primary" data-size="5">
                                <option value="" selected disabled>--Pilih</option>
                                <?php foreach (selectAll('jabatan') as $bgn) : ?>
                                <option value="<?= $bgn['kd_bagian'] ?>"
                                    <?= $staff['kd_bagian'] === $bgn['kd_bagian'] ? 'selected' : '' ?>>
                                    <?= $bgn['bagian'] ?></option>
                                <?php endforeach; ?>

                            </select>
                            <span class="text-danger error-text kd_bagian_error"></span>


                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">* Jabatan</label>
                        <div class="col-lg-6">
                            <input class="form-control" value="<?= $staff['jabatan'] ?>" type="text" name="jabatan"
                                readonly>
                            <span class="text-danger error-text jabatan_error"></span>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-form-label col-sm-2">Profile Pict</label>
                        <div class="col-lg-6">

                            <input type="file" name="profile_pict" id="formFile">
                            <span class="text-danger error-text profile_pict_error"></span>

                            <!-- <button onclick="clearImage()" class="btn btn-danger mt-3">clear</button> -->

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 form-label d-none">Foto</label>
                        <img src="<?= $staff['profile_pict'] == '' ? '' : resolveImageUrl($staff['profile_pict'], 'staff', ['assets/staff']) ?>"
                            id="frame" alt="" class="img-fluid col-lg-4">
                    </div>

                    <div class="form-group row pl-2">
                        <button type="submit" class="btn btn-primary" name="edit-staff">Submit</button>
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
    <script src="../src/plugins/toastr/toastr.min.js"></script>


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

    <script>
    $('#edit-staff-form').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formData = new FormData(form);
        $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            cache: false,
            beforeSend: function() {
                toastr.remove();
                $(form).find('span.error-text').text('');
            },
            success: function(response) {
                if ($.isEmptyObject(response.error)) {
                    if (response.status == 1) {
                        $(form)[0].reset();
                        toastr.success(response.msg);
                    } else {
                        toastr.error(response.msg);
                    }
                } else {
                    $.each(response.error, function(profix, val) {
                        $(form).find('span.' + profix + '_error').text(val);

                    });
                }
            }
        })

    })
    </script>

</body>

</html>