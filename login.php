<?php
include('path.php');
include(ROOT_PATH . '/app/controllers/users.php');
require_once(ROOT_PATH . '/app/helpers/middleware.php');
guestsOnly('/admin/');
?>

<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title>Login Admin | Muaratirta</title>

    <link rel="icon" type="image/png" sizes="32x32" href="assets/logo/Logo-PDAM-MT-min.ico" />
    <!-- <link rel="icon" type="image/png" sizes="16x16" href="vendors/images/favicon-16x16.png" /> -->

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="admin/vendors/styles/core.css" />
    <link rel="stylesheet" type="text/css" href="admin/vendors/styles/icon-font.min.css" />
    <link rel="stylesheet" type="text/css" href="admin/vendors/styles/style.css" />
    <link rel="stylesheet" href="admin/src/plugins/toastr/toastr.min.css">

</head>

<body class="login-page">

    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-7">
                    <img src="admin/vendors/images/login-page-img.png" alt="" />
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="login-box bg-white box-shadow border-radius-10">
                        <div class="d-flex justify-content-center align-items-center mb-4">
                            <a href="<?php echo BASE_URL . '/' ?>"><img src="assets/image/download.svg" alt=""></a>

                        </div>
                        <div class="login-title">
                            <h2 class="text-center" style="color:#007aff;">Login</h2>
                        </div>
                        <form method="post">
                            <div class="input-group custom">
                                <input type="text" name="u_name" class="form-control form-control-lg"
                                    placeholder="username" />
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                                </div>
                            </div>
                            <div class="input-group custom">
                                <input type="password" name="pass" class="form-control form-control-lg"
                                    placeholder="password" />
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                                </div>
                            </div>
                            <div class="row pb-30">
                                <div class="col-6">

                                </div>
                                <div class="col-6">
                                    <div class="forgot-password">
                                        <a href="<?= BASE_URL . '/forgot-password' ?>">Lupa Password</a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input-group mb-0">
                                        <button class="btn btn-primary btn-lg btn-block" name="loginAdmin"
                                            type="submit">Sign
                                            In</button>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- js -->
    <script src="admin/vendors/scripts/core.js"></script>
    <script src="admin/vendors/scripts/script.min.js"></script>
    <script src="admin/vendors/scripts/process.js"></script>
    <script src="admin/vendors/scripts/layout-settings.js"></script>
    <script src="admin/src/plugins/toastr/toastr.min.js"></script>
    <script>
    <?php if (count($errors) > 0) : ?>
    <?php if (isset($errors['username'])) : ?>
    toastr.error('<?= $errors['username'] ?>')

    <?php elseif (isset($errors['password'])) :  ?>
    toastr.error('<?= $errors['password'] ?>')

    <?php endif; ?>

    <?php endif; ?>
    </script>


</body>

</html>