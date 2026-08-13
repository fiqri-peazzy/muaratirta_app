<?php
include('../path.php');
include(ROOT_PATH . "/app/controllers/users.php");
include(ROOT_PATH . '/app/helpers/middleware.php');
adminOnly();

if (isset($_GET['range'])) {
    $selectedRange = $_GET['range'];
    switch ($selectedRange) {
        case '7':
            $dateRange = "WHERE created_at >= CURDATE() - INTERVAL 7 DAY";
            break;
        case '30':
            $dateRange = "WHERE created_at >= CURDATE() - INTERVAL 30 DAY";
            break;
        case '1':
            $dateRange = "WHERE DATE(created_at) = CURRENT_DATE";
            break;
        default:
            $dateRange = "";
            break;
    }

    $sql = "SELECT * FROM pasang_baru " . $dateRange;
    $stmt = $conn->prepare($sql);
    prepStmtForFetch($stmt);
    $stmt->execute();
    $all_pasang_baru = stmtFetchAllAssoc($stmt);
    $head = ($selectedRange == 0 ? 'Pendaftaran SB Pelanggan' : ($selectedRange == 1 ? 'Pendftaran SB hari ini' : ($selectedRange == 7 ? 'Pendftaran SB Dari 7 Hari' : 'Pendftaran SB Dari 30 Hari')));
} else {
    $all_pasang_baru = selectAll('pasang_baru',[],'created_at');
    $head = 'Pendaftaran SB';
}

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
        <div class="xs-pd-20-10 pd-ltr-20">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Pendaftaran Pemasangan Baru</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php echo BASE_URL . '/admin/?page-title=Dashboard-Admin' ?>">Beranda</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Pendaftaran Pemasangan Baru
                                </li>
                            </ol>
                        </nav>
                    </div>

                </div>
            </div>
            <div class="card-box pb-10">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="h5 pd-20 mb-0"><?php echo $head; ?></div>

                    </div>

                    <div class="col-md-6 col-sm-12 mb-2">
                        <div class="d-flex justify-content-between align-items-center float-md-right">
                            <form method="get" action="<?= BASE_URL . '/admin/pasang-baru.php' ?>" class="d-flex p-3">

                                <select name="range" class="form-control mr-2" id="selected_range">
                                    <option <?= isset($_GET['range']) && $_GET['range'] == 0 ? 'selected' : '' ?> value="0">Semua Data</option>
                                    <option <?= isset($_GET['range']) && $_GET['range'] == 1 ? 'selected' : '' ?> value="1">Hari ini</option>
                                    <option <?= isset($_GET['range']) && $_GET['range'] == 7 ? 'selected' : '' ?> value="7">7 Hari</option>
                                    <option <?= isset($_GET['range']) && $_GET['range'] == 30 ? 'selected' : '' ?> value="30">30 Hari</option>
                                </select>

                                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                            </form>
                        </div>
                    </div>

                </div>
                <table class="data-table table nowrap" id="table-1">
                    <thead>
                        <tr>
                            <th class="table-plus">id</th>
                            <th>alamat</th>
                            <th>tanggal / waktu</th>
                            <th>Foto Ktp</th>
                            <th>Foto Rumah</th>
                            <th>status</th>
                            <th class="datatable-nosort">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($all_pasang_baru as $i) : ?>
                            <tr>
                                <td>
                                    <?php echo $no++ ?>
                                </td>
                                <td><?php echo substr($i['alamat'], 0, 12) . '..' ?></td>
                                <td><?php echo date('d M,Y', strtotime($i['created_at'])) ?></td>
                                <td><?php echo substr($i['foto_ktp'], 0, 12) . '..' ?></td>
                                <td><?php echo substr($i['foto_rumah'], 0, 12) . '..' ?></td>
                                <td>
                                    <span class="badge badge-pill" data-bgcolor="#e7ebf5" data-color="#265ed7"><?php echo ($i['tindak_lanjut']) == 0 ? 'Proses' : 'selesai' ?></span>
                                </td>

                                <td>
                                    <div class="table-actions">
                                        <a href="<?php echo BASE_URL . '/admin/pasang-baru/detail.php?id=' . $i['id'] ?>" data-color="#265ed7" style="font-size: 1rem;"><i class="icon-copy dw dw-eye"></i> View
                                        </a>



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
        $(document).on('click', '.update', function(e) {

            e.preventDefault();

            swal({
                title: 'Tandai telah selesai ?',
                // text: 'You won\'t be able to revert this!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Konfirmasi'

            }).then(function(isConfirmed) {
                if (isConfirmed.value) {
                    var id = $('.update').data('id');

                    $.ajax({
                        method: 'POST',
                        url: '<?php echo BASE_URL . '/admin/pasang-baru/update-p-baru.php' ?>',
                        data: {
                            id: id
                        },
                        success: function(response) {
                            swal('', 'Berhasil Update Data', 'success');
                            setTimeout(function() {
                                window.location.href =
                                    '<?php echo BASE_URL . '/admin/pasang-baru.php' ?>'
                            }, 3000)
                        }
                    })

                }
            })


        })
        $(document).on('click', '#hapus', function(e) {

            e.preventDefault();
            var id = $(this).data('id');
            swal({
                title: 'Hapus data ?',
                text: 'You won\'t be able to revert this!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Konfirmasi'
            }).then(function(isConfirmed) {
                if (isConfirmed.value) {
                    $.ajax({
                        method: 'POST',
                        url: '<?php echo BASE_URL . '/admin/pengaduan/hapus-keluhan.php' ?>',
                        data: {
                            id_p: id
                        },
                        success: function(response) {
                            $(e.target).closest('tr').remove();
                            swal({
                                title: 'Berhasil Menghapus Data',
                                timer: 3000,
                                type: 'success',
                                showConfirmButton: true,
                            });

                        }
                    })
                }
            })

        })
    </script>

</body>

</html>