<?php include('../path.php') ?>
<?php include(ROOT_PATH . '/app/controllers/users.php'); ?>

<?php

include(ROOT_PATH . '/app/helpers/middleware.php');
adminOnly();
date_default_timezone_set('Asia/Jakarta');
$now = date_create('now')->format('Y-m-d');


$all_pasang_baru = selectAll('pasang_baru',[],'created_at');

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

    $sql = "SELECT * FROM pengaduan " . $dateRange;
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $all_keluhan = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $head = ($selectedRange == 0 ? 'Keluhan Pelanggan' : ($selectedRange == 1 ? 'Keluhan hari ini' : ($selectedRange == 7 ? 'Keluhan Dari 7 Hari' : 'Keluhan Dari 30 Hari')));
    // header('Location:' . BASE_URL . '/admin/index.php');
    // exit();
} else {
    $all_keluhan = selectAll('pengaduan',[],'created_at');
    $head = 'Keluhan Pelanggan';

    $all_publikasi = selectAll('informasi', [], 'tanggal_buat');
}


?>
<?php adminOnly(); ?>
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

    <?php include(ROOT_PATH . '/admin/inc/styleAdmin.php'); ?>
</head>

<body>
    <!-- <div class="pre-loader">
        <div class="pre-loader-box">
            <div class="loader-logo">
                <img src="../assets/image/download.svg" alt="" />
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
            <div class="row pb-10">
                <div class="col-xl-4 col-lg-4 col-md-6 mb-20">
                    <div class="card-box height-100-p widget-style3">
                        <div class="d-flex flex-wrap">
                            <div class="widget-data">
                                <div class="weight-700 font-16 text-dark">Welcome Back, <?= getUser()['nm_lengkap'] ?>
                                </div>
                                <div class="font-14 text-secondary weight-500">
                                    <?= $now; ?>
                                </div>
                                <span class="badge badge-info pt-2 pb-2 mt-2">
                                    <?= getUser()['level'] == 1 ? 'Administrator' : (getUser()['level'] == 2 ? 'CS' : (getUser()['level'] == 3 ? 'Arsip' : ''))  ?>
                                </span>
                            </div>
                            <!-- <div class="widget-icon">
                                <div class="icon" data-color="#1b00ff">
                                    <span class="icon-copy ti-user"></span>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 mb-20">
                    <div class="card-box height-100-p widget-style3">
                        <div class="d-flex flex-wrap">
                            <div class="widget-data">
                                <div class="weight-700 font-24 text-dark"><?php echo count($all_keluhan) ?></div>
                                <div class="font-14 text-secondary weight-500">
                                    Total Pengaduan
                                </div>
                            </div>
                            <div class="widget-icon">
                                <div class="icon" data-color="#00eccf">
                                    <i class="icon-copy ti-face-sad"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-6 mb-20">
                    <div class="card-box height-100-p widget-style3">
                        <div class="d-flex flex-wrap">
                            <div class="widget-data">
                                <div class="weight-700 font-24 text-dark"><?php echo count($all_pasang_baru) ?></div>
                                <div class="font-14 text-secondary weight-500">
                                    Permintaan Pemasangan Baru
                                </div>
                            </div>
                            <div class="widget-icon">
                                <div class="icon">
                                    <i class="icon-copy ti-receipt" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="card-box pb-10">
                <?php if (getUser()['level'] == 1 || getUser()['level'] == 2) : ?>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="h5 pd-20 mb-0"><?php echo $head; ?></div>

                    </div>

                    <div class="col-md-6 col-sm-12 mb-2">
                        <div class="d-flex justify-content-between align-items-center float-md-right">
                            <form method="get" action="<?= BASE_URL . '/admin/pengaduan.php' ?>" class="d-flex p-3">

                                <select name="range" class="form-control mr-2" id="selected_range">
                                    <option <?= isset($_GET['range']) && $_GET['range'] == 0 ? 'selected' : '' ?>
                                        value="0">Semua Data</option>
                                    <option <?= isset($_GET['range']) && $_GET['range'] == 1 ? 'selected' : '' ?>
                                        value="1">Hari ini</option>
                                    <option <?= isset($_GET['range']) && $_GET['range'] == 7 ? 'selected' : '' ?>
                                        value="7">7 Hari</option>
                                    <option <?= isset($_GET['range']) && $_GET['range'] == 30 ? 'selected' : '' ?>
                                        value="30">30 Hari</option>
                                </select>

                                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                            </form>
                        </div>
                    </div>

                </div>

                <table class="data-table table stripe hover nowrap" id="table">

                    <thead>
                        <tr>
                            <th class="table-plus">ID Pelanggan</th>
                            <th>Nama Lengkap</th>
                            <th>Alamat</th>
                            <th>No HP</th>
                            <th>Isi Pengaduan</th>
                            <th>Tgl / Waktu</th>
                            <th>Status</th>
                            <th class="datatable-nosort">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_keluhan as $i) : ?>
                        <tr>
                            <td class="table-plus"><?= $i['id_pel'] ?></td>
                            <td><?= $i['nm_lengkap'] ?></td>
                            <td><?= $i['alamat'] ?></td>
                            <td><?= $i['no_hp'] ?></td>
                            <td><?= $i['isi_pengaduan'] ?></td>
                            <td><?php echo date('d M,Y', strtotime($i['created_at'])) ?></td>
                            <td>
                                <span class="badge badge-pill" data-bgcolor="#e7ebf5"
                                    data-color="#265ed7"><?php echo ($i['status']) == 0 ? 'Proses' : 'selesai' ?></span>

                            </td>
                            <td>

                                <div class="table-actions">

                                    <a href="<?= BASE_URL . '/admin/pengaduan/detail.php?id=' . $i['id'] ?>" id="view"
                                        class="view" style="font-size: 1rem;cursor:pointer;"
                                        data-id="<?php echo $i['id'] ?>" data-color="#265ed7"><i class="dw dw-eye"></i>
                                        View</a>

                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else : ?>
                <div class="page-header mb-1">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 align-items-center">
                            <div class="title">
                                <h4 style="padding: 20px 0;">Beranda Arsip</h4>
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
                            <!--<th class="datatable-nosort">Aksi</th>-->
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
                            <!--<td>-->
                            <!--    <div class="table-actions">-->
                            <!--        <a href="<?php echo BASE_URL . '/admin/informasi/edit.php?id=' . $i['id'] ?>"-->
                            <!--            data-color="#265ed7"><i class="icon-copy dw dw-edit2"></i></a>-->
                            <!--        <a id="hapus" class="hapus" data-id="<?= $i['id'] ?>" data-color="#e95959"><i-->
                            <!--                class="icon-copy dw dw-delete-3"></i></a>-->
                            <!--    </div>-->
                            <!--</td>-->
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>


                <?php endif; ?>
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
                    url: '<?php echo BASE_URL . '/admin/update-keluhan.php' ?>',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        swal({
                            title: 'Berhasil Update Data',
                            timer: 3000,
                            type: 'success',
                            showConfirmButton: true,
                        });
                        setTimeout(function() {
                            window.location.href =
                                '<?php echo BASE_URL . '/admin/pengaduan.php' ?>'
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
            title: 'Hapus Data ?',
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
                    url: '<?php echo BASE_URL . '/admin/hapus-keluhan.php' ?>',
                    data: {
                        id: id
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