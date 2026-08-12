<?php
include('path.php');
include(ROOT_PATH . '/app/controllers/users.php');

?>

<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title>Forgot Password Admin | Muaratirta</title>

    <link rel="icon" type="image/png" sizes="32x32" href="assets/logo/Logo-PDAM-MT-min.ico" />
    <!-- <link rel="icon" type="image/png" sizes="16x16" href="vendors/images/favicon-16x16.png" /> -->

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="admin/vendors/styles/core.css" />
    <link rel="stylesheet" type="text/css" href="admin/vendors/styles/icon-font.min.css" />
    <link rel="stylesheet" type="text/css" href="admin/vendors/styles/style.css" />
    <link rel="stylesheet" href="admin/src/plugins/toastr/toastr.min.css">

</head>

<body class="login-page">

    <div class="login-header box-shadow">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="brand-logo">
                <a href="<?= BASE_URL . '/' ?>">
                    <img src="<?= BASE_URL . '/assets/image/download.svg' ?>" alt="" />
                </a>
            </div>
            <div class="login-menu">
                <ul>
                    <li><a href="<?= BASE_URL . '/login' ?>">Login</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <img src="<?= BASE_URL . '/assets/image/forgot-password.png' ?>" alt="" />
                </div>
                <div class="col-md-6">
                    <div class="login-box bg-white box-shadow border-radius-10">
                        <div class="login-title">
                            <h2 class="text-center text-primary">Forgot Password</h2>
                        </div>
                        <h6 class="mb-20">
                            Enter your email address to reset your password
                        </h6>
                        <form method="post">
                            <div class="input-group custom">
                                <input type="email" class="form-control form-control-lg" name="email" placeholder="Email" />
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-5">
                                    <div class="input-group mb-0">

                                        <input class="btn btn-primary btn-lg btn-block" name="forgot-password-form" type="submit" value="Submit">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="font-16 weight-600 text-center" data-color="#707373">
                                        OR
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="input-group mb-0">
                                        <a class="btn btn-outline-primary btn-lg btn-block" href="<?= BASE_URL . '/login' ?>">Login</a>
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

    <?php if (isset($_SESSION['message'])) : ?>
        <script>
            toastr.<?= $_SESSION['type'] ?>('<?= $_SESSION['message'] ?>');
        </script>

        <?php unset($_SESSION['message']) ?>
    <?php endif; ?>



    <?php if (count($errors) > 0) : ?>
        <script>
            toastr.error('<?= $errors['email'] ?>');
        </script>

    <?php endif; ?>

</body>

</html>