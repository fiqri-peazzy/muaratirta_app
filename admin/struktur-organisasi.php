<?php include("../path.php"); ?>
<?php

include(ROOT_PATH . "/app/controllers/struktur-organisasi.php");
include(ROOT_PATH . '/app/helpers/middleware.php');
adminOnly();

$bagian = selectAll('jabatan');

function getStaff()
{
    global $conn;
    $sql = 'SELECT s.*,j.bagian FROM staff as s INNER JOIN jabatan as j ON s.kd_bagian=j.kd_bagian';

    $stmt = $conn->prepare($sql);
    prepStmtForFetch($stmt);
    $stmt->execute();
    $records = stmtFetchAllAssoc($stmt);
    return $records;
}

?>

<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title>
        Pengaturan informasi | Admin Muaratirta
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
                            <h4>Struktur Organisasi</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php echo BASE_URL . '/admin/?page-title=Dashboard-Admin' ?>">Beranda</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Struktur Organisasi
                                </li>
                            </ol>
                        </nav>
                    </div>

                </div>
            </div>
            <div class="card-box pb-10">
                <div class="page-header mb-1 pb-0">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 align-items-center">
                            <div class="title">
                                <h4 style="padding: 20px 0;">Pengaturan Struktur Organisasi</h4>
                            </div>


                        </div>


                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6">

                        <a href="<?= BASE_URL . '/admin/struktur-organisasi/add-bagian.php' ?>"
                            class="btn btn-success btn-sm ml-2 mb-2"><i class="bi bi-plus"></i> Tambah</a>
                        <table class="table nowrap" id="table">
                            <thead>
                                <th>Kode Bagian</th>
                                <th>Bagian</th>
                                <th>Aksi</th>
                            </thead>

                            <tbody>
                                <?php foreach ($bagian as $bgn) : ?>
                                <tr>
                                    <td><?= $bgn['kd_bagian'] ?></td>
                                    <td><?= $bgn['bagian'] ?></td>
                                    <td>
                                        <div class="table-actions">
                                            <a href="<?= BASE_URL . '/admin/struktur-organisasi/edit-bagian.php?id=' . $bgn['kd_bagian'] ?>"
                                                data-color="#265ed7"><i class="icon-copy dw dw-edit2"></i></a>
                                            <a id="hapus" class="hapus" data-id="<?= $bgn['id'] ?>"
                                                data-color=" #e95959"><i class="icon-copy dw dw-delete-3"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-lg-8 col-md-6">

                        <div class="btn-tambah ml-auto mb-2">
                            <a href="<?= BASE_URL . '/admin/struktur-organisasi/add-staff.php' ?>"
                                class="btn btn-success btn-sm ml-2"><i class="bi bi-plus"></i> Tambah</a>
                        </div>
                        <div class="table table-responsive">
                            <table class="data-table table nowrap" id="table">
                                <thead>
                                    <th>Nama Lengkap</th>
                                    <th>Bagian</th>
                                    <th>Jabatan</th>
                                    <th>Aksi</th>
                                </thead>

                                <tbody>
                                    <?php foreach (getStaff() as $staff) : ?>
                                    <tr>
                                        <td><?= $staff['nm_lengkap'] ?></td>
                                        <td><?= $staff['bagian'] ?></td>
                                        <td><?= $staff['jabatan'] ?></td>
                                        <td>
                                            <div class="table-actions">
                                                <a href="<?= BASE_URL . '/admin/struktur-organisasi/edit-staff.php?id=' . $staff['id'] ?>"
                                                    data-color="#265ed7"><i class="icon-copy dw dw-edit2"></i></a>
                                                <a href="#" data-id="<?= $staff['id'] ?>" class="hapus-staff"
                                                    data-color=" #e95959"><i class="icon-copy dw dw-delete-3"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>


            </div>



        </div>
    </div>

    <?php include ROOT_PATH . '/admin/inc/scriptAdmin.php' ?>
    <script>
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
                    url: '<?= BASE_URL . '/admin/struktur-organisasi/delete-bagian.php' ?>',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        $(e.target).closest('tr').remove();

                        console.log(response);
                        toastr.success('Berhasil Hapus Data');

                    }
                })
            }
        })
    });
    </script>
    <script>
    $('.hapus-staff').on('click', function(e) {

        // e.preventDefault();
        var id = $(this).data('id');
        // alert(123);
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
                    url: '<?= BASE_URL . '/admin/struktur-organisasi/delete-staff-handler.php' ?>',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        $(e.target).closest('tr').remove();

                        console.log(response);
                        toastr.success('Berhasil Hapus Data');

                    }
                })
            }
        })
    });
    </script>
</body>

</html>