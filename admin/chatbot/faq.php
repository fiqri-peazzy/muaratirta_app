<?php
include("../../path.php");
include(ROOT_PATH . "/app/controllers/chatbot.php");
include(ROOT_PATH . '/app/helpers/middleware.php');
adminOnly();

$all_faq = selectAll('chat_faq');
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Chatbot FAQ | Admin Muaratirta</title>
    <link href="../../assets/logo/Logo-PDAM-MT-min.ico" rel="icon">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />


    <link rel="stylesheet" type="text/css" href="../vendors/styles/core.css" />
    <link rel="stylesheet" type="text/css" href="../vendors/styles/icon-font.min.css" />
    <link rel="stylesheet" type="text/css" href="../src/plugins/datatables/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="../src/plugins/datatables/css/responsive.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="../vendors/styles/style.css" />
    <link rel="stylesheet" href="../src/plugins/sweetalert2/sweetalert2.css">
</head>

<body>
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
                            <h4>Chatbot FAQ</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo BASE_URL . '/admin' ?>">Beranda</a></li>
                                <li class="breadcrumb-item active" aria-current="page">FAQ</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="card-box pd-20 mb-30">
                        <h4 class="h5 mb-20"><?php echo isset($_GET['id']) ? 'Edit' : 'Tambah'; ?> FAQ</h4>
                        <form action="faq.php" method="POST">
                            <?php if (isset($_GET['id'])): ?>
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <?php endif; ?>
                            <div class="form-group">
                                <label>Pertanyaan</label>
                                <textarea name="pertanyaan" class="form-control" rows="3"
                                    required><?php echo $pertanyaan; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Jawaban</label>
                                <textarea name="jawaban" class="form-control" rows="5"
                                    required><?php echo $jawaban; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Status Aktif</label>
                                <select name="is_active" class="form-control">
                                    <option value="1" <?php echo $is_active == 1 ? 'selected' : ''; ?>>Aktif</option>
                                    <option value="0" <?php echo $is_active == 0 ? 'selected' : ''; ?>>Non-Aktif
                                    </option>
                                </select>
                            </div>
                            <div class="btn-list">
                                <button type="submit"
                                    name="<?php echo isset($_GET['id']) ? 'update-faq' : 'add-faq'; ?>"
                                    class="btn btn-primary btn-block">
                                    <?php echo isset($_GET['id']) ? 'Update' : 'Simpan'; ?>
                                </button>
                                <?php if (isset($_GET['id'])): ?>
                                <a href="faq" class="btn btn-outline-secondary btn-block">Batal</a>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card-box pb-10">
                        <div class="pd-20">
                            <h4 class="h5 mb-0">Daftar Pertanyaan & Jawaban</h4>
                        </div>
                        <table class="data-table table nowrap" id="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pertanyaan</th>
                                    <th style="width: 40%">Jawaban</th>
                                    <th>Status</th>
                                    <th class="datatable-nosort">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($all_faq as $key => $f) : ?>
                                <tr id="_<?php echo $f['id'] ?>">
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo substr($f['pertanyaan'], 0, 50) . (strlen($f['pertanyaan']) > 50 ? '...' : ''); ?>
                                    </td>
                                    <td><?php echo substr($f['jawaban'], 0, 100) . (strlen($f['jawaban']) > 100 ? '...' : ''); ?>
                                    </td>
                                    <td>
                                        <span
                                            class="badge badge-pill <?php echo $f['is_active'] ? 'badge-success' : 'badge-danger'; ?>">
                                            <?php echo $f['is_active'] ? 'Aktif' : 'Non-Aktif'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="table-actions">
                                            <a href="faq.php?id=<?php echo $f['id'] ?>" data-color="#265ed7"><i
                                                    class="icon-copy dw dw-edit2"></i></a>
                                            <a href="faq.php?del_faq=<?php echo $f['id'] ?>" class="confirm-delete"
                                                data-color="#e95959"><i class="icon-copy dw dw-delete-3"></i></a>
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

    <script src="../vendors/scripts/core.js"></script>
    <script src="../vendors/scripts/script.min.js"></script>
    <script src="../vendors/scripts/process.js"></script>
    <script src="../vendors/scripts/layout-settings.js"></script>
    <script src="../src/plugins/apexcharts/apexcharts.min.js"></script>
    <script src="../src/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="../src/plugins/datatables/js/dataTables.responsive.min.js"></script>
    <script src="../src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
    <script src="../vendors/scripts/dashboard3.js"></script>
    <script src="../src/plugins/sweetalert2/sweetalert2.all.js"></script>
    <script>
    $(document).on('click', '.confirm-delete', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        swal({
            title: 'Hapus FAQ?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.value) {
                window.location.href = url;
            }
        });
    });
    </script>

    <?php if (isset($_SESSION['message'])) : ?>
    <script>
    swal({
        title: '<?php echo $_SESSION['message'] ?>',
        type: '<?php echo $_SESSION['type'] ?>',
        timer: 3000,
    })
    </script>
    <?php unset($_SESSION['message']);
        unset($_SESSION['type']);
    endif; ?>
</body>

</html>