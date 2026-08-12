<?php

include('../../path.php');
include(ROOT_PATH . '/app/controllers/info.php');
include(ROOT_PATH . '/app/helpers/middleware.php');
require_once(ROOT_PATH . '/app/helpers/r2_helper.php');
adminOnly();
if (!empty($_GET['id']) && $_GET['id'] != null) {
    $id = $_GET['id'];
    $pengaduan = selectOne('pengaduan', ['id' => $id]);
    if ($pengaduan == null) {
        header('Location:' . BASE_URL . '/404');
        exit();
    }
} else {
    header('Location:' . BASE_URL . '/404');
    exit();
}

$no_pengaduan = 'PG-' . str_pad($pengaduan['id'], 5, '0', STR_PAD_LEFT);
$foto_url = '';
if (!empty($pengaduan['foto'])) {
    $file_extension = strtolower(pathinfo($pengaduan['foto'], PATHINFO_EXTENSION));
    if (in_array($file_extension, ['jpg', 'jpeg', 'png'])) {
        $foto_url = resolveImageUrl($pengaduan['foto'], 'pengaduan', ['assets/keluhan', 'image/pengaduan']);
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title>
        <?php echo isset($_GET['page-title']) && $_GET['page-title'] !== '' ? htmlspecialchars($_GET['page-title']) : 'Detail Pengaduan | Muaratirta Kota Gorontalo'; ?>
    </title>

    <!-- Site favicon -->
    <link href="../../assets/logo/Logo-PDAM-MT-min.ico" rel="icon">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="../vendors/styles/core.css" />
    <link rel="stylesheet" type="text/css" href="../vendors/styles/icon-font.min.css" />
    <link rel="stylesheet" type="text/css" href="../src/plugins/datatables/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="../src/plugins/datatables/css/responsive.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="../vendors/styles/style.css" />
    <link rel="stylesheet" href="../src/plugins/sweetalert2/sweetalert2.css">
    <link rel="stylesheet" href="../src/plugins/toastr/toastr.min.css">

    <style>
    .pg-card {
        border: 1px solid #eef0f3;
        border-radius: 10px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 1px 3px rgba(20, 30, 60, 0.05);
        height: 100%;
    }

    .pg-card-header {
        background: #f6f8fb;
        border-bottom: 1px solid #eef0f3;
        padding: 8px 14px;
        font-weight: 600;
        font-size: 13px;
        color: #465468;
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .pg-card-body {
        padding: 14px;
    }

    .pg-info-row {
        display: flex;
        align-items: flex-start;
        padding: 7px 0;
        border-bottom: 1px dashed #eef0f3;
    }

    .pg-info-row:last-child {
        border-bottom: none;
    }

    .pg-info-icon {
        width: 28px;
        height: 28px;
        border-radius: 7px;
        background: #eef3fb;
        color: #1c3f7c;
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-right: 10px;
    }

    .pg-info-label {
        font-size: 11px;
        color: #8a94a6;
        margin-bottom: 1px;
    }

    .pg-info-value {
        font-size: 13px;
        font-weight: 500;
        color: #2b3648;
        word-break: break-word;
    }

    .pg-photo-frame {
        width: 100%;
        height: 220px;
        border: 1px solid #eef0f3;
        border-radius: 8px;
        background: #f9fafb;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .pg-photo-frame img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .pg-photo-empty {
        text-align: center;
        color: #b0b8c4;
        font-size: 12px;
    }

    .pg-photo-empty i {
        font-size: 26px;
        display: block;
        margin-bottom: 6px;
    }

    .pg-no-pengaduan {
        font-size: 17px;
        font-weight: 700;
        color: #1c3f7c;
        letter-spacing: 0.5px;
    }

    .pg-badge {
        font-size: 11px;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 30px;
    }

    .pg-isi-box {
        background: #f9fafb;
        border: 1px solid #eef0f3;
        border-radius: 8px;
        padding: 12px 14px;
        font-size: 13px;
        color: #2b3648;
        white-space: pre-line;
        word-break: break-word;
    }
    </style>
</head>

<body>

    <?php include ROOT_PATH . '/admin/inc/headerAdmin.php' ?>

    <?php include ROOT_PATH . '/admin/inc/rightSidebar.php' ?>
    <?php include ROOT_PATH . '/admin/inc/leftSidebar.php' ?>



    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div class="xs-pd-20-10 pd-ltr-20">

            <!-- ===== HEADER ===== -->
            <div class="page-header mb-3">
                <div class="row align-items-center">
                    <div class="col-md-7 col-sm-12">
                        <div class="title">
                            <h4 class="mb-1">Detail Pengaduan</h4>
                        </div>
                        <div class="d-flex align-items-center flex-wrap" style="gap:12px;"
                            data-pengaduan-id="<?= $pengaduan['id'] ?>">
                            <span class="pg-no-pengaduan"><?= $no_pengaduan ?></span>
                            <span class="pg-badge badge-<?= $pengaduan['status'] == 0 ? 'info' : 'success' ?>"
                                data-status-badge>
                                <?= $pengaduan['status'] == 0 ? 'Proses' : 'Selesai' ?>
                            </span>
                            <span class="text-muted" style="font-size:12px;">
                                <i class="fa fa-calendar"></i>
                                <?= date('d M Y, H:i', strtotime($pengaduan['created_at'])) ?>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-12 text-md-right mt-3 mt-md-0">
                        <a href="<?= BASE_URL . '/admin/pengaduan/cetak_pengaduan.php?id=' . $pengaduan['id'] ?>"
                            target="_blank" class="btn btn-primary">
                            <i class="fa fa-print"></i> Cetak PDF
                        </a>
                        <a href="#" data-id="<?= $pengaduan['id'] ?>"
                            class="btn btn-primary update-status <?= $pengaduan['status'] == 1 ? 'd-none' : '' ?>">
                            <i class="fa fa-check"></i> Tandai Selesai
                        </a>
                        <a href="#" data-id="<?= $pengaduan['id'] ?>"
                            class="btn btn-danger hapus <?= $pengaduan['status'] == 0 ? 'd-none' : '' ?>">
                            <i class="fa fa-trash"></i> Hapus
                        </a>
                    </div>
                </div>
            </div>

            <!-- ===== DATA PELANGGAN + ISI KELUHAN ===== -->
            <div class="row">
                <div class="col-lg-5 col-12 mb-3">
                    <div class="pg-card">
                        <div class="pg-card-header"><i class="fa fa-user-circle"></i> Data Pelanggan</div>
                        <div class="pg-card-body">
                            <div class="pg-info-row">
                                <div class="pg-info-icon"><i class="fa fa-id-card"></i></div>
                                <div>
                                    <div class="pg-info-label">No. Sambungan (ID Pelanggan)</div>
                                    <div class="pg-info-value"><?= htmlspecialchars($pengaduan['id_pel']) ?></div>
                                </div>
                            </div>
                            <div class="pg-info-row">
                                <div class="pg-info-icon"><i class="fa fa-user"></i></div>
                                <div>
                                    <div class="pg-info-label">Nama Lengkap</div>
                                    <div class="pg-info-value"><?= htmlspecialchars($pengaduan['nm_lengkap']) ?></div>
                                </div>
                            </div>
                            <div class="pg-info-row">
                                <div class="pg-info-icon"><i class="fa fa-phone"></i></div>
                                <div>
                                    <div class="pg-info-label">No. HP / WhatsApp</div>
                                    <div class="pg-info-value"><?= htmlspecialchars($pengaduan['no_hp']) ?></div>
                                </div>
                            </div>
                            <div class="pg-info-row">
                                <div class="pg-info-icon"><i class="fa fa-map-marker"></i></div>
                                <div>
                                    <div class="pg-info-label">Alamat</div>
                                    <div class="pg-info-value"><?= htmlspecialchars($pengaduan['alamat']) ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 col-12 mb-3">
                    <div class="pg-card">
                        <div class="pg-card-header"><i class="fa fa-comment"></i> Isi Keluhan</div>
                        <div class="pg-card-body">
                            <div class="pg-isi-box"><?= htmlspecialchars($pengaduan['isi_pengaduan']) ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===== DOKUMENTASI ===== -->
            <div class="row">
                <div class="col-lg-6 col-12 mb-3">
                    <div class="pg-card">
                        <div class="pg-card-header"><i class="fa fa-image"></i> Foto Bukti</div>
                        <div class="pg-card-body">
                            <div class="pg-photo-frame">
                                <?php if ($foto_url !== '') : ?>
                                <a href="<?= $foto_url ?>" target="_blank" title="Lihat ukuran penuh">
                                    <img src="<?= $foto_url ?>" alt="Foto Pengaduan">
                                </a>
                                <?php else : ?>
                                <div class="pg-photo-empty"><i class="fa fa-image"></i>Tidak ada foto</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="../vendors/scripts/core.js"></script>
    <script src="../vendors/scripts/script.min.js"></script>
    <script src="../vendors/scripts/process.js"></script>
    <script src="../vendors/scripts/layout-settings.js"></script>
    <script src="../src/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="../src/plugins/datatables/js/dataTables.responsive.min.js"></script>
    <script src="../src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
    <script src="../src/plugins/sweetalert2/sweetalert2.all.js"></script>
    <script src="../src/plugins/toastr/toastr.min.js"></script>

    <script>
    $(document).on('click', '.update-status', function(e) {
        e.preventDefault();

        var id = $(this).data('id');
        swal({
            title: 'Tandai Telah Selesai ?',
            text: '',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Konfirmasi'
        }).then(function(isConfirmed) {
            if (isConfirmed.value) {
                $.ajax({
                    method: 'POST',
                    url: '<?= BASE_URL . '/admin/pengaduan/update-keluhan.php' ?>',
                    data: {
                        id: id
                    },

                    dataType: 'json',

                    success: function(response) {
                        if ($.isEmptyObject(response.error)) {
                            if (response.success == 1) {

                                var statusElement = $('[data-status-badge]');

                                statusElement.removeClass('badge-info badge-success');
                                statusElement.addClass(response.status == 0 ? 'badge-info' :
                                    'badge-success');
                                statusElement.text(response.status == 0 ? 'Proses' :
                                    'Selesai');
                                $('.update-status').addClass('d-none');
                                $('.hapus').removeClass('d-none');

                                toastr.success(response.msg);

                            } else {
                                console.log(response.error);
                                toastr.error(response.msg);

                            }
                        }

                    }
                });
            }
        });

    });

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
                    url: '<?= BASE_URL . '/admin/pengaduan/hapus-keluhan.php' ?>',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        toastr.success('Berhasil Hapus Data');
                        window.location.href = '<?= BASE_URL . '/admin/pengaduan.php' ?>'
                    }
                })
            }
        })
    });
    </script>

</body>

</html>
