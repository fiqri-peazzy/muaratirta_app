<?php include("../../path.php"); ?>
<?php
include(ROOT_PATH . "/app/controllers/chatbot.php");
include(ROOT_PATH . '/app/helpers/middleware.php');
adminOnly();

$all_info = selectAll('chat_info');
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Chatbot Info Layanan | Admin Muaratirta</title>
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
                            <h4>Info Layanan Chatbot</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo BASE_URL . '/admin' ?>">Beranda</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Info Layanan</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="card-box pd-20 mb-30">
                        <h4 class="h5 mb-20"><?php echo isset($_GET['info_id']) ? 'Edit' : 'Tambah'; ?> Info</h4>
                        <form action="info.php" method="POST">
                            <?php if (isset($_GET['info_id'])): ?>
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <?php endif; ?>
                            <div class="form-group">
                                <label>Judul Info</label>
                                <input type="text" name="judul" class="form-control" value="<?php echo $judul; ?>"
                                    placeholder="Contoh: Tarif Air" required>
                            </div>
                            <div class="form-group">
                                <label>Konten / Penjelasan</label>
                                <textarea name="konten" class="form-control" rows="10"
                                    required><?php echo $konten; ?></textarea>
                                <small class="form-text text-muted">Akan digunakan AI sebagai referensi jawaban.</small>
                            </div>
                            <div class="btn-list">
                                <button type="submit"
                                    name="<?php echo isset($_GET['info_id']) ? 'update-chat-info' : 'add-chat-info'; ?>"
                                    class="btn btn-primary btn-block">
                                    <?php echo isset($_GET['info_id']) ? 'Update' : 'Simpan'; ?>
                                </button>
                                <?php if (isset($_GET['info_id'])): ?>
                                <a href="info" class="btn btn-outline-secondary btn-block">Batal</a>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card-box pb-10">
                        <div class="pd-20">
                            <h4 class="h5 mb-0">Daftar Informasi Layanan</h4>
                        </div>
                        <table class="data-table table nowrap" id="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Pratinjau Konten</th>
                                    <th class="datatable-nosort">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($all_info as $key => $i) : ?>
                                <tr id="_<?php echo $i['id'] ?>">
                                    <td><?php echo $key + 1; ?></td>
                                    <td><strong><?php echo $i['judul']; ?></strong></td>
                                    <td><?php echo substr($i['konten'], 0, 150) . (strlen($i['konten']) > 150 ? '...' : ''); ?>
                                    </td>
                                    <td>
                                        <div class="table-actions">
                                            <a href="info.php?info_id=<?php echo $i['id'] ?>" data-color="#265ed7"><i
                                                    class="icon-copy dw dw-edit2"></i></a>
                                            <a href="info.php?del_info=<?php echo $i['id'] ?>" class="confirm-delete"
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
            title: 'Hapus Info?',
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