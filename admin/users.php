<?php
include("../path.php");

include(ROOT_PATH . "/app/controllers/users.php");
include(ROOT_PATH . '/app/helpers/middleware.php');
adminOnly();
$all_user = selectAll('users');

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

            <div class="card-box pb-10">
                <div class="page-header mb-1">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 align-items-center">
                            <div class="title">
                                <h4 style="padding: 20px 0;">Pengaturan Data User</h4>
                            </div>


                        </div>
                        <div class="col-md-6 col-sm-12 align-items-center text-md-right">
                            <div class="btn-tambah ml-auto">
                                <a href="<?= BASE_URL . '/admin/users/add-user.php' ?>" class="btn btn-success"><i
                                        class="fa fa-plus"></i> Tambah User</a>
                            </div>

                        </div>

                    </div>
                </div>
                <table class="data-table table stripe hover nowrap">
                    <thead>
                        <tr>
                            <th class="table-plus datatable-nosort">Nama</th>
                            <!-- <th>Jabatan</th> -->
                            <th>Username</th>
                            <th>Level</th>
                            <th>Status</th>
                            <th class="datatable-nosort">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_user as $user) : ?>
                        <tr>
                            <td class="table-plus"><?= $user['nm_lengkap'] ?></td>
                            <!-- <td>...</td> -->
                            <td><?= $user['username'] ?></td>
                            <td><?= $user['level'] == 1 ? 'Administrator' : ($user['level'] == 2 ? 'Customer Service' : ($user['level'] == 3 ? 'Arsip' : '')); ?>
                            </td>
                            <td> tidak aktif</td>
                            <td>
                                <div class="dropdown">
                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#"
                                        role="button" data-toggle="dropdown">
                                        <i class="dw dw-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">

                                        <a class="dropdown-item hapus" data-id="<?= $user['id'] ?>" href="#"><i
                                                class="dw dw-delete-3"></i>
                                            Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <?php include ROOT_PATH . '/admin/inc/scriptAdmin.php' ?>

    <script>
    $(document).on('click', '.hapus', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var url = '<?php echo BASE_URL . '/admin/users/delete-user-handler.php?id=' ?>';
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
                        $(e.target).closest('tr').remove();

                        swal({
                            title: 'Berhasil hapus Data',
                            // timer: 3000,
                            type: 'success',
                            showConfirmButton: true,
                        });



                    },
                    error: function(error) {
                        // Handle error
                        swal('Error!', 'There was an error while deleting.',
                            'error');
                    }
                });
            }
        });

    });
    </script>
</body>

</html>