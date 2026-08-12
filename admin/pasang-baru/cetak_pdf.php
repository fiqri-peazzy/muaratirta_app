<?php
include('../../path.php');
include(ROOT_PATH . '/app/db/db.php');
require ROOT_PATH . '/vendor/autoload.php';
require_once ROOT_PATH . '/app/helpers/r2_helper.php';

use Spipu\Html2Pdf\Html2Pdf;

if (isset($_GET['id'])) {
    $info_pendaftar = selectOne('pasang_baru', ['id' => $_GET['id']]);

    if (!$info_pendaftar) {
        header('Location:' . BASE_URL . '/404');
        exit();
    }

    $page_title = 'Cetak Info Pendaftar-' . $info_pendaftar['id'];
    $logo_path = ROOT_PATH . '/assets/image/download.png';

    // Ambil foto KTP/rumah ke file lokal (folder lama atau download dari R2 lewat API)
    // supaya Html2Pdf tidak fetch lewat URL publik yang bisa lambat/hang.
    $temp_files = [];
    $resolveLocalPhoto = function ($fileName) use (&$temp_files) {
        if (empty($fileName)) {
            return '';
        }
        foreach (['assets/daftar-baru'] as $legacyDir) {
            $candidate = ROOT_PATH . '/' . $legacyDir . '/' . $fileName;
            if (file_exists($candidate)) {
                return $candidate;
            }
        }
        $temp = downloadR2ToTemp('daftar-baru', $fileName);
        if ($temp) {
            $temp_files[] = $temp;
            return $temp;
        }
        return '';
    };
    $foto_ktp_path = $resolveLocalPhoto($info_pendaftar['foto_ktp']);
    $foto_rumah_path = $resolveLocalPhoto($info_pendaftar['foto_rumah']);

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
        margin-bottom:40px;    
    }
    </style>
</head>

<body>
    <div class="logo-img">
        <img src="' . $logo_path . '" alt="" srcset="">
    </div>
    <h5 style="text-transform:uppercase; font-size:18px; font-weight:500; text-align:center;margin-bottom:60px;">Form Pendaftaran Sambungan Baru</h5>
    <table border="0" style="width:100%;padding-left:65px;padding-right:65px;">
        <tr>
            <td style="border: 1px solid black; width:47%;height:200px;align-items:center;text-align:center;">
                ' . ($foto_ktp_path !== '' ? '<img src="' . $foto_ktp_path . '" style="max-height:200px;max-width:100%">' : 'Tidak ada gambar di temukan') . '
            </td>
            <td style="width: 4%;"></td>
            <td style="border: 1px solid black; width:47%;height:200px;align-items:center;text-align:center;">
                ' . ($foto_rumah_path !== '' ? '<img src="' . $foto_rumah_path . '" style="max-height:200px;max-width:100%">' : 'Tidak ada gambar di temukan') . '
            </td>


        </tr>
    </table>
    <table style="width:100%;padding-left:65px;padding-right:65px; margin-top:50px;border-spacing:60px;">
        <tr>
            <td style="width:20%; height:40px; font-size:15px;">Alamat</td>
            <td style="height:40px;font-weight:700;">:</td>
            <td style="width:78% ;padding-left:8px;">' . $info_pendaftar['alamat'] . '</td>
        </tr>
        <tr></tr>
        <tr style="margin-bottom:24px;">
            <td style="height:40px;width:20%;font-size:15px;">No.Handphone</td>
            <td style="height:40px;font-weight:700;">:</td>
            <td style="padding-left:8px;">' . $info_pendaftar['no_hp'] . '</td>
        </tr>
        <tr style="margin-bottom:24px;">
            <td style="height:40px;width:20%;font-size:15px;">Biaya Registrasi</td>
            <td style="height:40px;font-weight:700;">:</td>
            <td style="height:40px;padding-left:8px;"> Rp.20.000</td>
        </tr>
        
    </table>
    

    <table style="width:100%;padding-left:65px;padding-right:65px; margin-top:50px;border-spacing:60px;">
        
        <tr>
            <td style="width:100%;font-size:15px;"><h5 style=" font-size:14px; font-weight:500;margin-bottom:10px;margin-left:65px;padding-left:65px;">Hasil Survey dilokasi</h5></td>
            <td style="font-weight:700;">:</td>
            <td></td>
        </tr>
    
        
    </table>
    <table style="width:100%;padding-left:65px;padding-right:65px; margin-top:10px;border-spacing:60px;">
        
        <tr>
            <td style="border:1px solid black; width:80%;height:180px;align-items:center;text-align:center;"></td>
            <td style="border:1px solid black; width:20%;height:180px;align-items:center;text-align:center;">
                <h6 style="margin-bottom:14px">Scan Untuk GMAPS </h6>
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . urlencode('https://www.google.com/maps?q=' . str_replace(' ', '+', $info_pendaftar['alamat'])) . '" alt="qr-gmaps">
            </td>
           
        </tr>
    
        
    </table>

    <table style="width:100%;padding-left:65px;padding-right:65px; margin-top:40px;">
        
        <tr>
            
            <td style="width:43%;height:100px;text-align: center; vertical-align: text-top"></td>
            <td style="width:43%;height:100px;text-align: center; vertical-align: text-top"></td>
            <td style="border-bottom: 1px solid black; width:15%;height:100px;text-align: center; vertical-align: text-top">Petugas</td>
           
        </tr>
    
        
    </table>

</body>

</html>

';


    try {
        $html2pdf = new Html2Pdf('P', 'A4', 'en');
        // $html2pdf->setModeDebug();
        $html2pdf->writeHTML($content);
        $html2pdf->output('info_pendaftar_' . $info_pendaftar['id'] . '.pdf');
    } catch (\Throwable $e) {
        error_log('cetak_pdf pasang-baru error (id=' . $info_pendaftar['id'] . '): ' . $e->getMessage());
        header('Content-Type: text/plain');
        http_response_code(500);
        echo 'Gagal membuat PDF. Silakan hubungi admin.';
        exit();
    } finally {
        foreach ($temp_files as $temp_file) {
            if (file_exists($temp_file)) {
                unlink($temp_file);
            }
        }
    }
} else {
    header('Location:' . BASE_URL . '/404');
    exit();
}