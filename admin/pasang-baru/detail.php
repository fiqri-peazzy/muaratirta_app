<?php include('../../path.php'); ?>
<?php include(ROOT_PATH . '/app/controllers/info.php'); ?>
<?php
include(ROOT_PATH . '/app/helpers/middleware.php');
adminOnly();

if (empty($_GET['id']) && $_GET['id'] === null) {
    header('Location:' . BASE_URL . '/404');
} else {
    $pasang_baru = selectOne('pasang_baru', ['id' => $_GET['id']]);
    if ($pasang_baru == null) {
        header('Location:' . BASE_URL . '/404');
    }
}

if ($pasang_baru['latitude'] == null && $pasang_baru['longitude'] == null) {
    $q = $pasang_baru['alamat'];
} else {
    $q = $pasang_baru['latitude'] . ',' . $pasang_baru['longitude'];
}

$no_pendaftaran = 'PB-' . str_pad($pasang_baru['id'], 5, '0', STR_PAD_LEFT);
$foto_ktp_url = resolveImageUrl($pasang_baru['foto_ktp'], 'daftar-baru', ['assets/daftar-baru']);
$foto_rumah_url = resolveImageUrl($pasang_baru['foto_rumah'], 'daftar-baru', ['assets/daftar-baru']);

?>

<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title>
        <?php echo isset($_GET['page-title']) && $_GET['page-title'] !== '' ? htmlspecialchars($_GET['page-title']) : 'Detail Pendaftaran Baru | Muaratirta Kota Gorontalo'; ?>
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
    .pb-card {
        border: 1px solid #eef0f3;
        border-radius: 10px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 1px 3px rgba(20, 30, 60, 0.05);
        height: 100%;
    }

    .pb-card-header {
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

    .pb-card-body {
        padding: 14px;
    }

    .pb-info-row {
        display: flex;
        align-items: flex-start;
        padding: 7px 0;
        border-bottom: 1px dashed #eef0f3;
    }

    .pb-info-row:last-child {
        border-bottom: none;
    }

    .pb-info-icon {
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

    .pb-info-label {
        font-size: 11px;
        color: #8a94a6;
        margin-bottom: 1px;
    }

    .pb-info-value {
        font-size: 13px;
        font-weight: 500;
        color: #2b3648;
        word-break: break-word;
    }

    .pb-photo-frame {
        width: 100%;
        height: 170px;
        border: 1px solid #eef0f3;
        border-radius: 8px;
        background: #f9fafb;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .pb-photo-frame img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .pb-photo-empty {
        text-align: center;
        color: #b0b8c4;
        font-size: 12px;
    }

    .pb-photo-empty i {
        font-size: 26px;
        display: block;
        margin-bottom: 6px;
    }

    .pb-no-pendaftaran {
        font-size: 17px;
        font-weight: 700;
        color: #1c3f7c;
        letter-spacing: 0.5px;
    }

    .pb-badge {
        font-size: 11px;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 30px;
    }

    .pb-map-frame {
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #eef0f3;
        line-height: 0;
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
                            <h4 class="mb-1">Detail Pendaftaran Baru</h4>
                        </div>
                        <div class="d-flex align-items-center flex-wrap" style="gap:12px;">
                            <span class="pb-no-pendaftaran"><?= $no_pendaftaran ?></span>
                            <span class="pb-badge badge-<?= $pasang_baru['tindak_lanjut'] == 0 ? 'info' : 'success' ?>"
                                data-status-badge>
                                <?= $pasang_baru['tindak_lanjut'] == 0 ? 'Dalam Proses' : 'Selesai' ?>
                            </span>
                            <span class="text-muted" style="font-size:12px;">
                                <i class="fa fa-calendar"></i>
                                <?= date('d M Y, H:i', strtotime($pasang_baru['created_at'])) ?>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-12 text-md-right mt-3 mt-md-0">
                        <a href="<?php echo BASE_URL . '/admin/pasang-baru/cetak_pdf.php?id=' . $pasang_baru['id'] ?>"
                            target="_blank" class="btn btn-primary">
                            <i class="fa fa-print"></i> Cetak PDF
                        </a>
                        <a href="#" data-id="<?= $pasang_baru['id'] ?>"
                            class="btn btn-primary update-status <?= $pasang_baru['tindak_lanjut'] == 1 ? 'd-none' : '' ?>">
                            <i class="fa fa-check"></i> Tandai Selesai
                        </a>
                        <a href="#" data-id="<?= $pasang_baru['id'] ?>"
                            class="btn btn-danger hapus <?= $pasang_baru['tindak_lanjut'] == 0 ? 'd-none' : '' ?>">
                            <i class="fa fa-trash"></i> Hapus
                        </a>
                    </div>
                </div>
            </div>

            <!-- ===== DATA PEMOHON + LOKASI (satu card, padat) ===== -->
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="pb-card">
                        <div class="pb-card-header"><i class="fa fa-user-circle"></i> Data Pemohon &amp; Lokasi</div>
                        <div class="pb-card-body">
                            <div class="row">
                                <div class="col-lg-5 col-12">
                                    <div class="pb-info-row">
                                        <div class="pb-info-icon"><i class="fa fa-phone"></i></div>
                                        <div>
                                            <div class="pb-info-label">No. HP / WhatsApp</div>
                                            <div class="pb-info-value"><?= htmlspecialchars($pasang_baru['no_hp']) ?></div>
                                        </div>
                                    </div>
                                    <div class="pb-info-row">
                                        <div class="pb-info-icon"><i class="fa fa-map-marker"></i></div>
                                        <div>
                                            <div class="pb-info-label">Alamat Lengkap</div>
                                            <div class="pb-info-value"><?= htmlspecialchars($pasang_baru['alamat']) ?></div>
                                        </div>
                                    </div>
                                    <div class="pb-info-row">
                                        <div class="pb-info-icon"><i class="fa fa-money"></i></div>
                                        <div>
                                            <div class="pb-info-label">Biaya Registrasi</div>
                                            <div class="pb-info-value">Rp 20.000</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-7 col-12 mt-3 mt-lg-0">
                                    <div class="row align-items-center">
                                        <div class="col-md-8 col-12 mb-3 mb-md-0">
                                            <div class="pb-map-frame">
                                                <iframe
                                                    src="https://www.google.com/maps?q=<?= urlencode($q) ?>&h1=es;z=14&output=embed"
                                                    frameborder="0" width="100%" height="150px"></iframe>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12 text-center">
                                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=110x110&data=<?= urlencode('https://www.google.com/maps?q=' . str_replace(' ', '+', $pasang_baru['alamat'])) ?>"
                                                alt="qr-gmaps" class="img-fluid" style="max-width:110px;">
                                            <div class="text-muted mt-1" style="font-size:11px;">Scan Gmaps</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===== DOKUMENTASI ===== -->
            <div class="row">
                <div class="col-lg-6 col-12 mb-3">
                    <div class="pb-card">
                        <div class="pb-card-header"><i class="fa fa-id-card"></i> Foto KTP</div>
                        <div class="pb-card-body">
                            <div class="pb-photo-frame">
                                <?php if ($foto_ktp_url !== '') : ?>
                                <a href="<?= $foto_ktp_url ?>" target="_blank" title="Lihat ukuran penuh">
                                    <img src="<?= $foto_ktp_url ?>" alt="Foto KTP">
                                </a>
                                <?php else : ?>
                                <div class="pb-photo-empty"><i class="fa fa-image"></i>Tidak ada foto</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12 mb-3">
                    <div class="pb-card">
                        <div class="pb-card-header"><i class="fa fa-home"></i> Foto Rumah</div>
                        <div class="pb-card-body">
                            <div class="pb-photo-frame">
                                <?php if ($foto_rumah_url !== '') : ?>
                                <a href="<?= $foto_rumah_url ?>" target="_blank" title="Lihat ukuran penuh">
                                    <img src="<?= $foto_rumah_url ?>" alt="Foto Rumah">
                                </a>
                                <?php else : ?>
                                <div class="pb-photo-empty"><i class="fa fa-image"></i>Tidak ada foto</div>
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
                    url: '<?= BASE_URL . '/admin/pasang-baru/update-p-baru.php' ?>',
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
                                statusElement.text(response.status == 0 ? 'Dalam Proses' :
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
                        id_p: id
                    },
                    success: function(response) {
                        toastr.success('Berhasil Hapus Data');
                        window.location.href = '<?= BASE_URL . '/admin/pasang-baru.php' ?>'
                    }
                })
            }
        })
    });
    </script>
    <script>
    <?php if (isset($_SESSION['message']) && $_SESSION['type']) : ?>
    var pesan = '<?php echo $_SESSION['message'] ?>'
    var type = '<?php echo $_SESSION['type'] ?>'

    swal({
        text: pesan,
        type: type,
    });

    <?php
            unset($_SESSION['message']);
            unset($_SESSION['type']);

            ?>


    <?php endif; ?>
    </script>
</body>

</html>
