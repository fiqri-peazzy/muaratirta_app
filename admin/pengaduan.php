<?php include("../path.php"); ?>
<?php

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

    $sql = "SELECT * FROM pengaduan " . $dateRange;
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $all_keluhan = stmtFetchAllAssoc($stmt);
    $head = ($selectedRange == 0 ? 'Keluhan Pelanggan' : ($selectedRange == 1 ? 'Keluhan hari ini' : ($selectedRange == 7 ? 'Keluhan Dari 7 Hari' : 'Keluhan Dari 30 Hari')));
} else {
    $all_keluhan = selectAll('pengaduan',[],'created_at');
    $head = 'Keluhan Pelanggan';
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
                            <h4>Keluhan Pelanggan</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php echo BASE_URL . '/admin/' ?>">Beranda</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Keluhan Pelanggan
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

                                    <a href="<?= BASE_URL . '/admin/pengaduan/detail.php?id=' . $i['id'] ?>" id="update"
                                        class="update" style="font-size: 1rem;cursor:pointer;"
                                        data-id="<?php echo $i['id'] ?>" data-color="#265ed7"><i class="dw dw-eye"></i>
                                        View</a>

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



</body>

</html>