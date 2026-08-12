<?php
include("../path.php");
include(ROOT_PATH . "/app/controllers/users.php");
include(ROOT_PATH . '/app/helpers/middleware.php');
adminOnly();

?>

<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title>
        <?php echo isset($_GET['page-title']) && $_GET['page-title'] !== '' ? htmlspecialchars($_GET['page-title']) : 'Beranda | Muaratirta Kota Gorontalo'; ?>
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
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="title">
                                <h4>Profile</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="<?= BASE_URL . '/admin/index.php' ?>">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Profile
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
                        <div class="pd-20 card-box height-100-p">
                            <div class="profile-photo">
                                <a href="javascript:;" onclick="event.preventDefault();document.getElementById('user_profile_file').click();" class="edit-avatar"><i class="fa fa-pencil"></i></a>
                                <input type="file" name="user_profile_file" id="user_profile_file" class="d-none" style="opacity: 0;">
                                <img src="<?php echo empty(getUser()['profile_pict']) ?  BASE_URL . '/assets/image/default-user.jpg' :  resolveImageUrl(getUser()['profile_pict'], 'profile', ['assets/profile-pict']) ?>" alt="" class="avatar-photo ci-avatar-photo" />

                            </div>
                            <h5 class="text-center h5 mb-0 ci-user-name"><?= getUser()['username'] ?></h5>
                            <p class="text-center text-muted font-14 ci-user-email">
                                <?= getUser()['email'] ?>
                            </p>

                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
                        <div class="card-box height-100-p overflow-hidden">
                            <div class="profile-tab height-100-p">
                                <div class="tab height-100-p">
                                    <ul class="nav nav-tabs customtab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#profile-info" role="tab">Profile Info</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#changePassword" role="tab">Ganti
                                                Password</a>
                                        </li>

                                    </ul>
                                    <div class="tab-content">
                                        <!-- profile-info Tab start -->
                                        <div class="tab-pane fade show active" id="profile-info" role="tabpanel">
                                            <div class="pd-20">
                                                <div class="profile-timeline">
                                                    <form id="update-profile" method="post" action="<?php echo BASE_URL . '/admin/profile/upd-personal-detail.php' ?>">

                                                        <div class="row">

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label">Nama Lengkap</label>
                                                                    <input type="text" name="nm_lengkap" value="<?php echo getUser()['nm_lengkap'] ?>" id="" class="form-control">
                                                                </div>

                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label">Username</label>
                                                                    <input type="text" value="<?php echo getUser()['username'] ?>" name="username" id="" class="form-control">
                                                                    <span class="text-danger error-text username_error"></span>

                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="row">

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label">Email</label>
                                                                    <input type="email" name="email" value="<?= getUser()['email'] ?>" id="" class="form-control">
                                                                    <span class="text-danger error-text email_error"></span>


                                                                </div>

                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label">No Hp</label>
                                                                    <input type="text" name="no_hp" value="<?= getUser()['no_hp'] ?>" id="" class="form-control">
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <!-- <div class="row">

                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Bio</label>
                                                                    <textarea name="bio" class="form-control"
                                                                        placeholder="Bio..."><?php (getUser()['bio'] == null ? 'Bio..' : getUser()['bio']) ?></textarea>

                                                                </div>
                                                            </div>
                                                        </div> -->
                                                        <div class="row">


                                                            <div class="form-group">
                                                                <button type="submit" class="btn btn-primary">Submit</button>


                                                            </div>

                                                        </div>

                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- Timeline Tab End -->
                                        <!-- changePassword Tab start -->
                                        <div class="tab-pane fade" id="changePassword" role="tabpanel">
                                            <div class="pd-20 profile-task-wrap">
                                                <div class="container pd-0">
                                                    <!-- Open Task start -->

                                                    <div class="profile-task-list pb-30">
                                                        <form id="change-password-form" action="<?php echo BASE_URL . '/admin/profile/change-password.php'; ?>" method="post">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="">Current Password</label>
                                                                        <input type="password" name="current_password" id="" class="form-control" placeholder="Enter Current Password">
                                                                        <span class="text-danger error-text current_password_error"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="">New Password</label>
                                                                        <input type="password" name="new_password" id="" class="form-control" placeholder="Enter new Password">
                                                                        <span class="text-danger error-text new_password_error"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="">Confirm Password</label>
                                                                        <input type="password" name="confirm_password" id="" class="form-control" placeholder="Confirm Password">
                                                                        <span class="text-danger error-text confirm_password_error"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <button type="submit" class="btn btn-primary">Change
                                                                        Password</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php include ROOT_PATH . '/admin/inc/scriptAdmin.php' ?>

    <script>
        $('#user_profile_file').ijaboCropTool({
            preview: '.ci-avatar-photo',
            setRatio: 1,
            allowedExtensions: ['jpg', 'jpeg', 'png'],
            processUrl: '<?php echo BASE_URL . '/admin/profile/update-profile-pict.php'; ?>',

            onSuccess: function(message, element, status) {
                if (status == 1) {
                    toastr.success(message);
                } else {
                    toastr.error(message);
                }
            },
            onError: function(message, element, status) {
                alert(message);
            }

        });

        $('#update-profile').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            var formData = new FormData(form);
            // alert(123);

            $.ajax({
                url: $(form).attr('action'),
                type: $(form).attr('method'),
                data: formData,
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    toastr.remove();
                    $(form).find('span.error-text').text('');
                },
                success: function(response) {
                    if ($.isEmptyObject(response.error)) {
                        if (response.status == 1) {
                            $('.ci-user-name').html(response.user_info.username);
                            $('.ci-user-email').html(response.user_info.email);
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
        });

        $('#change-password-form').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            var form_data = new FormData(form);

            // request->ajax
            $.ajax({
                url: $(form).attr('action'),
                type: $(form).attr('method'),
                data: form_data,
                processData: false,
                contentType: false,
                dataType: 'json',
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