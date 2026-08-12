<?php include("../../path.php"); ?>
<?php
include(ROOT_PATH . "/app/controllers/chatbot.php");
include(ROOT_PATH . '/app/helpers/middleware.php');
adminOnly();

$all_history = selectAll('chat_history', [], 'created_at');
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Riwayat Chatbot | Admin Muaratirta</title>
    <link href="../../assets/logo/Logo-PDAM-MT-min.ico" rel="icon">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="stylesheet" type="text/css" href="../vendors/styles/core.css" />
    <link rel="stylesheet" type="text/css" href="../vendors/styles/icon-font.min.css" />
    <link rel="stylesheet" type="text/css" href="../src/plugins/datatables/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="../src/plugins/datatables/css/responsive.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="../vendors/styles/style.css" />
    <link rel="stylesheet" href="../src/plugins/sweetalert2/sweetalert2.css">
    <style>
    .chat-log {
        max-width: 300px;
        white-space: normal;
        font-size: 0.85rem;
    }

    .bot-text {
        color: #265ed7;
    }

    .user-text {
        color: #555;
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
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Riwayat Percakapan Chatbot</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo BASE_URL . '/admin' ?>">Beranda</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Riwayat Chat</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="card-box pb-10">
                <div class="pd-20">
                    <h4 class="h5 mb-0">Logs Chat (Terbaru)</h4>
                </div>
                <table class="data-table table nowrap" id="table">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Pesan User</th>
                            <th>Respon Bot</th>
                            <th>Intent</th>
                            <th>Sesi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_history as $h) : ?>
                        <tr>
                            <td class="small"><?php echo date('d/m/y H:i', strtotime($h['created_at'])); ?></td>
                            <td>
                                <div class="chat-log user-text"><strong>Q:</strong>
                                    <?php echo htmlspecialchars($h['user_message']); ?></div>
                            </td>
                            <td>
                                <div class="chat-log bot-text"><strong>A:</strong>
                                    <?php echo htmlspecialchars(substr($h['bot_response'], 0, 200)) . (strlen($h['bot_response']) > 200 ? '...' : ''); ?>
                                </div>
                            </td>
                            <td><span class="badge badge-outline-secondary"><?php echo $h['intent']; ?></span></td>
                            <td class="small"><?php echo substr($h['session_id'], -8); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
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
</body>

</html>