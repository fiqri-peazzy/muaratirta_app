<?php
include('../../path.php');
include(ROOT_PATH . '/app/controllers/users.php');
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
    <link href="../../assets/logo/Logo-PDAM-MT-min.ico" rel="icon">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
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
                        <div class="title">
                            <h4>Tambah User</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php echo BASE_URL . '/admin/' ?>">Beranda</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Tambah User
                                </li>
                            </ol>
                        </nav>
                    </div>

                </div>
            </div>
            <div class="card-box pd-20">
                <form action="<?php echo BASE_URL . '/admin/users/add-user-handler.php' ?>" enctype="multipart/form-data" method="post" id="add-user-form">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" placeholder="Nama Lengkap" name="nm_lengkap" id="" class="form-control">
                                <span class="text-danger error-text nm_lengkap_error"></span>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Username</label>
                                <input type="text" placeholder="Username" name="username" id="" class="form-control">
                                <span class="text-danger error-text username_error"></span>
                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" placeholder="Email" name="email" id="" class="form-control">
                                <span class="text-danger error-text email_error"></span>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">No Hp</label>
                                <input type="text" placeholder="No Hp" name="no_hp" id="" class="form-control">
                                <span class="text-danger error-text no_hp_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Profile Image</label>
                                <input type="file" name="profile_pict" id="" class="form-control">
                                <span class="text-danger error-text profile_pict_error"></span>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="" class="form-label">Level User</label>
                                <select name="level" id="" class="form-control">
                                    <option value="" selected>--Pilih</option>
                                    <option value="1" class="form-control">Administrator</option>
                                    <option value="2" class="form-control">CS</option>
                                    <option value="3" class="form-control">Arsip</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Password</label>
                                <input type="password" placeholder="password" name="password" id="" class="form-control">
                                <span class="text-danger error-text password_error"></span>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" placeholder="confirm password" name="confirm_password" id="" class="form-control">
                                <span class="text-danger error-text confirm_password_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group pl-3">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
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
        $('#add-user-form').on('submit', function(e) {
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