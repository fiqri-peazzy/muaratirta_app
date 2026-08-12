<?php
include('../../path.php');
include(ROOT_PATH . '/app/db/db.php');
require ROOT_PATH . '/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;



if (isset($_GET['id'])) {
    $keluhan = selectOne('pengaduan', ['id' => $_GET['id']]);

    date_default_timezone_set('Asia/Jakarta');
    $now = date('d M,Y');


    if (!$keluhan) {
        header('Location:' . BASE_URL . '/404');
        exit();
    }

    $page_title = 'Cetak Keluhan-' . $keluhan['id'];

    $content = '<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . $page_title . '</title>
    <style>
    * {
        margin: 0;
        padding: 0;
    }

    .logo-img {
        padding-top:25px;
        padding-left:28px;
        margin-bottom:20px;    
    }

   
    .container {
        padding-left:24px;
        padding-right:24px;
        
    }

    .table-container {
        width:100%;
    }

    .table1 {
        width: 100%;
        border-collapse: collapse;
        height:280px !important;
    }
    .table1 tr td {
        vertical-align:middle;
        padding-left:8px;
        padding-right:3px;
    }

    </style>
</head>

<body>
    <table border="0" style="width:100%;">
        <tr>
            <td style="width:50%;">
                <div class="logo-img">
                    <img src="' . BASE_URL . '/assets/image/download.png' . '" alt="" srcset="">
                </div>
            </td>
            <td style="width:50%;text-align:right;align-items:center;padding-right:30px;">
            Tgl Cetak :
                ' . $now . '
            </td>
        </tr>
    </table>
    
    <h5 style="text-transform:uppercase; font-size:18px; font-weight:bold; text-align:center;margin-bottom:20px;">Laporan Keluhan Pelanggan</h5>

    <div class="container">
        <div class="table-container">
            <table class="table1" border="1">
                <tr>
                    <td style="height:10px !important;width:16%;text-transform:uppercase;">No. Sambung</td>';
    $foto_extensions = ['jpg', 'jpeg', 'png'];
    if ($keluhan['foto'] !== null && $keluhan['foto'] !== '') {
        $file_extension = strtolower(pathinfo($keluhan['foto'], PATHINFO_EXTENSION));
        $foto_path = ROOT_PATH . '/assets/keluhan/' . $keluhan['foto'];
        if (in_array($file_extension, $foto_extensions) && file_exists($foto_path)) {
            $content .= '<td style="height:16px !important;width:40%;font-weight:bold;">' . $keluhan['id_pel'] . '</td>
                    <td style="width:35%;padding-left:0px !important;padding-right:0px !important;" rowspan="6">
                        <img src="' . BASE_URL . '/assets/keluhan/' . $keluhan['foto'] . '" style="height:320px;max-width:100%;width:100%">
                    </td>';
        } else {
            $content .= '<td style="height:16px !important;width:40%;font-weight:bold;">' . $keluhan['id_pel'] . '</td>
                    <td style="width:35%;height:320px;padding-left:0px !important;padding-right:0px !important;text-align:center;" rowspan="6">
                        Tidak ada gambar di temukan
                    </td>';
        }
    } else {
        $content .= '<td style="height:16px !important;width:40%;font-weight:bold;">' . $keluhan['id_pel'] . '</td>
                    <td style="width:35%;height:320px;padding-left:0px !important;padding-right:0px !important;text-align:center;" rowspan="6">
                        Tidak ada gambar di temukan
                    </td>';
    }

    $content .= '</tr>
                <tr>
                    <td style="height:16px !important;width:16%;text-transform:uppercase;">Nama</td>
                    <td style="height:16px !important;width:40%;">' . $keluhan['nm_lengkap'] . '</td>
                </tr>
                <tr>
                    <td style="height:16px !important;width:16%;text-transform:uppercase;">No HP</td>
                    <td style="height:20px !important;width:40%;">' . $keluhan['no_hp'] . '</td>
                </tr>
                <tr id="alamat">
                    <td style="width:16%;text-transform:uppercase;">Alamat</td>
                    <td style="width:40%;">' . $keluhan['alamat'] . '</td>
                </tr>
                <tr>
                    <td style="width:16%;text-transform:uppercase;">Keluhan</td>
                    <td colspan="1" style="width:40%;padding-top:10px;">' . $keluhan['isi_pengaduan'] . '</td>
                </tr>
                <tr>
                    <td style="width:16%;text-transform:uppercase;">Tgl Keluhan</td>
                    <td colspan="1" style="width:40%;padding-top:10px;">' . $keluhan['created_at'] . '</td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>';
    try {
        $html2pdf = new Html2Pdf('L', 'A5', 'en');
        // $html2pdf->setModeDebug();
        $html2pdf->writeHTML($content);
        $html2pdf->output('keluhan_' . $keluhan['id_pel'] . '.pdf');
    } catch (\Exception $e) {
        error_log('cetak_pengaduan PDF error (id=' . $keluhan['id'] . '): ' . $e->getMessage());
        header('Content-Type: text/plain');
        http_response_code(500);
        echo 'Gagal membuat PDF. Silakan hubungi admin.';
        exit();
    }
} else {
    header('Location:' . BASE_URL . '/404');
    exit();
}