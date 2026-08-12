<?php include("../path.php"); ?>
<?php

include(ROOT_PATH . "/app/controllers/info.php");
include(ROOT_PATH . '/app/helpers/middleware.php');
adminOnly();

$all_publikasi = selectAll('informasi', [], 'tanggal_buat');


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
                            <h4>Informasi</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php echo BASE_URL . '/admin/?page-title=Dashboard-Admin' ?>">Beranda</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Informasi
                                </li>
                            </ol>
                        </nav>
                    </div>

                </div>
            </div>
            <div class="card-box pb-10">
                <div class="page-header mb-1">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 align-items-center">
                            <div class="title">
                                <h4 style="padding: 20px 0;">Pengaturan Publikasi</h4>
                            </div>


                        </div>
                        <div class="col-md-6 col-sm-12 align-items-center text-md-right">
                            <div class="btn-tambah ml-auto">
                                <a href="<?php echo BASE_URL . '/admin/informasi/tambah.php' ?>"
                                    class="btn btn-primary btn-lg"><i class="fa fa-plus"></i> Tambah</a>
                            </div>

                        </div>

                    </div>
                </div>


                <table class="data-table table nowrap" id="table">
                    <thead>
                        <tr>
                            <th class="table-plus">judul</th>
                            <th>deskripsi</th>
                            <th>Author</th>
                            <th>Gambar</th>
                            <th>Tanggal / Waktu</th>
                            <th>Tag</th>
                            <th class="datatable-nosort">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_publikasi as $i) : ?>
                        <tr id="_<?php echo $i['id'] ?>">
                            <td>
                                <?php echo substr($i['judul'], 0, 14) . '..' ?>
                            </td>
                            <td><?php echo substr($i['deskripsi'], 0, 20) . '..'; ?></td>
                            <td><?= $i['author'] ?></td>
                            <td><?php echo substr($i['image'], 0, 11) ?></td>
                            <td><?= $i['tanggal_buat'] ?></td>
                            <td>
                                <span class="badge badge-pill" data-bgcolor="#e7ebf5"
                                    data-color="#265ed7"><?= $i['tag'] ?></span>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="<?php echo BASE_URL . '/admin/informasi/edit.php?id=' . $i['id'] ?>"
                                        data-color="#265ed7"><i class="icon-copy dw dw-edit2"></i></a>
                                    <a id="hapus" class="hapus" data-id="<?= $i['id'] ?>" data-color="#e95959"><i
                                            class="icon-copy dw dw-delete-3"></i></a>
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
    <?php if (isset($_SESSION['message'])) : ?>
    <script>
    swal({
        title: '<?php echo $_SESSION['message'] ?>',

        type: '<?php echo $_SESSION['type'] ?>',
        showConfirmButton: true,
        timer: 3000,
    })
    <?php
            unset($_SESSION['message']);
            unset($_SESSION['type']);
            ?>
    </script>

    <?php endif; ?>

    <script>
    $(document).on('click', '.hapus', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var url = '<?php echo BASE_URL . '/admin/informasi.php?hapus=' ?>';
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
                        swal({
                            title: 'Berhasil hapus Data',
                            timer: 3000,
                            type: 'success',
                            showConfirmButton: true,
                        });

                        $('#_' + id).remove();

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